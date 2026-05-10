# RULES.md — Refactoring Rules

## MVC Rules

### Views
- A view file contains only HTML and `<?= $variable ?>` echoes
- No `if/else` that computes something — only `if/else` that toggles display
- No `foreach` that transforms data — only `foreach` that renders already-prepared data
- No `function` declarations
- No model calls (`new Model()`, `model()`)
- No hardcoded strings that should come from DB
- Allowed: `<?= $variable ?>`, `<?php foreach ($items as $item): ?>`, `<?php if ($condition): ?>`

### Controllers
- One controller per feature domain (RegimeController, ProfileController, etc.)
- Each method: load model → get data → pass to view. That's it.
- No SQL strings
- No business logic (calculations, comparisons)
- No `echo` or direct output
- Data passed to views must be fully ready — no processing left for the view

### Models
- All DB queries live here
- All data transformation/computation lives here
- Use CodeIgniter Query Builder only — no raw SQL strings unless absolutely necessary
- Each method has one clear responsibility
- Model injection via `model(ModelName::class)` in constructor — never inside a method body

---

## CSS Rules

### File structure
```
public/assets/css/
├── variables.css       ← design tokens only
├── global.css          ← reset, base typography, utility classes
├── frontoffice.css     ← frontoffice layout and components
├── backoffice.css      ← backoffice layout and components
├── landing.css         ← landing page specific
└── auth.css            ← login/register pages
```

### Design tokens (variables.css must define all of these)
```css
:root {
  /* Colors */
  --color-primary: ;
  --color-primary-dark: ;
  --color-accent: ;
  --color-success: ;
  --color-danger: ;
  --color-warning: ;
  --color-text: ;
  --color-text-muted: ;
  --color-bg: ;
  --color-surface: ;
  --color-border: ;

  /* Typography */
  --font-base: 'Inter', sans-serif;
  --text-sm: 0.875rem;
  --text-base: 1rem;
  --text-lg: 1.125rem;
  --text-xl: 1.25rem;
  --text-2xl: 1.5rem;
  --text-3xl: 2rem;
  --text-4xl: 2.5rem;

  /* Spacing */
  --space-1: 0.25rem;
  --space-2: 0.5rem;
  --space-3: 0.75rem;
  --space-4: 1rem;
  --space-6: 1.5rem;
  --space-8: 2rem;
  --space-12: 3rem;
  --space-16: 4rem;

  /* Layout */
  --radius-sm: 6px;
  --radius-md: 12px;
  --radius-lg: 20px;
  --shadow-sm: 0 1px 3px rgba(0,0,0,.08);
  --shadow-md: 0 4px 16px rgba(0,0,0,.12);
  --container-max: 1200px;
}
```

### Forbidden
- `<style>` tags inside any view file
- Inline `style=""` attributes (except truly dynamic values like chart colors)
- Bootstrap or any external CSS CDN
- Pixel values for font sizes (use rem)
- Fixed heights on containers (use min-height or padding)

---

## JS Rules

### File structure
```
public/assets/js/
├── global.js           ← shared utilities (flash dismiss, mobile menu toggle)
├── frontoffice.js      ← frontoffice interactions
├── backoffice.js       ← backoffice interactions (sidebar toggle, etc.)
├── charts.js           ← all chart rendering functions
├── auth.js             ← register multi-step, password toggle, IMC live calc
└── regime.js           ← regime suggestion filters, purchase flow
```

### Rules
- No `<script>` blocks inside views except data injection: `const chartData = <?= $chart_data ?>;`
- No anonymous self-invoking functions directly in views
- Chart data comes from controller as `json_encode()` — JS only reads and renders it
- Event listeners use `addEventListener`, never inline `onclick=""`
- All JS files imported at bottom of layout before `</body>`

---

## UI/UX Rules

### Mobile first
- Base styles are for mobile (≤ 768px)
- Desktop styles inside `@media (min-width: 768px)`
- No horizontal scroll on any screen size
- Touch targets minimum 44px height

### Components
- Cards: `border-radius: var(--radius-md)`, `box-shadow: var(--shadow-sm)`, `padding: var(--space-6)`
- Buttons: primary, secondary, danger — defined in `global.css`, never re-declared per page
- Tables: responsive — wrap in `.table-wrapper` with `overflow-x: auto`
- Forms: consistent input height, focus ring using `--color-primary`
- Badges: small, pill-shaped, color-coded

### Backoffice
- Sidebar navigation on desktop, hamburger on mobile
- Consistent page header: title + subtitle + optional action button
- Dashboard cards show: nb utilisateurs, nb gold, chiffre d'affaires, nb commandes
- All charts rendered via `charts.js`, data from controller

### Frontoffice
- Navbar: logo left, nav links center/right, auth buttons right
- Every page has a clear page header section
- Regime cards show: name, variation poids badge, price starting from lowest duration

### Landing page sections order
1. Navbar
2. Hero (title + subtitle + CTA + hero image)
3. Stats bar
4. Features cards
5. How it works (3 steps)
6. Featured regimes (from DB)
7. Testimonials
8. Final CTA
9. Footer

---

## General Rules
- Never leave commented-out code blocks
- Never leave `var_dump`, `print_r`, `dd()` in any file
- Every route must point to an existing controller method
- Every controller method must point to an existing view
- Delete any file with no route pointing to it
- `$indexPage = ''` in `App.php` — no `index.php` in URLs
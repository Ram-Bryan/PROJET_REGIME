# GOAL.md — Refactoring Objectives

## Primary Goal
Refactor a messy CodeIgniter 4 diet app into a clean, professional, mobile-first MVC application. The UI must feel like a real modern SaaS product. The code must be clean enough for a beginner to read and maintain.

## Step 1 — Restructure the folder architecture
Reorganize `app/Views/` into this exact structure:

```
app/Views/
├── backoffice/
│   ├── layout.php
│   ├── partials/
│   │   ├── sidebar.php
│   │   ├── navbar.php
│   │   └── footer.php
│   ├── dashboard/
│   │   └── index.php
│   ├── regime/
│   │   ├── index.php
│   │   ├── create.php
│   │   ├── edit.php
│   │   └── show.php
│   ├── activite/
│   │   ├── index.php
│   │   ├── create.php
│   │   └── edit.php
│   ├── utilisateur/
│   │   ├── index.php
│   │   └── show.php
│   ├── promo/
│   │   ├── index.php
│   │   └── validate.php
│   ├── option/
│   │   ├── index.php
│   │   └── edit.php
│   └── imc/
│       ├── index.php
│       └── edit.php
│
├── frontoffice/
│   ├── layout.php
│   ├── partials/
│   │   ├── navbar.php
│   │   └── footer.php
│   ├── home/
│   │   └── index.php        ← Landing page (NEW)
│   ├── regime/
│   │   ├── index.php
│   │   ├── show.php
│   │   ├── purchase.php
│   │   └── my_regimes.php
│   ├── profile/
│   │   ├── view.php
│   │   └── edit.php
│   ├── dashboard/
│   │   └── index.php
│   ├── transactions/
│   │   └── index.php
│   └── options/
│       └── index.php
│
├── auth/
│   ├── login.php
│   ├── register_personal.php
│   └── register_health.php
│
└── errors/
    └── html/
        ├── error_404.php
        └── error_exception.php
```

Delete `welcome_message.php` and any other unused files.
Update all controller `return view(...)` calls to match the new paths.

## Step 2 — Fix MVC violations
Go through every view file and:
- Move any PHP logic (loops for computing, conditionals that process data, functions) to the controller
- Move any SQL or model calls out of views entirely
- Move any hardcoded backend data (regime composition table, IMC ranges, etc.) to be fetched from DB via model
- Pass all needed data from controller to view via `$data[]`

## Step 3 — Fix CSS
- Create `public/assets/css/variables.css` with all design tokens (colors, spacing, typography, radius, shadows)
- Create `public/assets/css/global.css` importing variables and defining base resets, typography, utility classes
- Create `public/assets/css/frontoffice.css` for frontoffice-specific styles
- Create `public/assets/css/backoffice.css` for backoffice-specific styles
- Create page-specific CSS files only when truly needed (e.g. `landing.css`)
- Delete every `<style>` block from every view
- Delete Bootstrap CDN from `admin/login.php`
- Both layouts import `variables.css` and `global.css` — they share the same token system

## Step 4 — Fix JS
- Move all JS to `public/assets/js/`
- Create `public/assets/js/frontoffice.js` and `public/assets/js/backoffice.js` for shared interactions
- Chart data must come from controller: `$data['chart_data'] = json_encode($model->getChartData())`
- In the view: `const data = <?= $chart_data ?>` — only this one line is allowed in the view
- Create `public/assets/js/charts.js` for all chart rendering logic
- Remove all inline `<script>` blocks from views

## Step 5 — Rebuild the UI
Rebuild every page from scratch with a professional, clean, mobile-first design.

### Landing Page (NEW — `frontoffice/home/index.php`)
Must contain these sections in order:
1. **Header**: logo + login/register/admin links
2. **Hero**: big title, subtitle, CTA button, hero image (`public/assets/img/hero.png`)
3. **Stats**: +200 utilisateurs, +50 régimes, +10 activités (fetched from DB)
4. **Features**: cards with icons from `public/assets/icons/` — IMC, régimes, activités, suivi
5. **How It Works**: 3 steps — Créer profil → Choisir objectif → Choisir régime
6. **Featured Regimes**: cards fetched from DB (no hardcode)
7. **Testimonials**: can be hardcoded in controller as an array
8. **Final CTA**: "Prêt à commencer ?" + register button
9. **Footer**: logo, links, copyright

### Backoffice Dashboard additions
Add a **Chiffre d'affaires** trend chart: date on X axis, total amount earned on Y axis. Data fetched from `commande` table grouped by date.

### All pages
- Mobile first
- Use design tokens from `variables.css`
- Use Lucide icons from `public/assets/icons/`
- No hardcoded content unless it is truly static (footer copyright, step labels)
- Images from `public/assets/img/`

## Step 6 — Fix the URL index.php issue
Ensure `public/.htaccess` correctly removes `index.php` from all URLs:
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php/$1 [L]
```
And confirm `app/Config/App.php` has `$indexPage = ''`.

## Step 7 — Clean up
- Delete all files that have no route pointing to them
- Delete `welcome_message.php`
- Delete all `<style>` and `<script>` blocks remaining in views
- Confirm no model is instantiated inside another model's method body (use constructor injection via `model()`)
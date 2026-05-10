# UI Overhaul — Clean, Pro, Mobile-First, Green Primary

## Goal

Rebuild **all CSS files** and **clean all view files** to produce a professional, unified UI across frontoffice, backoffice, and auth. Green primary color. Mobile-first. Zero `<style>` tags or inline styles in views. Separated CSS files (SOC).

> [!IMPORTANT]
> **No logic changes.** Only UI (HTML classes + CSS) is being touched. No controller/model/route changes.

## Current Problems

1. **[variables.css](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/public/assets/css/variables.css)** uses violet/blue primary (`--primary-h: 247`) — unused, conflicts with [global.css](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/public/assets/css/global.css)
2. **[global.css](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/public/assets/css/global.css)** has its own `:root` with green vars — duplicated, 651 lines, mixes frontoffice + shared styles
3. **[backoffice.css](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/public/assets/css/backoffice.css)** has its own `:root` block — duplicates and overrides global vars
4. **[frontoffice.css](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/public/assets/css/frontoffice.css)** references variables from [variables.css](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/public/assets/css/variables.css) that don't match [global.css](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/public/assets/css/global.css)
5. **[landing.css](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/public/assets/css/landing.css)** references non-existent CSS variables (`--color-primary`, `--space-16`, etc.)
6. **Auth views** have massive inline styles (`style="..."` on every element)
7. **Home/landing** ([frontoffice/home/index.php](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/app/Views/frontoffice/home/index.php)) — all inline styles, no CSS classes
8. **[admin_login.php](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/app/Views/auth/admin_login.php)** uses Bootstrap CDN + Font Awesome CDN — violates project rules
9. **No working mobile hamburger menu** in frontoffice layout
10. **Frontoffice layout** embeds nav + JS directly — no partials used

---

## Proposed Changes

### CSS Layer (6 files to rewrite)

#### [MODIFY] [variables.css](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/public/assets/css/variables.css)

**Single source of truth for all design tokens.** Rewrite to use green HSL primary:
- `--primary-h: 155; --primary-s: 65%; --primary-l: 34%` → `#1f8f6a`
- Remove old violet/blue values
- Keep spacing, radius, shadow, animation tokens
- Add `--container-max`, `--sidebar-width`, `--navbar-height`

---

#### [MODIFY] [global.css](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/public/assets/css/global.css)

**Shared base styles for both front/backoffice.** Remove the `:root` block (tokens live in [variables.css](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/public/assets/css/variables.css)). Keep only:
- Reset (`*`, `body`, `a`)
- Typography (`.sub`, `.page-header`)
- Layout (`.stack`, `.shell`, `.grid`, `.grid-2`, `.grid-3`)
- Components (`.card`, `.btn`, `.btn-secondary`, `.badge`, `.alert`, `.form-feedback`, `.field-error`, `.metric-grid`, `.metric-card`, `.table-wrap`, `table`)
- Forms (`input`, `select`, `label`, `.radio-group`, `.radio-item`, `.field-hint`, `.field-wrap`)
- Modal (`.confirm-modal`, `.confirm-card`)
- Responsive base media queries

---

#### [MODIFY] [frontoffice.css](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/public/assets/css/frontoffice.css)

**Styles specific to the client-facing layout.** Rewrite to:
- `.topbar` with glassmorphism, `.fo-brand` with green dot
- **Mobile hamburger menu** (`.mobile-menu-btn`, `.nav.is-open`)
- `.hero` section with green gradient
- `.hero-actions` layout
- `.fo-footer`, `.fo-footer-inner`, `.fo-footer-bottom`
- All landing page classes (`.landing-hero`, `.features-grid`, `.how-steps`, `.regime-card`, `.cta-section`, `.stats-bar`, `.testimonials-grid`)
- Gold option styles (`.gold-card`, `.gold-grid`, `.gold-spec`, `.gold-note`)
- Promo styles (`.history-list`, `.history-item`, `.history-status`, `.promo-kicker`)
- `.option-card`, `.option-header`, `.option-meta`
- Mobile-first responsive breakpoints

---

#### [MODIFY] [backoffice.css](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/public/assets/css/backoffice.css)

**Admin panel specific styles.** Remove `:root` block. Rewrite to:
- `.admin-shell` layout
- `.sidebar` (dark nav background, green accent active link)
- `.content` area
- `.page-head` header
- `.flash-stack` alerts
- `.stats-grid`, `.stat-box` variants for dashboard
- `.dashboard-hero` welcome card
- Pie chart (`.pie-chart-container`, `.pie-chart`, `.pie-legend`)
- Composition chart (`.composition-cell`, `.composition-chart`, `.composition-tooltip`, `.composition-legend`)
- Duration table (`.duration-status`, `.filter-pair`, `.filters-grid`)
- `.choice-grid`, `.choice`, `.choice-card`
- Delete confirm overlay (`.confirm-overlay`)
- Mobile sidebar collapse

---

#### [MODIFY] [auth.css](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/public/assets/css/auth.css)

**Auth pages (login, register, admin login).** Rewrite to:
- `.auth-page` full-page centered layout with green gradient bg
- `.auth-shell` glass card split layout
- `.auth-promo` left panel with green gradient
- `.auth-form-panel` right panel
- `.auth-progress` step bar with green fill
- `.eye-btn` password toggle
- `.recap-grid`, `.recap-item` for step 3
- Mobile: stack to single column

---

#### [MODIFY] [landing.css](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/public/assets/css/landing.css)

**Landing/home page.** Merge into [frontoffice.css](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/public/assets/css/frontoffice.css) since they share the same layout. Delete this file or keep minimal. The landing-specific classes will live in [frontoffice.css](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/public/assets/css/frontoffice.css).

---

### Views Layer (HTML cleanup, no style tags)

#### Auth Views (3 files)

| File | Changes |
|------|---------|
| [login.php](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/app/Views/auth/login.php) | Remove all inline `style=""`. Use auth CSS classes. Use `auth/layout` instead of `frontoffice/layout`. |
| [register_personal.php](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/app/Views/auth/register_personal.php) | Remove inline styles. Use `.auth-progress`, `.auth-promo`, `.auth-form-panel` classes. Use `auth/layout`. |
| [register_health.php](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/app/Views/auth/register_health.php) | Remove inline styles. Use `.auth-progress` bar classes. Use `auth/layout`. |
| [admin_login.php](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/app/Views/auth/admin_login.php) | **Full rewrite.** Remove Bootstrap/Font Awesome CDNs. Use `auth/layout` + auth.css classes. Same visual as client login but with admin badge. |

#### Frontoffice Layout + Partials (3 files)

| File | Changes |
|------|---------|
| [layout.php](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/app/Views/frontoffice/layout.php) | Include [variables.css](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/public/assets/css/variables.css) + [global.css](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/public/assets/css/global.css) + [frontoffice.css](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/public/assets/css/frontoffice.css). Use `<?= $this->include('frontoffice/partials/navbar') ?>` and `<?= $this->include('frontoffice/partials/footer') ?>`. Keep confirm modal + JS. |
| [navbar.php](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/app/Views/frontoffice/partials/navbar.php) | Add hamburger button toggle for mobile. Already clean. |
| [footer.php](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/app/Views/frontoffice/partials/footer.php) | Already clean. No changes needed. |

#### Frontoffice Content Views (12 files)

| File | Changes |
|------|---------|
| [home/index.php](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/app/Views/frontoffice/home/index.php) | **Full rewrite.** Remove all inline styles. Use `.landing-hero`, `.features-grid`, `.feature-card`, `.cta-section` classes. Use images from `public/assets/img/`. |
| [dashboard/index.php](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/app/Views/frontoffice/dashboard/index.php) | Remove inline `style=""` from hero-actions. Minor cleanup. |
| [profile/view.php](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/app/Views/frontoffice/profile/view.php) | Remove inline `style="position:relative; z-index:1;"`. |
| [profile/edit.php](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/app/Views/frontoffice/profile/edit.php) | Remove `style="max-width:980px; margin: 0 auto;"`. Use CSS class. |
| [regime/index.php](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/app/Views/frontoffice/regime/index.php) | Remove inline styles from hero. |
| [regime/show.php](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/app/Views/frontoffice/regime/show.php) | Remove inline styles from headings, lists, and price spans. |
| [regime/purchase.php](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/app/Views/frontoffice/regime/purchase.php) | Remove inline styles from section wrapper. |
| [regime/my_regimes.php](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/app/Views/frontoffice/regime/my_regimes.php) | Remove inline styles from hero. |
| [regime/my_regime_detail.php](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/app/Views/frontoffice/regime/my_regime_detail.php) | Remove inline styles from hero-actions and list. |
| [options/index.php](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/app/Views/frontoffice/options/index.php) | Remove inline styles from gold headings and notes. |
| [transactions/index.php](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/app/Views/frontoffice/transactions/index.php) | Remove inline styles from hero. |
| [promo/index.php](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/app/Views/frontoffice/promo/index.php) | Remove inline styles from hero and promo card. |

#### Backoffice Layout + Views (14 files)

| File | Changes |
|------|---------|
| [layout.php](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/app/Views/backoffice/layout.php) | Include `variables.css` + `global.css` + `backoffice.css`. Add mobile sidebar toggle button. |
| [dashboard/index.php](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/app/Views/backoffice/dashboard/index.php) | Remove `style="margin-top:18px"` etc. Use CSS classes. |
| [regime/index.php](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/app/Views/backoffice/regime/index.php) | Remove inline styles from flex containers. |
| [regime/form.php](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/app/Views/backoffice/regime/form.php) | Remove inline styles from section headers, actions. |
| [regime/show.php](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/app/Views/backoffice/regime/show.php) | Minor inline style removal. |
| [activite/index.php](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/app/Views/backoffice/activite/index.php) | Clean inline styles. |
| [activite/form.php](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/app/Views/backoffice/activite/form.php) | Clean inline styles. |
| [activite/show.php](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/app/Views/backoffice/activite/show.php) | Clean inline styles. |
| [promo/index.php](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/app/Views/backoffice/promo/index.php) | Clean inline styles. |
| [promo/form.php](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/app/Views/backoffice/promo/form.php) | Clean inline styles. |
| [promo/validate.php](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/app/Views/backoffice/promo/validate.php) | Clean inline styles. |
| [option/index.php](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/app/Views/backoffice/option/index.php) | Clean inline styles. |
| [imc/index.php](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/app/Views/backoffice/imc/index.php) | Clean inline styles. |
| [utilisateur/index.php](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/app/Views/backoffice/utilisateur/index.php) | Clean inline styles. |

#### Auth Layout (1 file)

| File | Changes |
|------|---------|
| [auth/layout.php](file:///e:/Dossier_Bryan/ITU/S4/SI/PROJET_REGIME/app/Views/auth/layout.php) | Include `variables.css` + `global.css` + `auth.css`. |

---

## Execution Order

1. Rewrite `variables.css` (design tokens)
2. Rewrite `global.css` (shared components)
3. Rewrite `auth.css` (auth pages)
4. Rewrite `frontoffice.css` (absorb `landing.css`)
5. Rewrite `backoffice.css` (admin panel)
6. Update `auth/layout.php` to use correct CSS imports
7. Update `frontoffice/layout.php` to use partials + correct CSS imports
8. Update `backoffice/layout.php` to use correct CSS imports
9. Rewrite `admin_login.php` (remove CDNs)
10. Clean all auth views (remove inline styles)
11. Rewrite `home/index.php` (landing page with images)
12. Clean all frontoffice content views
13. Clean all backoffice content views
14. Delete duplicate/unused views (`frontoffice/option/`, `frontoffice/transaction/`)

## Verification Plan

### Manual Verification

Since this is a pure CSS/HTML change, it needs visual verification:

1. **User should run the dev server** (`php spark serve`)
2. **Check the following pages and confirm they look professional with green theme:**
   - `/` — Landing page (hero with images, features, CTA)
   - `/login` — Client login (green gradient promo panel)
   - `/register` — Registration step 1 (green progress bar)
   - `/admin/login` — Admin login (no Bootstrap, green theme)
   - `/dashboard` — Client dashboard (green hero, metric cards)
   - `/profile` — Profile view (clean cards)
   - `/regimes` — Regime list (clean table)
   - `/admin/dashboard` — Admin dashboard (sidebar with green accents)
   - `/admin/regimes` — Admin regime list (matching design)
3. **Mobile test** — Resize browser to 375px width:
   - Hamburger menu appears and works on frontoffice
   - Sidebar collapses on backoffice
   - All cards/tables scroll horizontally
   - No horizontal overflow on body
4. **Zero `<style>` tags** — Run: `grep -r "<style" app/Views/ --include="*.php" -l` → should return 0 results
5. **Zero CDN imports** — Run: `grep -r "cdnjs\|cdn\|bootstrap\|font-awesome" app/Views/ --include="*.php" -l` → should return 0 results

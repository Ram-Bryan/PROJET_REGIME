# UI Structure & Views State (Projet Regime)

This document lists the state and architectural behavior of all active UI views across the web application. It acts as a reference point for any upcoming UI refactoring.

## 1. Global CSS & Layout Architecture
The project currently does **NOT** use external CSS frameworks like Bootstrap or Tailwind CSS (except for `admin/login.php` which imports Bootstrap via CDN) but relies entirely on a **vanilla CSS and Custom Custom Variables** based system tightly coupled with the views.

### 1.1 layout/main.php (Public/User Layout)
- **Purpose**: This is the master wrapper for all public-facing and authenticated user views (Dashboard, Profil, Regime, Transactions). 
- **CSS**: Contains a massive `<style>` block (approx. 650 lines) that defines global root variables (`--bg`, `--primary`, `--success-bg`, etc.), global typography (Inter font family), responsive grids (`.grid`, `.metric-grid`), customized forms (`input`, `.radio-item`), utility `.card` classes, and animations (`.form-feedback`, modals).
- **Core Sections defined via CodeIgniter `extend()`**:
    - `title`: Meta page title.
    - `head`: Additional inline styles specific to a child view.
    - `content`: The main wrapper block (`<main class="shell stack">`).
    - `scripts`: Page-specific JS.

### 1.2 admin/layout.php (Admin Layout)
- **Purpose**: Wrapping layout for the entire Admin backend panel (`/admin/*`).
- **CSS**: Contains its own massive `<style>` block (~550 lines) completely separated from `layout/main.php`. It defines a unique sidebar-based interface with distinct color token names (`--nav`, `--accent`, `--surface-soft`) and utility classes like `.admin-shell`, `.sidebar`, `.content`.
- **Core Sections defined**:
    - `title`: Meta page title.
    - `head`: Embedded custom CSS.
    - `page_title`: Output via `<h1>` inside the top content wrapper.
    - `page_subtitle`: Description text for the current view.
    - `page_actions`: E.g., "Add new item" button placed right next to the title.
    - `content`: Flash messages auto-displayed inside`.flash-stack`, followed by the custom HTML.
    - `scripts`: Embedded custom JS.

---

## 2. Directory & View Breakdown

### 2.1 Auth Views (`app/Views/auth/`)
- **Files**: `login.php`, `register_personal.php`, `register_health.php`
- **Layout used**: `layouts/main.php`
- **Structure**: 
  - Uses a split-grid container (`.auth-grid`) displaying marketing text/badges on the left, and standard HTML forms with `.form-feedback` driven validation on the right. 
  - JS injected into `scripts` to toggle password visibility.

### 2.2 Client User Interface (`app/Views/profile/`, `app/Views/regime/`, `app/Views/transactions/`, `dashboard.php`)
- **Layout used**: `layouts/main.php`
- **Structure**:
  - Follows a consistent layout with a Hero header at the top (`.hero`, `.page-header`, `.hero-actions`).
  - Below the hero, `.metric-grid` is heavily utilized to show KPIs (e.g. Profil user stats, Dashboard current IMC).
  - Data listing is usually rendered inside `.card` wrappers with standard HTML `<table>` structures.
  - Page specific styles (e.g. radio buttons UI adjustments or metrics overlapping) are stored directly inside the `head` section of the corresponding files.

### 2.3 Admin Application (`app/Views/admin/`)
- **Sub-folders**: `activites`, `options`, `promos`, `regimes`, `utilisateurs`, `imc`
- **Layout used**: `admin/layout.php` (except `admin/login.php` which uses raw HTML + Bootstrap CDN).
- **Structure**:
  - **CRUD Index Views** (`admin/*/index.php`): Typically render a `.card` wrapper encompassing an HTML `<table>`. Often leverages `.badge` classes for displaying status elements (like Gold, Normal etc).
  - **CRUD Edit/Form/Show Views** (`admin/*/form.php`, `show.php`, etc.): Wrap forms with live JS feedback. They use `.grid-2`, `.grid-3` to manage inputs elegantly. 

## 3. Pain Points & Refactor Target
- **CSS Duplication**: There are two massive chunks of CSS in two separate `layout` files. They share very similar designs but distinct token variables.
- **Inline Head Styling**: Each view dumps inline CSS inside `<style>` tags directly into the `<head>` component.
- **Third-Party Inclusion**: `admin/login.php` forces Bootstrap inclusion out of nowhere causing UI fragmentation compared to the rest of the Vanilla CSS project.
- **Responsiveness**: Hardcoded grids mapping `grid-2` break on intermediate viewport widths if not strictly maintained.

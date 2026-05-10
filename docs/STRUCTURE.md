# Frontoffice Structure

The Frontoffice is aimed at our clients. It follows a clean `frontoffice/layout.php` template which dynamically requires the navigation and footer.

### Layout Details (`frontoffice/layout.php`)
- **Partials Used**: `frontoffice/partials/navbar.php` (Header) and `frontoffice/partials/footer.php` (Footer).
- **CSS Linked**: `global.css`, `frontoffice.css`.
- **Purpose**: Wraps all client-facing pages logically, injecting `$title` and `$activeNav`. 

### Home (`home/index.php`)
- **Purpose**: Landing page explaining the business and showcasing top diets.
- **Sections**: 
  - Hero Section (Call to Action, visual hook).
  - Featured Regimes (Cards showing minimum price, variation info).
  - Value Proposition (Why choose us).

### Dashboard (`dashboard/index.php`)
- **Purpose**: Primary hub for logged-in clients. 
- **Sections**: 
  - Welcome Banner with User summary.
  - Active Diet Display.
  - Quick action buttons (My Profile, Code Promo).
  
### Regimes (`regime/`)
- `index.php`: List of all available diets (Cards/Grid layout) with filtering capabilities.
- `show.php`: Deep-dive into a specific diet's composition and duration pricing. 
- `purchase.php`: Checkout page to confirm buying a diet.
- `my_regimes.php`: List of previously purchased/active diets for the user.
- `my_regime_detail.php`: Drill-down tracking view of a currently active diet.

### Options & Promo (`options/`, `promo/`)
- `options/index.php`: Viewing and purchasing meal delivery frequency (Portefeuille/Delivery).
- `promo/index.php`: Input field and history of promo code submissions by the user.

### Transactions (`transactions/index.php`)
- **Purpose**: Account wallet management.
- **Sections**: History of deposits/withdrawals, current wallet balance.

---

# Backoffice Structure 

The Backoffice is designed for administrators to govern content and users. Built around `backoffice/layout.php`.

### Layout Details (`backoffice/layout.php`)
- **Partials Used**: `backoffice/partials/sidebar.php` (Sidebar collapsing navigation).
- **CSS Linked**: `global.css`, `backoffice.css`.
- **Purpose**: A two-column admin design housing the main content on the right and navigation on the left.

### Dashboard (`dashboard/index.php`)
- **Purpose**: High-level statistical overview of platform health.
- **Sections**:
  - Key Performance Indicators (Total Users, Gold Members, Revenue).
  - Charts (Objective Distribution Pie, Revenue Trend Chart).

### CRUD Resources (Regimes, Activites, Options, IMC)
- Each entity has three primary UI states:
  - `index.php`: Data Table listing all records, often featuring quick filters and an "Add New" button.
  - `form.php`: Combined Create/Edit forms utilizing unified backend validation blocks.
  - `show.php`: Detailed view mapping relationships (e.g., viewing an Activity shows which Regimes use it).

### Utilisateur Management (`utilisateur/`)
- `index.php`: Data table of all standard users.
- `show.php`: Detailed drill-down of a user, displaying their current wallet, IMC status, and complete order history.

### Promo Validation (`promo/validate.php`)
- **Purpose**: Administrative tool to approve/deny requested promo codes from users. 

---

# Auth Structure

The Authentication module routes the initial user entry. Found in the `auth/` directory.

### Layout Details
- Standalone pages designed for maximum conversion without distraction. Only link authentication styles.
- **CSS Linked**: `global.css`, `auth.css`.

### Login (`login.php` & `admin_login.php`)
- Clean, centered authentications cards.
- **Sections**: Email/Password inputs, login buttons, links to registration.

### Registration (`register_personal.php` & `register_health.php`)
- Multi-step registration flow.
- Health metrics tracking (Target Weight, IMC Calculation setup).

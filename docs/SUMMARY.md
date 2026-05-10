# SUMMARY.md — Project Overview

## What this project is
A web application for selecting a personalized diet plan based on the user's health profile and objectives. Built with CodeIgniter 4 and MySQL. No external CSS or JS frameworks. Vanilla everything.

## Who uses it

### Clients (frontoffice)
- Register in 2 steps: personal info (name, email, gender, birthdate) then health info (height, weight)
- System calculates their BMI and pre-selects a logical objective
- They choose a regime from suggestions, pick a duration, and pay from their wallet
- They can top up their wallet with promo codes
- They can buy the Gold option once (20,000 Ar) for 15% discount on all regimes

### Admins (backoffice)
- Manage regimes (name, weight variation, % meat/fish/poultry, durations + prices)
- Manage sport activities (linked to regimes)
- Manage promo codes (validate, create)
- Manage Gold option parameters
- Manage IMC ranges
- View dashboard with stats and charts

## Database — Key tables
- `utilisateur` — users (clients + admins)
- `objectif` — 3 objectives: perte de poids, prise de masse, IMC idéal
- `regime` — diet plans with weight variation and composition %
- `activite_sportive` — sport activities linked to regimes via `regime_activite`
- `duree_regime` — available durations per regime with price
- `commande` — purchase history
- `code_promo` — promo codes for wallet top-up
- `option` — Gold option config
- `imc` — BMI ranges with labels (Poids normal = 18.5 to 24.99, etc.)

## Suggestion algorithm
1. Calculate user BMI from height + weight
2. Filter regimes by `variation_poids` direction based on objective:
   - Objectif 1 (perte de poids) → `variation_poids < 0`
   - Objectif 2 (prise de masse) → `variation_poids > 0`
   - Objectif 3 (IMC idéal) → compare BMI to ideal range from `imc` table, then filter accordingly
3. User picks a regime → sees available durations → pays

## Current problems (why we are refactoring)
- PHP logic and data processing inside view files
- Hardcoded regime composition data in views instead of fetching from DB
- Chart rendering logic embedded inside view files
- Two massive separate CSS blocks in two layout files, duplicated and inconsistent
- Inline `<style>` blocks in almost every view
- Bootstrap CDN imported only on admin login page, inconsistent with rest of app
- JS logic scattered inside view files
- Folder structure is flat and inconsistent — no clear frontoffice/backoffice separation
- No landing page
- `index.php` appearing in URLs on some routes
- Models instantiated inside other model methods instead of constructor injection

## Assets location
- Images: `public/assets/img/` (hero.png, meal1.png, meal2.png, sport images)
- Icons: `public/assets/icons/` (Lucide icon SVGs)
- CSS: `public/assets/css/` (to be properly organized)
- JS: `public/assets/js/` (to be properly organized)

## Tech stack
- PHP 8+ / CodeIgniter 4
- MySQL
- Vanilla CSS with custom properties
- Vanilla JS
- No CDN, no external dependencies
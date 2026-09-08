# VortexCloud Frontend Design System & UI Guidelines (`AGENTS.md`)

This document establishes the mandatory design system rules and visual identity for all frontend development in this project. All future UI components, pages, forms, and views MUST adhere strictly to these guidelines.

---

## 1. Design System Identity: "Cosmic Violet & Clean SaaS"
* **Philosophy**: High-impact modern cloud infrastructure aesthetic combining deep cosmic dark stage accents with an ultra-clean, high-performance light-mode B2B interface.
* **Aesthetics**: Pure white and soft slate layered surfaces, generous whitespace, structural clarity defined by thin light-slate borders, cosmic violet highlights, and electric royal purple conversion triggers.
* **Component Feel**: Premium, enterprise-grade, fast-loading, highly accessible, and responsive across mobile, tablet, and desktop viewports.

---

## 2. Color Palette & 60-30-10 Distribution

### 60% Dominant Color (Canvas & Base Surfaces)
* **Pure White (`#FFFFFF`)**: Primary page background, card surfaces, content wrappers, and active input fields.
* **Soft Slate Gray (`#F8FAFC` / `bg-slate-50`)**: Alternate layout sections, FAQ accordions, metric badges, hardware spec tables, and subtle background fills.
* **Dividers & Structural Borders (`#E2E8F0` / `border-slate-200` & `#F1F5F9` / `border-slate-100`)**: Thin, crisp 1px structural borders defining card boundaries and containers.

### 30% Secondary Color (Structure, Typography & Visual Anchors)
* **Deep Cosmic Obsidian Base (`#120024` / `#16042E`)**: Dark hero section canvas, floating glass header backdrop, mega dropdown containers, and footer base.
* **Deep Slate Navy (`#0F172A` / `text-slate-900`)**: Main headlines (H1, H2, H3), plan tier titles, pricing values, and strong emphasis text.
* **Slate Grey (`#475569` / `text-slate-600`)**: High-contrast, easily readable body copy, subheadlines, descriptions, and technical specifications.
* **Muted Slate (`#64748B` / `text-slate-500`)**: Captions, timestamps, secondary labels, and inactive icon strokes.

### 10% Accent Color (Action Items & High-Energy Focus)
* **Electric Royal Purple (`#673DE6` / `bg-[#673DE6]`, `text-[#673DE6]`)**: Applied strictly to primary Call-to-Action (CTA) buttons, highlighted keywords, active tabs, most popular plan cards, and focus rings.
* **Hover State Accent Violet (`#5428D8` / `hover:bg-[#5428D8]`)**: Smooth hover transitions for interactive buttons.
* **Accent Glow / Shadow (`rgba(103, 61, 230, 0.25)` / `shadow-[#673DE6]/25`)**: Luminous colored elevation glow behind primary action triggers.
* **Status Success Emerald (`#10B981` / `emerald-500`)**: Operational indicators, live network ping dots, and feature checkmarks.

---

## 3. Typography & Text Hierarchy
* **Global Font**: Google Font **Inter** (`font-sans`) applied across all body and heading elements.
* **Monospace Font**: **JetBrains Mono** / `font-mono` for terminal preview blocks, API keys, and server CLI commands.
* **Headings (H1, H2, H3)**: Bold to Extrabold (`font-bold` / `font-extrabold`), with tight letter-spacing (`tracking-tight`).
* **Leading & Line Heights**: Generous leading (`leading-relaxed` / `leading-snug`) to maximize legibility.

---

## 4. Spacing & Container Rules
* **Section Containers**: `w-full max-w-[1680px] mx-auto px-4 sm:px-8 lg:px-12 xl:px-16` to provide spacious, enterprise-grade breathing room on wide screens.
* **Grid Structures**: Balanced matrices (`grid grid-cols-1 md:grid-cols-3 gap-8` or `grid-cols-4`) with responsive collapsing for mobile.
* **Card Padding**: Generous internal spacing (`p-6 sm:p-8 rounded-2xl` or `rounded-3xl`).

---

## 5. Interactive Components & Micro-Interactions
* **Primary CTA Buttons**:
  ```html
  class="bg-[#673DE6] hover:bg-[#5428D8] text-white font-bold px-6 py-3.5 rounded-xl shadow-lg shadow-[#673DE6]/25 hover:-translate-y-0.5 transition-all duration-200 inline-flex items-center justify-center gap-2"
  ```
* **Secondary / Outline Buttons**:
  ```html
  class="bg-white hover:bg-slate-50 text-slate-700 hover:text-slate-900 border border-slate-200 hover:border-slate-300 font-semibold px-6 py-3.5 rounded-xl transition-all duration-200 inline-flex items-center justify-center gap-2"
  ```
* **Featured / Most Popular Pricing Card**:
  - Elevated shadow (`shadow-xl shadow-slate-200/80`)
  - Subtle top accent border (`border-t-2 border-[#673DE6]` or `border-[#673DE6]`)
  - Absolute pill badge (`bg-purple-50 text-[#673DE6] border border-purple-200 text-xs font-bold uppercase tracking-wider px-3 py-1 rounded-full`)
* **Uptime Pulse Indicator**:
  - Relative container with a steady green dot inside an `animate-ping` ping ring (`h-2.5 w-2.5 rounded-full bg-emerald-500`).

---

## 6. Mandatory Section Structure (Landing Page Standard)
1. **Hero Section**: Centered grand stage layout with top search capsule, 2-line H1 headline, pure white primary CTA, 4-card interactive preview deck, and Trustpilot rating strip.
2. **Pricing Matrix**: Positioned directly below the hero section. Dynamic 4-tier cards using `<x-pricing-card>` with real-time billing switcher (`pt-6 sm:pt-8` on grid).
3. **Hardware Partners**: "Enterprise Hardware You Can Trust." Minimalist gray-scaled logo text cards (`AMD EPYC™`, `Intel® Xeon® Scalable`, `Samsung® Gen4 Enterprise NVMe`, `KVM Architecture`).
4. **Why Choose Us**: 3-pillar feature grid (99.99% Uptime with ping indicator, Enterprise DDoS, 24/7 Expert Support).
5. **Customer Reviews**: 3-column developer testimonial masonry grid with 5-star graphics, italic quotes, and bold names.
6. **Technical FAQ**: Clean `#FFFFFF` or `#F8FAFC` background with smooth interactive expanding accordions.
7. **Final Conversion CTA**: Striking Cosmic Violet card (`#1A0038` to `#220044`) with ambient purple/fuchsia glows, pure white headline, live setup capsule pill, and high-contrast white "Get Started Instantly" button.

---

## 7. Component Architecture & SEO Engine Standards
* **Master Layout (`<x-app-layout>`)**: All frontend views must extend `<x-app-layout>` and declare their page-specific parameters:
  ```blade
  <x-app-layout 
      title="Page Title" 
      description="Compelling meta description under 160 characters." 
      keywords="targeted, keywords"
      headerVariant="hero|solid|minimal"
      robots="index, follow|noindex, nofollow">
  ```
* **Header Standards (`<x-header>`)**:
  - `headerVariant="hero"`: Transparent floating navbar transitioning to frosted glass on scroll (used on homepage).
  - `headerVariant="solid"`: Pre-activated dark frosted glass navbar with automatic top spacing (`pt-20 sm:pt-22`) for inner pages (`/plans`, knowledgebase, legal).
  - `headerVariant="minimal"`: Distraction-free header with logo & SSL security badge for `/checkout` and auth pages.
  - **Auth Button Standard**: Single unified **`[ 👤 Login / Register ]`** button (`bg-[#673DE6] hover:bg-[#5428D8] text-white px-4 py-2.5 rounded-xl shadow-lg shadow-[#673DE6]/25`) for guests; **`[ 👤 Client Area ]`** for logged-in clients. Never include redundant "Deploy VPS" pills in the header.
* **Unified Pricing Matrix Component (`<x-pricing-matrix>`)**:
  - Always use `<x-pricing-matrix :packages="$packages" />` on any page displaying pricing tiers.
  - Encapsulates the entire pricing table system into a single reusable component:
    1. The 3-option billing cycle switcher (`1 Month`, `12 Months`, `24 Months`)
    2. The 4-column responsive grid looping over `<x-pricing-card>`
    3. The self-contained reactive JavaScript controller (`setMatrixBillingCycle`)
  - **Single Point of Maintenance**: Modifying billing cycles, discounts, button styles, or cards in `<x-pricing-matrix>` or `<x-pricing-card>` automatically updates every page across the entire website without needing to edit individual views.
* **Reusable Pricing Card Component (`<x-pricing-card>`)**:
  - Always use `<x-pricing-card :package="$package" :isPopular="$isPopular" :delayClass="$delayClass" badgeText="Most Popular" />` inside pricing loops.
  - **Badge Unclipped Rule**: Outer card container must **NEVER** have `overflow-hidden` (otherwise `-top-3.5` badges get chopped off). Ambient glows are strictly restricted inside an inner `<div class="absolute inset-0 overflow-hidden rounded-3xl pointer-events-none">`.
  - **Grid Headroom Rule**: Pricing grids must always include `pt-6 sm:pt-8` so elevated `-translate-y-3` cards and top badges have ample breathing room.
* **3-Option Billing Cycle Standard (`1 Month`, `12 Months`, `24 Months`)**:
  - All pricing tables and catalogs must provide the unified 3-option switcher:
    - **1 Month**: Standard rate (`data-1month`).
    - **12 Months (1 Year)**: 15% discount applied (`data-12months`), badge: "Renews every 12 months (15% off applied)".
    - **24 Months (2 Years)**: 20% discount applied (`data-24months`), badge: "Renews every 24 months (20% off applied)".
  - Switcher Container: `inline-flex items-center p-1.5 rounded-2xl bg-slate-200/80 border border-slate-300/80 shadow-inner flex-wrap justify-center gap-1`.
  - Active Switcher Button: `bg-[#673DE6] text-white shadow-md shadow-[#673DE6]/25 px-4 sm:px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold`.
* **Checkout Flow & Dynamic Billing Cycle Propagation**:
  - The "Choose Plan" buttons dynamically update their query parameter (`?cycle=monthly`, `?cycle=annually`, `?cycle=biennially`) when users interact with the billing switcher.
  - The Checkout page (`/checkout/{package}`) automatically pre-selects and checks the exact billing period the user chose.
  - The Datacenter Region selection cards must feature high-fidelity vector SVG country flags (e.g. 🇺🇸 US, 🇩🇪 DE, 🇬🇧 UK, 🇸🇬 SG) with region names, city codes, and active ping latency badges.
* **Floating Capsule Sub-Menu (Hostinger Pattern)**:
  - Sticky sub-menus must use a centered floating dark pill capsule (`sticky top-20 z-30 py-3 flex justify-center pointer-events-none` with inner `pointer-events-auto rounded-full bg-[#16002C]/90 backdrop-blur-xl border border-white/15 shadow-2xl shadow-purple-950/70`).
  - Active item: Solid white rounded pill with dark text (`bg-white text-[#120024] font-bold px-5 py-2 rounded-full shadow-md`).
  - Inactive items: Muted slate text (`text-slate-300 hover:text-white hover:bg-white/10 px-4 py-2 rounded-full`).
  - Scrollspy: Include auto-updating scrollspy to highlight the active section pill dynamically.
* **Modular Components**:
  - `<x-seo-meta>`: Handles OpenGraph, Twitter Cards, Canonical URLs, CSRF meta tokens, and global `Organization` / `WebSite` JSON-LD schemas.
  - `<x-analytics>`: Safe Google Analytics (GA4) / Tag Manager tracking.
  - `<x-flash-messages>`: Floating dismissible toast notifications for `session('success')` and `session('error')`.
  - `<x-footer>`: 5-column B2B footer with operational 99.99% uptime status.
* **Page-Specific Schemas (`<x-slot:schema>`)**:
  - Use `<x-slot:schema>` for rich search snippets (`Product` / `AggregateOffer` for pricing catalogs, `FAQPage` for FAQ accordions).

---

## 8. Mandatory Animation & Micro-Interaction Standards
Every newly added page, section, card grid, or interactive component **MUST AUTOMATICALLY** include these animation tokens without requiring additional user prompting:

### 1. Scroll-Reveal System (All Sections & Cards)
* **Section Headers & Single Containers**:
  - Must include `reveal-init` class (e.g. `<div class="reveal-init text-center mb-16">...</div>`).
* **Grid Items & Cards (Staggered Entrance)**:
  - Must include `reveal-init delay-100`, `reveal-init delay-200`, `reveal-init delay-300`, `reveal-init delay-400` across sequential columns/cards for a staggered cascade effect.

### 2. Interactive Card Dynamics (`card-interactive`)
* **Standard Cards**:
  - Must include `card-interactive` class:
    ```html
    class="reveal-init delay-100 card-interactive bg-white rounded-3xl p-7 border border-slate-200 shadow-soft-sm hover:shadow-soft-md hover:border-purple-200 transition-all duration-300 group"
    ```
  - Child icons/badges should use `group-hover:scale-110 group-hover:text-[#673DE6] transition-all duration-300`.

### 3. CTA & Button Shimmer (`btn-shimmer`)
* **All Primary Buttons & Conversion Triggers**:
  - Must include `btn-shimmer`:
    ```html
    class="btn-shimmer bg-[#673DE6] hover:bg-[#5428D8] text-white font-bold py-3.5 px-6 rounded-xl shadow-xl shadow-[#673DE6]/25 hover:scale-[1.02] active:scale-[0.98] transition-all duration-200"
    ```

### 4. Ambient Stage Lighting (Hero & Dark Sections)
* **Floating Ambient Light Blobs**:
  - Dark containers must feature animated background glows:
    - Blob 1: `animate-float-slow`
    - Blob 2: `animate-float-reverse`
    - Blob 3: `animate-pulse-glow`

### 5. Page Opening Hero Elements
* **Initial Viewport Elements**:
  - Must use `animate-fade-in-up` with staggered inline styles (`style="animation-delay: 150ms;"`, `style="animation-delay: 250ms;"`).

---

## 9. Filament Table & Details Page Action Standards (Admin & Customer Panels)
* **List Views / Table Rows Standard (`recordActions`)**:
  - In all resource list views and tables across both Admin and Customer panels, table row actions must **ONLY contain the `View` button** (`ViewAction::make()`).
  - **NEVER** place operational triggers, external verification buttons, deployment actions, or edit/delete triggers directly inside table row columns (e.g., no `Approve & Deploy`, `Verify Explorer`, `Pay Now`, `Edit`, or `Delete` in the table row).
  - This maintains a clean, distraction-free table layout, prevents accidental trigger clicks, and eliminates horizontal table bloat.
* **Details Page Standard (`ViewRecord` / `getHeaderActions()` & Infolists)**:
  - **ALL** operational, financial, verification, and destructive actions must reside exclusively inside the record's details page (`ViewRecord` header actions or infolist actions).
  - **Primary Actions**: (e.g. `Approve & Deploy`, `Verify Explorer`, `Pay Invoice Now`) must be placed in `getHeaderActions()` with appropriate state visibility filters (`visible(fn () => ...)`).
  - **Secondary / Destructive Actions**: (e.g. `Cancel`, `Edit`, `Delete`) must be organized inside an `ActionGroup::make([...])` labeled `"More Actions"` with an ellipsis icon.
  - **Inline Field Actions**: Use `suffixAction(...)` directly on specific infolist entries (e.g., blockchain explorer links next to TxID hashes) for contextual convenience.

---

## 10. Code Hygiene, Dead Code Removal & Runtime Integrity Standards
* **Dead & Unused Code Elimination**:
  - Whenever refactoring, updating, or fixing Blade views, components, controllers, scripts, or styles, **ALWAYS completely remove unused, obsolete, commented-out, or dead code**.
  - Never leave behind orphaned DOM queries, legacy variables, or superseded handlers from prior iterations.
* **DOM Reference & Element ID Integrity**:
  - Every DOM query (e.g., `document.getElementById()`, `querySelector()`) must strictly target elements that actually exist in the current markup.
  - When refactoring form inputs or layout containers (e.g., switching from single inputs to radio groups or dynamic modals), immediately clean up all JavaScript references that targeted the old IDs to avoid `null` dereference crashes.
* **Null-Safety & Scope Verification**:
  - Always guard DOM element access with null checks prior to modifying properties, values, or class lists (e.g., `const el = document.getElementById('...'); if (el) { ... }`).
  - Never reference undeclared or implicit global variables. All variables must be properly declared and scoped (`const`, `let`) with valid fallbacks.
* **Event Binding Completeness**:
  - Any inline event handler declared in HTML/Blade (such as `onclick`, `onchange`, `onsubmit`) must have a corresponding, fully implemented function in the associated script. Never leave orphan handler references that result in `ReferenceError`.
* **State & Modal Lifecycle Consistency**:
  - Ensure modal, dropdown, and event lifecycles do not contain premature dismissal calls (e.g. closing a modal inside an item-selection function before the user confirms) that break user flows or prevent elements from rendering.

---

## 11. Environment Configuration (`.env` & `.env.example`) Synchronization Standards
* **Mandatory Synchronization**:
  - Whenever any new environment variable, configuration key, or toggle is added, modified, renamed, or referenced via `env(...)` in the codebase or in `.env`, the **exact same key MUST IMMEDIATELY be added to `.env.example`**.
  - No pull request, feature branch, or refactor is considered complete if `.env` and `.env.example` are out of sync.
* **Security & Secret Sanitization**:
  - **NEVER** expose real private keys, live credentials, production database passwords, or secret tokens in `.env.example`.
  - Always use clear, standardized dummy placeholders (e.g. `your_api_key_here`, `0x0000000000000000000000000000000000000000`, `sk_test_your_secret_key`).
* **Sectional Grouping & Clarity**:
  - Maintain structured headings and explanatory comments inside `.env.example` (e.g. `# Payment Gateways`, `# Contabo API Credentials`, `# Manual Crypto Wallets`, `# Demo Authentication`) so new developers and automated CI/CD pipelines have complete clarity on configuration requirements.

---

## 12. Contabo API Architecture & OpenAPI Specification Compliance Standard
* **Local Specification as Single Source of Truth (SSOT)**:
  - The official Contabo OpenAPI 3.0.3 specification is permanently stored in the project at `docs/contabo-api.json`.
  - **MANDATORY**: Any and all API-related development, provisioning services, payload construction, power management, and database catalog mapping MUST be cross-referenced and validated directly against `docs/contabo-api.json`.
* **VPS Product ID Mapping Standards**:
  - All VPS packages in database seeders, forms, and provisioning payloads MUST use the exact Contabo `productId` defined in `docs/contabo-api.json`:
    - Cloud VPS 4: `V153` (100 GB SSD)
    - Cloud VPS 6: `V154` (200 GB SSD)
    - Cloud VPS 8: `V155` (300 GB SSD)
    - Cloud VPS 12: `V156` (400 GB SSD)
    - Cloud VPS 16: `V157` (500 GB SSD)
    - Cloud VPS 18: `V158` (600 GB SSD)
* **Datacenter Region Enum Standards**:
  - Region identifiers sent to `POST /v1/compute/instances` must strictly adhere to the allowed OpenAPI enum: `EU`, `US-central`, `US-east`, `US-west`, `SIN`, `UK`, `AUS`, `JPN`, `IND`. Never use non-spec region codes (e.g. always use `UK`, never `GBR`).
* **Instance Lifecycle & Power Actions**:
  - Power and maintenance actions must strictly use the dedicated Contabo sub-resource endpoints:
    - Power On: `POST /v1/compute/instances/{instanceId}/actions/start`
    - Power Off: `POST /v1/compute/instances/{instanceId}/actions/stop`
    - ACPI Shutdown: `POST /v1/compute/instances/{instanceId}/actions/shutdown`
    - Reboot / Restart: `POST /v1/compute/instances/{instanceId}/actions/restart`
    - Rescue Mode: `POST /v1/compute/instances/{instanceId}/actions/rescue`
    - Reset Root/Admin Password: `POST /v1/compute/instances/{instanceId}/actions/resetPassword`
    - Reinstall OS: `PUT /v1/compute/instances/{instanceId}`
    - Cancel Instance: `POST /v1/compute/instances/{instanceId}/cancel`
* **Pre-Commit API Verification & Confirmation**:
  - Whenever updating any Contabo API provisioning service, queue job, controller, or Filament action, verify that:
    1. The HTTP verb and URI path match `docs/contabo-api.json`.
    2. The request body matches the schema properties and required fields.
    3. The response structure and error handling check both HTTP status codes and `message`/`errors` arrays.
  - Confirm API synchronization in each relevant task summary.

---

## 13. 100% Brand White-Labeling & Upstream Provider Anonymity Standard
* **Absolute Provider Secrecy**:
  - Under **NO circumstances** may "Contabo" (or any other third-party upstream supplier, infrastructure host, or datacenter partner) ever be named, referenced, or hinted at in customer-facing views, legal agreements, marketing copy, HTML comments, error messages, or meta tags.
  - The customer-facing brand is strictly **VortexCloud**.
  - All datacenter facilities and hypervisors must be described using generic enterprise phrasing: *"our certified Tier-3 and Tier-4 global datacenter facilities and enterprise NVMe cloud nodes"*.
* **Code Isolation**:
  - Provider names (like `ContaboProvisioningService`) are strictly restricted to backend service classes and admin panels. Never expose these service identifiers in client routes, API responses, or customer panel views.

---

## 14. Legal, Compliance & AUP Architecture Standard
* **Mandatory Legal Suite**:
  - The platform must permanently maintain three dedicated, high-typography legal views extending `<x-app-layout headerVariant="solid">`:
    - `/privacy-policy`: Comprehensive GDPR & CCPA compliant data handling, encryption, and subject rights.
    - `/terms-of-service`: Core master contract including mandatory AUP and non-refund clauses.
    - `/cookie-policy`: Detailed explanation of Essential, Analytics, and Marketing cookies with an interactive settings trigger.
* **Acceptable Use Policy (AUP) Enforcement**:
  - All server instances are subject to a strict, non-negotiable Acceptable Use Policy that explicitly bans:
    1. **Cryptocurrency Mining**: PoW algorithms, Monero/Bitcoin miners, or high-compute blockchain validation.
    2. **DDoS & Stressing**: Originating, amplifying, or participating in denial of service attacks, booter/stresser scripts, or packet storms.
    3. **Port Scanning & Probing**: Masscan, Nmap sweeping, banner grabbing, or unauthorized vulnerability assessment.
    4. **Phishing & Fraud**: Fake banking portals, cloned login forms, social engineering, or deceptive redirect chains.
    5. **Spam & Bulk Mail**: Unsolicited commercial email (UCE), open relays, or actions causing IP blacklisting on Spamhaus/RBLs.
    6. **Malware & Botnets**: Trojans, keyloggers, C2 servers, or ransomware payloads.
* **Digital Goods Non-Refund & Cancellation Standard**:
  - Cloud VPS servers are instantly allocated digital computing goods with immediate operational costs (vCPU reservation, physical RAM lock, IPv4 route propagation).
  - **All sales are final upon server provisioning.** No prorated cash refunds are granted for early cancellation.
  - Platform provisioning failures on our side lasting more than 24 hours are credited to internal account balances or original payment methods.

---

## 15. Frictionless Checkout vs. Registration Consent Separation Standard
* **Checkout Page (`/checkout/*`)**:
  - The checkout and payment screens must remain **100% frictionless and clean**.
  - **NEVER** place legal agreement checkboxes, AUP warnings, or refund disclaimers on checkout or payment views. This prevents cart abandonment and maintains maximum conversion.
* **Registration Page (`/customer/register`)**:
  - Account creation is the **sole mandatory touchpoint** for legal agreement collection.
  - The customer registration form must include a required terms checkbox:  
    `[✓] I have read and agree to the Terms of Service and Privacy Policy.`
  - The checkbox must feature direct clickable links to `/terms-of-service` and `/privacy-policy`.

---

## 16. Cookie Consent & Consent-Gated Tracking Standard
* **Free, Open-Source Engine**:
  - Cookie consent is powered by `vanilla-cookieconsent` (v3). No paid subscriptions, no monthly pageview caps, and no third-party branding.
* **Visual Identity & Placement**:
  - **Position**: Strictly anchored to the **bottom left** (`position: 'bottom left'`), preserving clean breathing room for footer and interactive widgets.
  - **Styling**: Styled as a clean, high-contrast SaaS card: Pure white surface (`#FFFFFF`), crisp slate border (`#E2E8F0`), deep navy typography (`#0F172A`), electric royal purple primary CTA (`#673DE6`), and high-contrast soft-slate secondary buttons (`#F8FAFC`, border `#CBD5E1`, text `#0F172A`) ensuring 100% effortless legibility.
* **Consent-Gated Script Execution**:
  - All third-party analytics and tracking scripts (GA4, GTM, Meta Pixel) in `<x-analytics>` must use `type="text/plain" data-category="analytics"` or `data-category="marketing"`.
  - Scripts must not execute until the visitor grants explicit affirmative consent.
  - If tracking IDs in `.env` are empty, zero scripts and zero console errors should be emitted.
* **Persistent Settings Trigger**:
  - A permanent "Cookie Preferences" link must exist in `<x-footer>` and on `/cookie-policy` allowing users to reopen the preferences modal at any time (`CookieConsent.showPreferences()`).

---

## 17. SEO Crawling, Sitemap & Search Engine Verification Standard
* **Search Bot Directives (`public/robots.txt`)**:
  - Must explicitly allow all public pages: `/`, `/plans`, `/privacy-policy`, `/terms-of-service`, `/cookie-policy`.
  - Must explicitly disallow private and transaction endpoints: `/admin/`, `/customer/`, `/checkout/`, `/stripe/`.
  - Must declare the absolute XML sitemap URL: `Sitemap: <APP_URL>/sitemap.xml`.
* **Dynamic XML Sitemap (`/sitemap.xml`)**:
  - Must dynamically generate valid XML (`text/xml`) containing all main public pages, legal policies, and active VPS product catalog endpoints with accurate `changefreq` and `priority`.
* **Search Console Verification**:
  - `<x-seo-meta>` must automatically inject `<meta name="google-site-verification">` and `<meta name="msvalidate.01">` whenever `GOOGLE_SITE_VERIFICATION` or `BING_SITE_VERIFICATION` are defined in `.env`.

---
*Note: Any subsequent frontend pages, Filament resources, customer dashboards, admin panels, and backend services must inherit these exact design tokens, animation standards, color ratios, component architecture standards, floating capsule navigation, `<x-pricing-card>` rules, Filament table/details action separation rules, code hygiene/dead code elimination standards, .env/.env.example synchronization rules, Contabo OpenAPI compliance rules, white-labeling rules, legal & AUP architecture, frictionless checkout rules, and cookie consent standards.*




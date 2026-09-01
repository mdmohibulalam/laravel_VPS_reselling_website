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
2. **Hardware Partners**: Minimalist gray-scaled logo text cards (`AMD EPYC™`, `Intel® Xeon® Scalable`, `Samsung® Gen4 Enterprise NVMe`, `KVM Architecture`).
3. **Pricing Matrix**: 3-tier cards with high-contrast spec micro-lists, `#673DE6` highlights, and 1-click OS badges underneath.
4. **Why Choose Us**: 3-pillar feature grid (99.99% Uptime with ping indicator, Enterprise DDoS, 24/7 Expert Support).
5. **Customer Reviews**: 3-column developer testimonial masonry grid with 5-star graphics, italic quotes, and bold names.
6. **Technical FAQ**: Clean `#F8FAFC` background with smooth interactive expanding accordions.
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
* **Header Variants (`<x-header>`)**:
  - `headerVariant="hero"`: Transparent floating navbar transitioning to frosted glass on scroll (used on homepage).
  - `headerVariant="solid"`: Pre-activated dark frosted glass navbar with automatic top spacing (`pt-20 sm:pt-22`) for inner pages (`/plans`, knowledgebase, legal).
  - `headerVariant="minimal"`: Distraction-free header with logo & SSL security badge for `/checkout` and auth pages.
* **Modular Components**:
  - `<x-seo-meta>`: Handles OpenGraph, Twitter Cards, Canonical URLs, CSRF meta tokens, and global `Organization` / `WebSite` JSON-LD schemas.
  - `<x-analytics>`: Safe Google Analytics (GA4) / Tag Manager tracking.
  - `<x-flash-messages>`: Floating dismissible toast notifications for `session('success')` and `session('error')`.
  - `<x-footer>`: 5-column B2B footer with operational 99.99% uptime status.
* **Page-Specific Schemas (`<x-slot:schema>`)**:
  - Use `<x-slot:schema>` for rich search snippets (`Product` / `AggregateOffer` for pricing catalogs, `FAQPage` for FAQ accordions).

---
*Note: Any subsequent frontend pages (e.g. checkout, package catalogs, customer dashboards, error pages) must inherit these exact design tokens, color ratios, and component architecture standards.*

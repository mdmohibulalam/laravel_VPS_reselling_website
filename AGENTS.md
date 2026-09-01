# VortexCloud Frontend Design System & UI Guidelines (`AGENTS.md`)

This document establishes the mandatory design system rules and visual identity for all frontend development in this project. All future UI components, pages, forms, and views MUST adhere strictly to these guidelines.

---

## 1. Design System Identity: "Tech Minimalist" / "SaaS Clean"
* **Philosophy**: Clean, modern, high-performance light-mode B2B interface.
* **Aesthetics**: Pure white and soft gray layered surfaces, generous whitespace, structural clarity defined by thin light-slate borders and subtle drop shadows rather than harsh dark dividing lines.
* **Component Feel**: Premium, enterprise-grade, fast-loading, highly accessible, and responsive across mobile, tablet, and desktop viewports.

---

## 2. Color Palette & 60-30-10 Distribution

### 60% Dominant Color (Canvas & Base Surfaces)
* **Pure White (`#FFFFFF`)**: Primary page background, card surfaces, content wrappers, and active input fields.
* **Soft Slate Gray (`#F8FAFC` / `bg-slate-50`)**: Alternate layout sections, FAQ accordions, metric badges, hardware spec tables, and subtle background fills.
* **Dividers & Structural Borders (`#E2E8F0` / `border-slate-200` & `#F1F5F9` / `border-slate-100`)**: Thin, crisp 1px structural borders defining card boundaries and containers.

### 30% Secondary Color (Structure, Typography & Visual Anchors)
* **Deep Slate Navy (`#0F172A` / `text-slate-900`)**: Main headlines (H1, H2, H3), plan tier titles, pricing values, and strong emphasis text.
* **Slate Grey (`#475569` / `text-slate-600`)**: High-contrast, easily readable body copy, subheadlines, descriptions, and technical specifications.
* **Muted Slate (`#64748B` / `text-slate-500`)**: Captions, timestamps, secondary labels, and inactive icon strokes.
* **Dark Contrast Accent (`#020617` / `#0F172A`)**: Mock code terminals, preview console boxes, and code snippet backgrounds.

### 10% Accent Color (Action Items & High-Energy Focus)
* **Primary Accent Purple/Indigo (`#6366F1` / `bg-indigo-600`, `text-indigo-600`)**: Applied strictly to primary Call-to-Action (CTA) buttons, highlighted keywords, active tabs, and focus rings.
* **Hover State Accent Indigo (`#4F46E5` / `bg-indigo-700`)**: Smooth hover transitions for interactive buttons.
* **Accent Glow / Shadow (`rgba(99, 102, 241, 0.25)` / `shadow-indigo-500/25`)**: Subtle colored elevation glow behind primary action triggers.
* **Status Success Green (`#10B981` / `emerald-500`)**: Operational indicators, live network ping dots, and feature checkmarks.

---

## 3. Typography & Text Hierarchy
* **Global Font**: Google Font **Inter** (`font-sans`) applied across all body and heading elements.
* **Monospace Font**: **JetBrains Mono** / `font-mono` for terminal preview blocks, API keys, and server CLI commands.
* **Headings (H1, H2, H3)**: Bold to Extrabold (`font-bold` / `font-extrabold`), with tight letter-spacing (`tracking-tight`).
* **Leading & Line Heights**: Generous leading (`leading-relaxed` / `leading-snug`) to maximize legibility.

---

## 4. Spacing & Container Rules
* **Section Containers**: `py-16 md:py-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto` to provide spacious, enterprise-grade breathing room.
* **Grid Structures**: Balanced 3-column matrices (`grid grid-cols-1 md:grid-cols-3 gap-8`) with responsive collapsing for mobile.
* **Card Padding**: Generous internal spacing (`p-6 sm:p-8 rounded-2xl` or `rounded-3xl`).

---

## 5. Interactive Components & Micro-Interactions
* **Primary Buttons**:
  ```html
  class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3.5 rounded-xl shadow-lg shadow-indigo-500/25 hover:-translate-y-0.5 transition-all duration-200 inline-flex items-center justify-center gap-2"
  ```
* **Secondary / Outline Buttons**:
  ```html
  class="bg-white hover:bg-slate-50 text-slate-700 hover:text-slate-900 border border-slate-200 hover:border-slate-300 font-semibold px-6 py-3.5 rounded-xl transition-all duration-200 inline-flex items-center justify-center gap-2"
  ```
* **Featured / Most Popular Pricing Card**:
  - Elevated shadow (`shadow-xl shadow-slate-200/80`)
  - Subtle top accent border (`border-t-2 border-indigo-600` or `border-indigo-600`)
  - Absolute pill badge (`bg-indigo-50 text-indigo-700 border border-indigo-200 text-xs font-bold uppercase tracking-wider px-3 py-1 rounded-full`)
* **Uptime Pulse Indicator**:
  - Relative container with a steady green dot inside an `animate-ping` ping ring (`h-2.5 w-2.5 rounded-full bg-emerald-500`).

---

## 6. Mandatory Section Structure (Landing Page Standard)
1. **Hero Section**: Asymmetrical desktop split layout, H1 headline with purple accent highlight, primary CTA + outline secondary button, 60-second activation trust badge, and an interactive cloud terminal/spec preview box.
2. **Hardware Partners**: Minimalist gray-scaled logo text cards (`AMD EPYC™`, `Intel® Xeon® Scalable`, `Samsung® Gen4 Enterprise NVMe`, `KVM Architecture`).
3. **Pricing Matrix**: 3-tier cards (Starter $4.99, Professional $14.99 Most Popular, Enterprise $29.99) with high-contrast spec micro-lists and 1-click OS badges underneath.
4. **Why Choose Us**: 3-pillar feature grid (99.99% Uptime with ping indicator, Enterprise DDoS, 24/7 Expert Support).
5. **Customer Reviews**: 3-column developer testimonial masonry grid with 5-star graphics, italic quotes, and bold names.
6. **Technical FAQ**: Clean `#F8FAFC` background with smooth interactive expanding accordions.
7. **Final Conversion CTA**: Striking light-mode card with centered typography and prominent "Get Started Instantly" button.

---
*Note: Any subsequent frontend pages (e.g. checkout, package catalogs, customer dashboards, error pages) must inherit these exact design tokens, color ratios, and typography standards.*

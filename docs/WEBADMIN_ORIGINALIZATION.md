# WebAdmin Originalization — Migration Architecture

**Objective:** Keep the final UI visually identical and functionality unchanged while producing a newly organized, originally implemented codebase with no proprietary template assets or branding.

**Constraints (do not change):** Routes, controllers, APIs, database schema, business logic, user-facing behavior, final visual appearance.

**Last updated:** 2026-06-24  
**Current state:** Phase 1 (layout partials) and Phase 2a (sidebar) and Phase 2c (JS modules) partially complete.

---

## 1. Phased execution plan

| Phase | Scope | Risk | Status |
|-------|--------|------|--------|
| **0** | Branding purge, dead stubs, JS URL bugs | Low | Not started |
| **1** | Layout partials, config-driven assets | Low | Done |
| **2a** | Sidebar → partials + `x-webadmin::sidebar.menu-item` | Low | Done |
| **2b** | Dashboard stat cards → components | Low | Not started |
| **2c** | `main.js` → ES modules | Low | Done |
| **2d** | Page-specific script loading | Low | Not started |
| **3** | Dashboard `index.blade.php` → sections/components | Medium | Not started |
| **4** | CSS modularization + class rename map | High | Not started |
| **5** | Asset replacement (logos, images, icons) | Medium | Partial (CDN icons) |
| **6** | Remove dead `.html` nav links → `#` or future routes | Low | Not started |
| **7** | Website originalization (mirror phases) | Medium | Not started |

**Recommended order:** 0 → 5 (branding assets) → 2b/2d/3 (Blade) → 4 (CSS) → 6 → 7.

---

## 2. Selectors that MUST NOT change

These are consumed by application JavaScript, third-party plugins, or `styles.css` attribute selectors. Rename only together with JS/CSS updates in the same PR.

### 2.1 HTML element `data-*` attributes

| Attribute | Set by | Used by |
|-----------|--------|---------|
| `data-bs-theme` | `appSettings.js`, `app-theme.js` | Bootstrap 5, `styles.css` |
| `data-app-sidebar` | `appSettings.js`, `app-sidebar.js` | `styles.css` (mini/full/hover layout) |
| `data-color-theme` | `appSettings.js` | `styles.css` (color skins) |
| `data-bs-toggle` | Blade markup | Bootstrap JS (tab, modal, dropdown, tooltip, popover) |
| `data-bs-target` | Blade markup | Bootstrap modals |
| `data-bs-placement` | Sidebar tab icons | Bootstrap tooltips |
| `data-bs-title` | Sidebar tab icons | Bootstrap tooltips |
| `data-bs-dismiss` | Modals, todo | Bootstrap modals |
| `data-bs-auto-close` | Header dropdowns | Bootstrap dropdowns |
| `data-simplebar` | Sidebar nav | Simplebar plugin |
| `data-row-checkbox` | DataTable master checkbox | `app-datatable.js` |
| `data-checkbox` | Row checkboxes | `app-datatable.js` |
| `data-selected` | Status dropdown items | `app-dropdown.js` |

### 2.2 IDs (application JS)

| ID | File | Purpose |
|----|------|---------|
| `appMenubar` | `sidebar.blade.php` | Sidebar open/close |
| `appMenubarTabs` | `tab-icons.blade.php` | Vertical tab list |
| `appMenubarTabsContent` | `sidebar.blade.php` | Tab content container |
| `dashboardTab` … `chartsTab` | `menu-section` partial | Bootstrap tab panes |
| `searchResultsModal` | `search-modal.blade.php` | Search modal |
| `searchInput` | `search-modal.blade.php` | Search field |
| `searchContainer` | `search-modal.blade.php` | AJAX results mount |
| `recentlyResults` | `search-modal.blade.php` | Recent searches block |
| `addCustomerModal` | `add-customer-modal.blade.php` | Customer modal |
| `todoTaskModal` | `dashboard/index.blade.php` | Todo modal |
| `todoInput` | dashboard | Todo text input |
| `todoPriority` | dashboard | Todo priority select |
| `todoList` | dashboard | Sortable todo list |
| `todoAdd` | dashboard | Add task button |
| `taskForm` | dashboard | Todo form |
| `dt_NewCustomers` | dashboard | DataTable instance |
| `dt_NewCustomers_Search` | dashboard | Detached search UI |
| `dt_CustomerList` | dashboard (if present) | DataTable instance |
| `dt_CustomerList_Search` | dashboard (if present) | Detached search UI |
| `todayRevenueTab` | dashboard | Revenue chart tab |
| `weekRevenueTab` | dashboard | Revenue chart tab |
| `monthRevenueTab` | dashboard | Revenue chart tab |
| `chartContacts` | dashboard | ApexCharts mount |
| `chartLeadAnalytics` | dashboard | ApexCharts mount |
| `chartTasksOverview` | dashboard | Chart.js canvas |
| `chartRevenue` | dashboard | ApexCharts mount |
| `chartTrafficSources` | dashboard | ApexCharts mount |
| `chartRetentionRate` | dashboard | ApexCharts mount |
| `statusChart` | dashboard | ApexCharts mount |
| `chartOrderByTime` | dashboard | ApexCharts mount |
| `chartDealsOverview` | dashboard | ApexCharts mount |
| `reviewSourcesChart` | `dashboard.js` only | **Dead code** — no DOM node in current Blade |
| `opportunityTrendChart` | `dashboard.js` only | **Dead code** — no DOM node in current Blade |
| `priceSwitchCheck` | future/pricing pages | `app-dropdown.js` |

### 2.3 Classes (application JS)

| Class | Module | Behavior |
|-------|--------|----------|
| `.app-toggler` | `app-sidebar.js` | Sidebar toggle + `active` |
| `.app-menubar-tabs` | `app-sidebar.js` | Tab icon rail |
| `.menu-link` | `app-sidebar.js` | Active state, tab switching |
| `.app-navbar` | `app-sidebar.js` | Submenu click handler |
| `.menu-inner` | `app-sidebar.js` | Collapsible submenus |
| `.side-menubar` | CSS + structure | Menu list |
| `.menu-item` | `app-sidebar.js` | Active parent `li` |
| `.tab-pane` | `app-sidebar.js` | Tab visibility |
| `.app-tab-content` | `app-sidebar.js` | Tab content wrapper |
| `.open` | `app-sidebar.js` | Sidebar / submenu state |
| `.active` | Multiple | Active nav/items |
| `.show` | Bootstrap + sidebar | Visible panels |
| `.theme-btn` | `app-theme.js` | Dark/light toggle |
| `.select-status` | `app-dropdown.js` | Status dropdown styling |
| `.toggle-password` | `app-dropdown.js` | Password visibility |
| `.sidebar-panel-toggler` | `app-dropdown.js` | Panel open |
| `.sidebar-close` | `app-dropdown.js` | Panel close |
| `.app-sidebar-panel` | `app-dropdown.js` | Slide panel |
| `.mail-item-bookmark` | `app-notifications.js` | Bookmark toggle |
| `.currentYear` | `app-notifications.js` | Footer year |
| `.footer-wrapper` | `app-scroll.js` | CSS height var |
| `.chat-wrapper` | `app-scroll.js` | CSS height var |
| `.data-row-checkbox` | `app-datatable.js` | Checkbox group root |
| `.checkable-wrapper` | `app-datatable.js` | Bulk select |
| `.checkable-check-all` | `app-datatable.js` | Master checkbox |
| `.checkable-check-input` | `app-datatable.js` | Row checkbox |
| `.checkable-item` | `app-datatable.js` | `is-checked` state |
| `.is-checked` | `app-datatable.js` | Selected row style |
| `.dataTable` | `app-datatable.js` | DataTables init |
| `.flatpickr-date` | `app-datatable.js` | Flatpickr init |
| `.mail-sidebar-toggler` | `app-sidebar.js` | Email page mobile |
| `.mail-sidebar` | `app-sidebar.js` | Email sidebar |
| `.chat-sidebar-toggler` | `app-sidebar.js` | Chat page mobile |
| `.chat-sidebar` | `app-sidebar.js` | Chat sidebar |
| `.sidebar-mobile-overlay` | `app-sidebar.js` | Mobile overlay |
| `.item-delete` | `todolist.js` | Delete todo |
| `.form-check-input` | `todolist.js` | Todo complete toggle |

### 2.4 Third-party locked selectors (Bootstrap 5 + plugins)

Do not rename without replacing the library or shim layer:

- Bootstrap: `.modal`, `.dropdown`, `.nav`, `.nav-link`, `.tab-content`, `.btn-close`, `.tooltip`, `.popover`, `.collapse`, utility classes (`d-none`, `d-xl-block`, spacing, grid)
- DataTables: `.display`, `.dt-search`, `#*_wrapper`
- Waves: `.waves-effect`, `.waves-light`
- Bootstrap Select: `.selectpicker`
- Simplebar: `[data-simplebar]`
- ApexCharts / Chart.js: mount element IDs only (classes optional)

### 2.5 CSS-only classes safe to rename (after mapping)

All other `app-*`, `menu-*`, `card-*`, layout wrappers in `styles.css` (~463 KB) can be renamed **if** `styles.css` is rebuilt with the new names and visual regression is verified. Use a rename map (Phase 4).

**Strategy:** Introduce `sx-` prefix (Sparkxe) for new presentation classes; keep legacy hook classes on elements until JS is updated, then remove duplicates.

---

## 3. File-by-file migration report

### 3.1 Blade — completed

| File | Action | Notes |
|------|--------|-------|
| `layouts/app.blade.php` | Keep | Shell: header, sidebar, footer, `@yield` |
| `partials/head.blade.php` | Done | Config-driven CDN + plugin CSS |
| `partials/scripts.blade.php` | Done | Config-driven scripts, `type="module"` on main |
| `partials/sidebar.blade.php` | **Refactored** | Orchestrator only |
| `partials/sidebar/logo.blade.php` | **New** | Replace logo.svg + alt text (Phase 5) |
| `partials/sidebar/brand-text.blade.php` | **New** | Replace "NexLink" → config name |
| `partials/sidebar/tab-icons.blade.php` | **New** | Inline SVGs → self-created icons (Phase 5) |
| `partials/sidebar/footer.blade.php` | **New** | Remove ThemeForest CTA (Phase 0) |
| `partials/sidebar/menu-*.blade.php` | **New** | Section/group/item partials |
| `partials/sidebar/menus/*.blade.php` | **New** | 8 tab menus via component |
| `components/sidebar/menu-item.blade.php` | **New** | Reusable menu item |
| `components/card-action-menu.blade.php` | Done | Deduped dropdowns |
| `components/page-breadcrumb.blade.php` | Done | Breadcrumb component |
| `partials/header.blade.php` | Pending | Remove NexLink comments; extract notification dropdown |
| `partials/footer.blade.php` | Done | Sparkxe copyright |
| `partials/search-modal.blade.php` | Pending | Keep IDs; restyle via CSS |
| `partials/add-customer-modal.blade.php` | Pending | Keep `#addCustomerModal` |
| `dashboard/index.blade.php` | **Pending** | 1296 lines → `dashboard/sections/*` + components |

### 3.2 Blade — planned extractions (dashboard)

| Target partial/component | Source lines (approx) | Priority |
|--------------------------|----------------------|----------|
| `dashboard/sections/stats-row.blade.php` | Top stat cards | High |
| `dashboard/sections/revenue.blade.php` | Revenue chart block | High |
| `dashboard/sections/customers-table.blade.php` | `dt_NewCustomers` | High |
| `dashboard/sections/todo.blade.php` | Todo list + modal | Medium |
| `components/stat-card.blade.php` | Repeated card pattern | High |
| `components/chart-card.blade.php` | Chart wrapper pattern | High |
| `components/data-table.blade.php` | DataTable shell | Medium |

### 3.3 JavaScript

| File | Status | Next action |
|------|--------|-------------|
| `js/main.js` | **Modular entry** | Rename to `bootstrap.js` or `app.js` (optional) |
| `js/modules/app-sidebar.js` | **Modular** | Fix `nexlink.layoutdrop.com` split → pathname-based |
| `js/modules/app-search.js` | **Modular** | Fix `search.json` path; rename internals |
| `js/modules/app-theme.js` | **Modular** | OK |
| `js/modules/app-dropdown.js` | **Modular** | OK |
| `js/modules/app-datatable.js` | **Modular** | OK |
| `js/modules/app-scroll.js` | **Modular** | OK |
| `js/modules/app-notifications.js` | **Modular** | OK |
| `js/appSettings.js` | Monolithic IIFE | Convert to ES module export |
| `js/dashboard/dashboard.js` | Monolithic | Split: `charts/`, `tables/`, remove dead chart inits |
| `js/plugins/todolist.js` | Monolithic | Move to `js/modules/todo-list.js` |
| `plugins/global/global.min.js` | Vendor | Keep (jQuery+Bootstrap) or migrate to npm build |

### 3.4 CSS

| File | Size | Action |
|------|------|--------|
| `css/styles.css` | 463 KB | **Rebuild** → `css/app/` modules + `app.css` entry |
| `css/utilities.css` | 547 B | Expand; absorb one-off utilities |
| Plugin CSS | ~55 KB | Keep minified vendor files |

**Proposed CSS structure:**

```
public/webadmin/assets/css/
├── app.css                 ← @import entry
├── tokens/
│   ├── variables.css       ← --sx-* custom properties
│   ├── themes.css          ← data-bs-theme, data-color-theme
│   └── sidebar.css         ← data-app-sidebar breakpoints
├── base/
│   ├── reset.css
│   └── typography.css
├── layout/
│   ├── shell.css           ← page-layout, app-wrapper
│   ├── header.css
│   └── sidebar.css
├── components/
│   ├── cards.css
│   ├── tables.css
│   ├── modals.css
│   ├── nav.css
│   └── charts.css
└── utilities.css
```

**Migration approach:** Extract CSS variables from computed styles of key components, module by module, with visual diff screenshots at 1280px / 768px / 375px.

### 3.5 Config & PHP

| File | Action |
|------|--------|
| `config/webadmin.php` | Add `menu`, `charts`, `scripts.pages` registry |
| `app/Support/WebadminAsset.php` | Add `versioned()` helper for cache bust |
| `AppServiceProvider.php` | Component paths registered — OK |

### 3.6 Assets — inventory & action

| Asset | Current | Replacement |
|-------|---------|-------------|
| `images/logo.svg` | Template logo | **New** Sparkxe SVG (original geometry) |
| `images/favicon.png` | Template | **New** from logo |
| `images/apple-touch-icon.png` | Template | **New** from logo |
| `images/wind.gif` | 953 KB template promo | **Remove** — CSS gradient or royalty-free pattern |
| `images/avatar/avatar1-5.webp` | Template photos | **Replace** — generated avatars or ui-avatars.com API |
| `images/icons/google-meet.svg` | Third-party mark | **Replace** — generic video-call icon (no trademark) |
| `images/avatar/*.html` stubs | Dead | **Delete** |
| `images/country/*.html` stubs | Dead | **Delete** or replace with flag-icons CDN |
| `images/product/*.html` stubs | Dead | **Delete** |
| Flaticon UIcons CDN | OFL/free tier | **Keep** or migrate to Lucide/Bootstrap Icons only |
| Font Awesome CDN | SIL OFL | **Keep** or reduce to BI only |
| Google Fonts Instrument Sans | OFL | **Keep** or switch to system stack |
| Sidebar tab SVGs | Inline template paths | **Replace** with original simplified SVGs |
| `plugins/*/index.global.min.html` | 0-byte stubs | **Delete** |

---

## 4. Template references to remove

| Location | Reference | Replacement |
|----------|-----------|-------------|
| `sidebar/brand-text.blade.php` | "NexLink" | `config('webadmin.name')` |
| `sidebar/logo.blade.php` | alt "NexLink Admin Dashboard Logo" | `config('webadmin.name')` |
| `sidebar.blade.php` | `begin::NexLink Sidebar Menu` comments | `{{-- Sidebar --}}` |
| `header.blade.php` | `begin::NexLink Page Header` comments | `{{-- Header --}}` |
| `sidebar/footer.blade.php` | ThemeForest upgrade link | Remove card or Sparkxe feature CTA |
| `css/styles.css` L1–17 | LayoutDrop / NexLink header | Remove on rebuild |
| `css/styles.css` ~L4856 | `nexlink.layoutdrop.com` breadcrumb | Fix to `/` or `content: "/"` |
| `app-sidebar.js` L76,96 | `nexlink.layoutdrop.com` URL split | `pathname` + basename logic |
| 89× `href="*.html"` in Blade | Static demo links | `#` or named Laravel routes (future) |
| `dashboard/index.blade.php` | Template demo copy | Reword in place (same layout) |

---

## 5. Replaced assets log (track during execution)

| Date | Old | New | License |
|------|-----|-----|---------|
| — | Local broken flaticon/fa plugins | CDN Flaticon UIcons, FA 6.7.2, BI 1.11.3 | OFL/MIT |
| — | Footer "NexLink" text | Sparkxe (config) | N/A |
| Pending | `logo.svg` | TBD Sparkxe mark | Original |
| Pending | `wind.gif` | CSS gradient | N/A |
| Pending | `avatar*.webp` | TBD placeholders | Royalty-free |

---

## 6. Dead code to remove

- 32× zero-byte `.html` image/plugin stubs under `public/webadmin/assets/`
- `dashboard.js`: `reviewSourcesChart`, `opportunityTrendChart` inits (no DOM)
- Unused plugin folders: fullcalendar, tagify stubs
- HTTrack artifact comments throughout `styles.css`

---

## 7. Visual regression verification checklist

Run after **each phase** at viewports **1920**, **1280**, **768**, **375**:

### Layout & chrome
- [ ] Header: search, theme toggle, notifications, profile dropdown
- [ ] Sidebar: tab icons, tab panes, mini/full collapse, hover expand
- [ ] Sidebar mobile: `.open` overlay behavior
- [ ] Footer: copyright year, links
- [ ] Modals: search, add customer, todo task

### Dashboard widgets
- [ ] All stat cards: spacing, icons, trend badges
- [ ] Charts: contacts, lead analytics, tasks overview, revenue (3 tabs), traffic, retention, status, order by time, deals
- [ ] DataTable: search detached, pagination, row checkboxes
- [ ] Todo: add, complete, delete, drag reorder

### Theme & settings
- [ ] Light/dark toggle (`data-bs-theme`)
- [ ] Color theme (`data-color-theme`)
- [ ] Sidebar mode (`data-app-sidebar` mini/full)

### Assets & branding
- [ ] No "NexLink", "LayoutDrop", or ThemeForest visible in UI
- [ ] Logo and favicon show Sparkxe branding
- [ ] No broken images (network 404)
- [ ] Icons render (CDN or local)

### Technical
- [ ] `GET /admin` returns 200
- [ ] No console errors on load
- [ ] `main.js` module graph loads
- [ ] DataTables / ApexCharts / Chart.js initialize
- [ ] `php artisan view:cache` succeeds

---

## 8. CSS class rename policy

1. **Never rename** §2 selectors without updating JS in the same commit.
2. **Rename presentation classes** in groups (e.g. all card variants) with a mapping file `docs/css-class-map.json`.
3. **Prefer CSS custom properties** over hard-coded colors in new code.
4. **Bootstrap utilities** (`mb-3`, `d-flex`, etc.) — keep as-is (framework contract).

Example mapping (illustrative):

```json
{
  "app-menubar-tabs": "sx-shell__sidebar",
  "app-wrapper": "sx-shell__main",
  "menu-link": "sx-nav__link"
}
```

Apply mapping only after duplicate hooks exist or JS is updated.

---

## 9. Immediate next steps (Phase 0 — low risk)

1. Replace NexLink brand text with `config('webadmin.name')`.
2. Remove ThemeForest upgrade card from `sidebar/footer.blade.php`.
3. Strip `NexLink` / `LayoutDrop` comments from Blade files.
4. Fix `app-sidebar.js` active-link detection (remove layoutdrop URL).
5. Delete 0-byte `.html` asset stubs.
6. Remove dead chart inits from `dashboard.js`.
7. Replace `wind.gif` promo background with CSS gradient in `utilities.css`.

These changes do not alter layout structure and are safe precursors to CSS rebuild.

---

*This document is the source of truth for the originalization project. Update the status column as phases complete.*

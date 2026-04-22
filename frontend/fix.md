# Identified Problems & Bugs (Frontend)

The following issues were identified during the frontend analysis and should be fixed in the next development sprint.

## 🐛 Technical Bugs
1.  **Duplicate Sidebars**: `FeedPage.vue` and `ProfilePage.vue` have separate, redundant sidebar implementations.
    - *Fix*: Extract into `src/components/AppSidebar.vue`.
2.  **Missing `defineConfig` in `vite.config.js`**: (Fixed) I previously resolved this, but it highlighted a fragile config.
3.  **Hardcoded "Alex Rivers"**: The user identity is hardcoded in multiple components (Navbar, Sidebar, Profile).
    - *Fix*: Move to a Pinia store or a global reactive object.

## ⚠️ UX & Navigation Issues
4.  **Static Map**: `MapPage.vue` uses a static image and hardcoded markers that are not interactive.
5.  **Broken Sidebar Links**: Many sidebar items link to `#` instead of their respective routes.
6.  **Chat Inactivity**: `ChatPage.vue` does not support real-time interaction or even local state-based messaging.
7.  **Form Shells**: Authentication forms have no validation beyond HTML5 `required`.

## 🛠️ Code Quality / Debt
8.  **Large Components**: Pages like `ProfilePage.vue` are ~250 lines long.
    - *Fix*: Break down into sub-components (ActivityCard, StatCard, etc.).
9.  **Data Isolation**: Mock data is declared inside components, making it hard to share or update.
    - *Fix*: Move to `src/mocks/` or a dedicated data service.
10. **Tailwind v4 Optimization**: Some styles still use hardcoded hex values (e.g., `#FF5C00`) instead of the theme tokens (e.g., `var(--color-primary-container)`).

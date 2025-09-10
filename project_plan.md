Of course. That is an excellent idea for ensuring the project's context is portable and clear. Here is the complete master prompt, updated with our latest successes and the detailed plan for the future.

---

### **Master Prompt: The SurfAlert Rebranding & Rebuild Project**

#### **Part 1: Project History & Completed Phases**

**Initial Goal:** To take the open-source WordPress plugin "NotificationX," rebrand it to "SurfAlert," and establish a stable development environment to modify its features for commercial resale.

**Investigation Summary & Challenges Overcome:**
The project began with an attempt to perform a simple rebrand on the existing NotificationX codebase. This immediately revealed critical, blocking issues:

1.  **Private Dependencies:** The PHP code relied on private Composer packages, making a clean installation impossible.
2.  **Broken Build Systems:** The project contained multiple, conflicting, and outdated JavaScript build systems (Rollup, Grunt, Webpack) that were unbuildable with modern tools.
3.  **Dependency Hell:** The `package.json` contained logically impossible peer dependency requirements (conflicting React versions).
4.  **Missing `package-lock.json`:** The absence of a lock file made it impossible to recreate the original developers' last known stable environment.
5.  **"Black Box" Admin UI:** The most critical discovery was that the main admin panel (`assets/admin/js/admin.js`) was a pre-compiled, minified file with no available source code, making it unmodifiable and unmaintainable.

**Strategic Pivot:**
Based on these findings, the initial "rebrand" mission was deemed impossible. A new, more robust mission was adopted: a **"Headless" Rebuild.** This strategy involves salvaging the functional PHP backend and replacing the entire broken frontend with a new, modern application built from scratch.

---

**COMPLETED - Phase 0 & 1: The PHP Takeover**

-   **Status:** :white_check_mark: COMPLETE
-   **Summary:** We successfully executed a full takeover of the PHP backend.
    -   **Decoupling:** All private Composer dependencies were removed and replaced with our own empty placeholder libraries.
    -   **Rebranding:** A comprehensive "Find and Replace" was performed, and all namespaces, classes, functions, files, and folders were renamed from "NotificationX" to "SurfAlert."
    -   **Autoloader Stabilization:** Through an iterative debugging process, the Composer autoloader was completely fixed by correcting file paths, namespaces, and class names until the entire PHP application could be loaded by WordPress without any `Class not found` fatal errors.
    -   **Runtime Stabilization:** Initial PHP runtime errors caused by the empty placeholder libraries were triaged and resolved by either adding placeholder methods or temporarily disabling non-essential features (like the admin notice system).
-   **Outcome:** We now have a **stable, fully rebranded, and self-contained PHP backend.** The plugin activates and runs without fatal errors, and its existing REST API endpoints are ready to be used. This work is committed and pushed to the `feature/rebuild` branch on GitHub.

**COMPLETED - Phase 2: The "Shell" Application**

-   **Status:** :white_check_mark: COMPLETE
-   **Summary:** We successfully ripped out the old, broken frontend and built a new, modern foundation.
    -   **Cleanup:** All legacy build files (`package.json`, `webpack.config.js`, etc.) and the pre-compiled "black box" admin UI (`assets/admin/` folder) were deleted.
    -   **Vite Build System:** A new, clean build system was established using a minimal `package.json` and a `vite.config.js` file.
    -   **React Foundation:** A simple "Hello World" React application was created in `src/admin.jsx`.
    -   **PHP Connection:** The PHP code in `Admin.php` and `PostType.php` was updated to correctly render the root `div` and enqueue the new, Vite-compiled JavaScript module (`build/admin.js`).
-   **Outcome:** The plugin's admin page now successfully loads and displays our new, minimal React application. We have a confirmed, end-to-end working foundation for the new UI. This work is also committed and pushed to GitHub.

---

#### **Part 2: Future Phases - The UI Rebuild Plan**

**Current Phase:** Phase 3: The UI Rebuild
**Mission:** Systematically replicate and then improve upon the functionality of the original NotificationX admin panel using our new, modern React foundation.

**Phase 3: Building the Application Shell & Routing**

-   **Goal:** Create the main layout and navigation for the admin panel.
-   **Tasks:**
    1.  Install `react-router-dom`: `npm install react-router-dom`.
    2.  In `src/admin.jsx`, replace the "Hello World" app with a main `<App>` component.
    3.  Inside `<App>`, build the primary layout components: `<Sidebar />`, `<Header />`, and a main content area.
    4.  Configure `BrowserRouter` to handle the main application routes (e.g., `/`, `/add-new`, `/settings`, `/analytics`).
-   **Outcome:** A functional admin panel shell. The sidebar links will work, switching between empty placeholder pages (e.g., an empty `<DashboardPage />`) without full page reloads.

**Phase 4: Rebuilding Core Features (Component by Component)**

-   **Goal:** Re-implement the core features of the plugin, connecting the new UI to the existing PHP backend.
-   **Tasks (Iterative Process):**
    1.  **The Notification Builder:** This is the largest task. We will rebuild it tab by tab.
        -   Create the UI for the "Source," "Design," "Content," and "Display" tabs.
        -   Use a modern state management solution (like Zustand) to hold the notification settings in memory as the user builds it.
        -   When the user clicks "Save," use `fetch` to send the state object to the existing PHP REST API endpoint for saving notifications (we will find this endpoint by examining the old plugin's `includes/Core/REST.php` file).
    2.  **The Settings Page:** Build a new settings form. On save, `fetch` the data to the corresponding PHP REST API endpoint.
    3.  **The Dashboard:** Build a component that makes a `fetch` call to the PHP REST API to get the list of all created notifications and displays them in a table.
-   **Outcome:** A fully functional admin panel where a user can create, edit, save, and delete notifications.

**Phase 5: The Gutenberg Block & Frontend Script**

-   **Goal:** Integrate the remaining JavaScript components.
-   **Tasks:**
    1.  **Gutenberg Block:**
        -   Add a new entry point (`src/block.jsx`) to our `vite.config.js`.
        -   Copy the original block's source code into `src/block.jsx`.
        -   Run the "whack-a-mole" build process for this file, installing any dependencies it needs until it compiles successfully.
        -   Update `blocks/Blocks.php` to load the new `build/block.js` and its asset file.
    2.  **Frontend Script (Salvage):**
        -   The original `assets/public/js/frontend.js` is a simple, non-React script. We will keep it.
        -   Create a PHP class (`includes/FrontEnd.php`) to enqueue this script on the live site.

**Phase 6: Final Polish & Launch Prep**

-   **Goal:** Complete the rebrand and prepare for release.
-   **Tasks:**
    1.  **Rebuild Missing Library Logic:** Go into our empty placeholder libraries (`includes/libraries/`) and implement the necessary methods (e.g., `Settings::get()`) by writing simple WordPress wrapper functions (`get_option()`).
    2.  **Asset Rebranding:** Replace all logos, icons, and other images in the `assets/images` folder with new branding.
    3.  **Full QA:** Rigorously test every feature from end to end.

This master prompt provides a complete, clear, and actionable plan for any developer to understand the project's history, current status, and future direction.

import { defineConfig } from "vite";
import react from "@vitejs/plugin-react";

export default defineConfig({
    plugins: [react()],
    build: {
        // Our compiled files will go into a 'build' folder
        outDir: "build",
        rollupOptions: {
            input: {
                // Define the entry point for our new admin app
                admin: "src/admin.jsx",
            },
            output: {
                entryFileNames: `[name].js`,
                assetFileNames: `[name].[ext]`,
            },
        },
    },
});

import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";

export default defineConfig({
    plugins: [
        {
            name: "ignore-missing-assets",
            resolveId(id) {
                if (id.includes("public/assets")) {
                    return id;
                }
            },
            load(id) {
                if (id.includes("public/assets")) {
                    return 'export default ""';
                }
            },
        },
        vue({
            template: {
                transformAssetUrls: false,
            },
        }),
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    server: {
        watch: {
            ignored: [
                "**/vendor/**",
                "**/storage/**",
                "**/node_modules/**",
                "**/.git/**",
            ],
        },
    },
});

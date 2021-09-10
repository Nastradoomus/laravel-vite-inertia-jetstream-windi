import { defineConfig } from "laravel-vite";
import vue from "@vitejs/plugin-vue";
const { resolve } = require("path");

export default defineConfig()
  .withPlugin(vue)
  .merge({
    resolve: {
      alias: {
        "@": resolve(__dirname, "resources/scripts"),
      },
    },

    optimizeDeps: {
      include: [
        "vue",
        "@inertiajs/inertia",
        "@inertiajs/inertia-vue3",
        "@inertiajs/progress",
        "axios",
      ],
    },
  });

/*
import vue from "@vitejs/plugin-vue";
const { resolve } = require("path");
const Dotenv = require("dotenv");

Dotenv.config();

const ASSET_URL = process.env.ASSET_URL || "";

export default {
  plugins: [vue()],

  root: "resources",
  base: `${ASSET_URL}/dist/`,

  build: {
    ///outDir: resolve(__dirname, "public/dist"),
    emptyOutDir: true,
    manifest: true,
    target: "esnext",
    rollupOptions: {
      input: "/js/app.js",
    },
  },

  server: {
    strictPort: true,
    port: 3000,
  },

  resolve: {
    alias: {
      "@": "/js",
    },
  },

  optimizeDeps: {
    include: [
      "vue",
      "@inertiajs/inertia",
      "@inertiajs/inertia-vue3",
      "@inertiajs/progress",
      "axios",
    ],
  },
};
*/

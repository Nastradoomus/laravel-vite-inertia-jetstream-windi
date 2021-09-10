import { defineConfig } from "laravel-vite"
import vue from "@vitejs/plugin-vue"
import WindiCSS from "vite-plugin-windicss"
import { resolve } from "path"

export default defineConfig().merge({
  plugins: [WindiCSS(), vue()],
  resolve: {
    alias: {
      "@": resolve(__dirname, "resources/scripts")
    }
  },

  optimizeDeps: {
    include: [
      "vue",
      "windicss",
      "@inertiajs/inertia",
      "@inertiajs/inertia-vue3",
      "@inertiajs/progress",
      "axios"
    ]
  }
})

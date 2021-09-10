import { defineConfig } from "windicss/helpers";
import forms from "windicss/plugin/forms";
import typography from "windicss/plugin/typography";

export default defineConfig({
  extract: {
    include: ["./**/*.html", "./**/*.vue"],
  },
  plugins: [forms, typography],
});

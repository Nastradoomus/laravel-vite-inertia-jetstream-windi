import { createApp, h } from "vue"

import {
	App as InertiaApp,
	plugin as InertiaPlugin
} from "@inertiajs/inertia-vue3"

import { InertiaProgress } from "@inertiajs/progress"

import axios from "axios"

import "virtual:windi.css"

//import VueGlobalMessage from "vue-global-message"

import VCalendar from "v-calendar"

axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest"

InertiaProgress.init()

const app = document.getElementById("app")

interface MetaWithGlob extends ImportMeta {
	glob(any: any): any
}

const modules = (import.meta as MetaWithGlob).glob("./Pages/**/*.vue")

createApp({
	render: () =>
		h(InertiaApp, {
			initialPage: JSON.parse(app.dataset.page),
			resolveComponent: (name: string) => {
				const importPage = modules[`./Pages/${name}.vue`]
				if (!importPage) {
					throw new Error(
						`Unknown page ${name}. Is it located under Pages with a .vue extension?`
					)
				}
				return importPage().then((module) => module.default)
			}
		})
})
	.mixin({ methods: { route } })
	.use(InertiaPlugin)
	/*
	.use(VueGlobalMessage, {
		zindex: 1000,
		duration: 1500
	})
	*/
	.use(VCalendar, {})
	.mount(app)

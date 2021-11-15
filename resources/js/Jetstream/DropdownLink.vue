<template>
	<div>
		<button
			type="submit"
			class="
				block
				w-full
				px-4
				py-2
				text-sm
				leading-5
				text-gray-700 text-left
				hover:bg-gray-100
				focus:outline-none focus:bg-gray-100
				transition
				duration-150
				ease-in-out
			"
			v-if="role === 'button'"
		>
			<slot></slot>
		</button>

		<inertia-link :href="href" :class="classes" v-else>
			<slot></slot>
		</inertia-link>
	</div>
</template>

<script>
import { Link as InertiaLink } from "@inertiajs/inertia-vue3"

export default {
	components: {
		InertiaLink
	},
	props: ["active", "href", "role"],
	computed: {
		classes() {
			return this.active
				? "block pl-3 pr-4 py-2 text-sm leading-5 border-l-4 border-indigo-400 text-indigo-700 bg-indigo-50 focus:outline-none focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700 transition duration-150 ease-in-out"
				: "block pl-3 pr-4 py-2 text-sm leading-5 border-l-4 border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out"
		}
	}
}
</script>

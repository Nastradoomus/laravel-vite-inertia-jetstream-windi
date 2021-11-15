<template>
	<app-layout>
		<template #header>
			<h2 class="font-semibold text-xl text-gray-800 text-2xl text-center">
				Ravintolan asetukset, tekstit ja oletusarvot
			</h2>
		</template>
		<div class="py-12">
			<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
				<div class="bg-white shadow-xl sm:rounded-lg">
					<div class="py-6 px-3 sm:px-5 md:px-20 bg-white border-b border-gray-200">
						<div class="mt-8 text-2xl text-center">Lounas</div>
						<div class="mt-6"></div>
						<div class="grid justify-items-stretch">
							<div class="justify-self-center"></div>
						</div>
					</div>
					<Lunch :data="lunch" />
				</div>
			</div>
		</div>
	</app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout"

import Lunch from "@/Pages/Restaurant/Data/LunchData"

export default {
	components: {
		AppLayout,
		Lunch
	},
	props: {
		data: Array
	},
	data() {
		return {
			menu: undefined
		}
	},
	computed: {
		lunch: {
			set(val) {
				return val
			},
			get() {
				const { data } = this
				const json = {
					serving_time: { start: undefined, end: undefined },
					type: null,
					price: null,
					price_additional: null
				}
				let result
				if (Array.isArray(data)) {
					const l = data.length
					for (let i = 0; i < l; i += 1) {
						if (data[i].title && data[i].title === "lunch") result = data[i]
					}
					if (!result.json) result.json = json
				}
				return result
			}
		}
	}
}
</script>

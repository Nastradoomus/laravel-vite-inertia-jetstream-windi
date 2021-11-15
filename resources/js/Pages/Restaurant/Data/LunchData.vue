<template>
	<div>
		<div class="p-2 rounded-xl shadow-md">
			<div class="mt-3 py-6 text-grey-600 text-2xl text-center bg-gray-300">Oletusarvot</div>
			<div
				class="grid grid-cols-1 md:grid-cols-3 gap-4 place-content-evenly p-3 bg-gray-200"
				@change="updateDefaults()"
			>
				<div>
					<span class="pt-4 pb-1 pl-1 text-gray-700 block">Lounaan tyyppi</span>
					<jet-dropdown align="left" class="mt-1">
						<template #trigger>
							<button
								type="button"
								class="
									inline-flex
									justify-between
									w-full
									rounded-md
									border border-gray-300
									shadow-sm
									px-4
									py-2
									bg-white
									text-sm
									font-medium
									text-gray-700
									hover:bg-gray-50
									focus:outline-none
									focus:ring-2
									focus:ring-offset-2
									focus:ring-offset-gray-100
									focus:ring-indigo-500
								"
							>
								<TypeTranslate :text="defaults.json.type" />
								<JetDropdownSVG />
							</button>
						</template>
						<template #content>
							<jet-dropdown-item @clicked="updateDefaultType(null)"> (tyhjä) </jet-dropdown-item>
							<jet-dropdown-item @clicked="updateDefaultType('lunch')"> Lounas </jet-dropdown-item>
							<jet-dropdown-item @clicked="updateDefaultType('brunch')">
								Brunssi
							</jet-dropdown-item>
							<div class="border-t border-gray-100"></div>
						</template>
					</jet-dropdown>
				</div>
				<div class="text-center">
					<label>
						<span class="pt-4 pb-1 pl-1 text-gray-700 block">Tarjoiluaika</span>
						<input
							type="time"
							class="
								mt-1
								rounded-md
								border-gray-300
								shadow-sm
								focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
							"
							name="start"
							step="300"
							v-model="defaults.json.serving_time.start"
						/>
						<b>-</b>
						<input
							type="time"
							class="
								mt-1
								rounded-md
								border-gray-300
								shadow-sm
								focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
							"
							name="end"
							step="300"
							v-model="defaults.json.serving_time.end"
						/>
					</label>
				</div>
				<div>
					<label>
						<span class="pt-4 pb-1 pl-2 text-gray-700 block">Päivän hinta</span>
						<div>
							<input
								type="number"
								step=".01"
								class="
									px-2
									w-24
									mt-1
									rounded-md
									border-gray-300
									shadow-sm
									focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
								"
								:value="defaults.json.price"
								@change="defaults.json.price = $event.target.value"
							/>
							<b>-</b>
							<input
								type="number"
								step=".01"
								class="
									px-2
									w-24
									mt-1
									rounded-md
									border-gray-300
									shadow-sm
									focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
								"
								v-model="defaults.json.price_additional"
							/>
							<b>EUR</b>
						</div>
					</label>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
import JetDropdown from "@/Jetstream/Dropdown"
import JetDropdownItem from "@/Jetstream/DropdownItem"
import JetDropdownSVG from "@/Jetstream/DropDownSVG"

import { axiosPost } from "@/Helpers/js/axios"

import { postRestaurantLunchDefaultsApiUrl } from "@/Helpers/js/apiEndPoints"

import TypeTranslate from "../Lunch/TypeTranslate"

export default {
	components: {
		JetDropdown,
		JetDropdownItem,
		JetDropdownSVG,
		TypeTranslate
	},
	props: {
		data: { Type: Object }
	},
	data() {
		return {
			defaults: undefined
		}
	},
	watch: {
		data: {
			deep: true,
			immediate: true,
			handler() {
				this.defaults = window._.cloneDeep(this.data)
			}
		}
	},
	methods: {
		async updateDefaults() {
			const data = window._.omit(this.defaults, ["created_at", "updated_at"])
			data.title = "lunch"
			const url = postRestaurantLunchDefaultsApiUrl()
			const json = JSON.stringify(data)
			const response = await axiosPost({ url, json })
			if (response) {
				this.$message.success(response)
			} else this.$message.error("Tietojen tallentamisessa tapahtui virhe")
		},
		updateDefaultType(type) {
			this.defaults.json.type = type
			this.updateDefaults()
		}
	},
	created() {
		this.updateDefaults = window._.debounce(this.updateDefaults, 2000)
	}
}
</script>

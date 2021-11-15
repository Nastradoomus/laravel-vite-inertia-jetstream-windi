<template>
	<div>
		<div v-for="(item, target) in items" :key="item + target" class="p-2">
			<div class="mt-3 py-6 text-grey-600 text-2xl text-center bg-gray-300">
				{{ parseDate(item.date) }}
			</div>
			<div
				class="grid grid-cols-1 md:grid-cols-3 gap-4 place-content-evenly p-3 bg-gray-200"
				@change="updateDate(target)"
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
								{{ setDefaultType(target) }}
								<TypeTranslate :text="item.type" />
								<JetDropdownSVG />
							</button>
						</template>
						<template #content>
							<jet-dropdown-item @clicked="updateType(null, target)"> (tyhjä) </jet-dropdown-item>
							<jet-dropdown-item @clicked="updateType('lunch', target)"> Lounas </jet-dropdown-item>
							<jet-dropdown-item @clicked="updateType('brunch', target)">
								Brunssi
							</jet-dropdown-item>
							<div class="border-t border-gray-100"></div>
						</template>
					</jet-dropdown>
				</div>
				<div class="text-center">
					<time-between-input
						:start="getServingTime('start', target)"
						@start="item.serving_time.start = $event"
						:end="getServingTime('end', target)"
						@end="item.serving_time.end = $event"
						>Tarjoiluaika</time-between-input
					>
				</div>
				<div class="text-center">
					<number-between-input
						:price="item.price"
						@price="item.price = $event"
						:priceAdditional="item.price_additional"
						@priceAdditional="item.price_additional = $event"
						>Päivän hinta</number-between-input
					>
				</div>
			</div>
			<MenuItems
				:data="item.json"
				:date="item.date"
				:target="target"
				@delete="deleteItem"
				@change="updateItem"
				:key="componentKey"
			/>
			<div class="flex justify-center w-100 py-6">
				<jet-button class="px-12" @click.native="addItem(target)" action="add">
					Lisää uusi annos
				</jet-button>
			</div>
		</div>
	</div>
</template>
<script>
import { format } from "date-fns"
import fi from "date-fns/locale/fi"
import NumberBetweenInput from "@/Components/Common/InputNumberBetween"
import TimeBetweenInput from "@/Components/Common/InputTimeBetween"
import JetButton from "@/Jetstream/Button"
import JetDropdown from "@/Jetstream/Dropdown"
import JetDropdownItem from "@/Jetstream/DropdownItem"
import JetDropdownSVG from "@/Jetstream/DropDownSVG"

import { capitalize } from "@/Helpers/js/common"
import { ISOStringToDate } from "@/Helpers/js/dateFunctions"

import { axiosPost } from "@/Helpers/js/axios"
import {
	postRestaurantLunchApiUrl,
	postRestaurantLunchDateApiUrl,
	postRestaurantLunchDateDefaultsApiUrl,
	deleteRestaurantLunchApiUrl
} from "@/Helpers/js/apiEndPoints"

import MenuItems from "@/Components/Common/Menu/MenuItems"
import TypeTranslate from "./TypeTranslate"

export default {
	components: {
		NumberBetweenInput,
		TimeBetweenInput,
		JetButton,
		JetDropdown,
		JetDropdownItem,
		JetDropdownSVG,
		MenuItems,
		TypeTranslate
	},
	props: {
		data: { Type: Object },
		defaults: { Type: Object }
	},
	data() {
		return {
			items: undefined,
			componentKey: 0
		}
	},
	watch: {
		data: {
			deep: true,
			immediate: true,
			handler() {
				if (!this.portions) {
					// REMOVE WHEN ALL PORTIONS HAVE ADDITIONAL PRICE
					const data = window._.cloneDeep(this.data)
					if (Array.isArray(data)) {
						const l = data.length
						for (let i = 0; i < l; i += 1) {
							const d = data[i]
							if (!Object.prototype.hasOwnProperty.call(d, "price_additional")) {
								d.price_additional = null
							}
						}
						this.items = data
					}
				}
			}
		}
	},
	methods: {
		parseDate(date) {
			if (typeof date !== "string") {
				throw new Error(`parseDate(date) needs date as string but is: ${typeof date}.`)
			}
			let result
			try {
				const isoString = `${date}T12:00:00.000Z`
				result = capitalize(
					format(Date.parse(ISOStringToDate(isoString)), "EEEEEE dd.MM.yyyy", {
						locale: fi
					})
				)
			} catch (error) {
				console.error(`parseDate(date) is not valid date: ${date}`)
			}
			return result
		},
		getServingTime(time, i) {
			if (time !== "start" && time !== "end") {
				throw new Error(`getServinGtime(time, i) needs time (start or end), but is: ${time}.`)
			}
			if (typeof i !== "number") {
				throw new Error(`getServinGtime(time, i) needs index as number but is: ${typeof i}.`)
			}
			const item = this.items[i]
			const { start, end } = item.serving_time
			const { start: defaultStart, end: defaultEnd } = this.$props.defaults.serving_time
			let result
			let key

			if (time === "start") {
				key = "start"
				if (start === undefined) {
					result = defaultStart
					this.updateDefaults()
				} else result = start
			}
			if (time === "end") {
				key = "end"
				if (end === undefined) {
					result = defaultEnd
					this.updateDefaults()
				} else result = end
			}
			if (key) {
				this.items[i].serving_time[key] = result
			}
			return result
		},

		async deleteItem({ target, i }) {
			this.items[target].json.splice(i, 1)
			const json = window._.pick(this.items[target], ["date", "json"])
			const url = deleteRestaurantLunchApiUrl()
			const response = await axiosPost({ url, json })
			if (response) {
				this.$message.warn(response)
			} else this.$message.error("Annoksen tallentamisessa tapahtui virhe")
			this.forceRerender()
		},
		addItem(target) {
			const i = target
			if (!this.items[i].json) {
				this.items[i].json = []
			}
			this.items[i].json.push({
				title: "",
				body: "",
				ingredients: "",
				allergenic: "",
				price: "",
				price_additional: ""
			})
			this.updateItem({ target, undefined })
			this.forceRerender()
		},
		async updateItem({ target, portions }) {
			const i = target
			if (portions) this.items[i].json = portions
			const json = JSON.stringify(this.items[i])
			const url = postRestaurantLunchApiUrl()
			const response = await axiosPost({ url, json })
			if (response) {
				this.$message.success(response)
			} else this.$message.error("Annoksen tallentamisessa tapahtui virhe")
		},

		setDefaultType(target) {
			const i = target
			if (this.items[i].type === undefined) this.items[i].type = this.defaults.type
		},
		updateType(type, target) {
			const i = target
			this.items[i].type = type
			this.updateDate(i)
		},
		async updateDate(target) {
			const i = target
			const data = window._.pick(this.items[i], [
				"date",
				"price",
				"price_additional",
				"serving_time",
				"type"
			])
			const url = postRestaurantLunchDateApiUrl()
			const json = JSON.stringify(data)
			const response = await axiosPost({ url, json })
			if (response) {
				this.$message.success(response)
			} else this.$message.error("Päivän tallentamisessa tapahtui virhe")
		},
		async updateDefaults() {
			// UPDATES OTHER DEFAULT VALUES TOO!
			const data = []
			Object.keys(this.items).forEach((i) => {
				if (!this.items[i].price) this.items[i].price = null // for SQL
				if (!this.items[i].price_additional) this.items[i].price_additional = null // for SQL
				data.push(
					window._.pick(this.items[i], [
						"date",
						"serving_time",
						"type",
						"price",
						"price_additional"
					])
				)
			})
			const url = postRestaurantLunchDateDefaultsApiUrl()
			const json = JSON.stringify(data)
			const response = await axiosPost({ url, json })
			if (response) {
				this.$message.success(response)
			} else this.$message.error("Tarjoiluaikojen tallentamisessa tapahtui virhe")
		},
		forceRerender() {
			this.componentKey += 1
		}
	},
	mounted() {
		// Set default prices for DAYS if empty
		if (this.items) {
			Object.keys(this.items).forEach((i) => {
				if (!this.items[i].price) {
					this.items[i].price = this.defaults.price
				}
				if (!this.items[i].price_additional) {
					this.items[i].price_additional = this.defaults.price_additional
				}
			})
		}
	},

	created() {
		this.updateDate = window._.debounce(this.updateDate, 1000)
		this.updateDefaults = window._.debounce(this.updateDefaults, 1000)
	}
}
</script>

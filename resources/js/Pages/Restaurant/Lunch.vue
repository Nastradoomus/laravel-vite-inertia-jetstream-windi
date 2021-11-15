<template>
	<app-layout>
		<template #header>
			<h2 class="font-semibold text-xl text-gray-800 text-2xl text-center">
				Ravintolan lounaslista
			</h2>
		</template>
		<div class="py-12">
			<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
				<div class="bg-white shadow-xl sm:rounded-lg">
					<div class="py-6 px-3 sm:px-5 md:px-20 bg-white border-b border-gray-200">
						<div class="mt-8 text-2xl text-center">Valitse päivämäärä(t)</div>
						<div class="mt-6">
							<v-date-picker
								:value="null"
								:available-dates="datePicker.allowedDateRange"
								:model-config="datePicker.modelConfig"
								:first-day-of-week="2"
								locale="fi"
								@dayclick="datePickerOnClick"
								is-range
								is-expanded
								:columns="$screens({ default: 1, lg: 2 })"
							/>
						</div>
						<div class="grid justify-items-stretch">
							<div class="justify-self-center">
								<jet-button
									class="mt-6 pl-6 pr-6"
									:disabled="datePicker.disabledBeforeSelecting"
									@click.native="fetchData"
								>
									Hae tiedot
								</jet-button>
							</div>
						</div>
						<div class="mt-6">
							<JetSwitch
								label="Aikaraja on rajattu kahden (2) viikon mittaiseksi."
								:disabled="datePicker.disabledWhenSelecting"
								@change="datePicker.removeRangeLimit = !datePicker.removeRangeLimit"
							/>
						</div>
						<div class="mt-2">
							<JetSwitch
								label="Menneitä päiviä ei voi muokata."
								:disabled="datePicker.disabledWhenSelecting"
								@change="datePicker.allowPastDate = !datePicker.allowPastDate"
							/>
						</div>
					</div>
					<DateIterator :data="lunches" :defaults="defaults" :key="componentKey" />
				</div>
			</div>
		</div>
	</app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout"
import JetSwitch from "@/Jetstream/Switch"
import JetButton from "@/Jetstream/Button"

import { correctOffset, addDays } from "@/Helpers/js/dateFunctions"

import { axios } from "@/Helpers/js/axios"
import {
	getRestaurantLunchApiUrl,
	getRestaurantLunchDefaultsApiUrl
} from "@/Helpers/js/apiEndPoints"
import DateIterator from "./Lunch/LunchDateIterator"

const now = new Date()
export default {
	components: {
		AppLayout,
		JetSwitch,
		JetButton,
		DateIterator
	},
	data() {
		return {
			datePicker: {
				removeRangeLimit: false,
				allowPastDate: false,
				allowedDateRange: { start: now, end: null },
				selectedDateRange: { start: now, end: now },
				disabledWhenSelecting: false,
				disabledBeforeSelecting: true
			},
			lunches: undefined,
			componentKey: 0,
			defaults: {
				serving_time: { start: undefined, end: undefined },
				type: undefined,
				price: undefined,
				price_additional: undefined
			}
		}
	},
	mounted() {
		this.fetchData()
		this.fetchDefaults()
	},
	watch: {
		// eslint-disable-next-line func-names
		"datePicker.allowPastDate": function (val) {
			if (val === false) {
				this.datePicker.allowedDateRange.start = null
			} else {
				this.datePicker.allowedDateRange.start = now
			}
		},
		// eslint-disable-next-line func-names
		"datePicker.selectedDateRange.end": function (val) {
			if (val !== null) {
				this.datePicker.disabledBeforeSelecting = false
			} else this.datePicker.disabledBeforeSelecting = true
		}
	},
	methods: {
		datePickerOnClick(val) {
			const date = correctOffset(val.date)
			const { removeRangeLimit, allowPastDate, selectedDateRange, allowedDateRange } =
				this.datePicker
			if (selectedDateRange.start === null || selectedDateRange.end !== null) {
				this.datePicker.disabledWhenSelecting = true

				selectedDateRange.start = date
				selectedDateRange.end = null

				allowedDateRange.start = date

				if (removeRangeLimit) {
					allowedDateRange.end = addDays(date, 14)
				}
			} else if (selectedDateRange.end === null) {
				selectedDateRange.end = date
				allowedDateRange.end = null
				if (allowPastDate) {
					allowedDateRange.start = now
				} else {
					allowedDateRange.start = null
				}
				this.datePicker.disabledWhenSelecting = false
			}
		},
		async fetchData() {
			const { start, end } = this.datePicker.selectedDateRange
			const url = getRestaurantLunchApiUrl(start, end)
			const response = await axios(url)
			if (response) {
				this.lunches = response
				const { length } = this.lunches
				for (let i = 0; i < length; i += 1) {
					if (this.lunches[i].serving_time === null || undefined) {
						this.$set(this.lunches[i], "serving_time", { start: undefined, end: undefined })
					}
				}
			}
			this.forceRerender()
		},
		async fetchDefaults() {
			const url = getRestaurantLunchDefaultsApiUrl()
			const response = await axios(url)
			if (response) {
				const object = response[0]
				if (Object.prototype.hasOwnProperty.call(object, "json")) {
					this.defaults = object.json
				}
			}
		},
		forceRerender() {
			this.componentKey += 1
		}
	}
}
</script>

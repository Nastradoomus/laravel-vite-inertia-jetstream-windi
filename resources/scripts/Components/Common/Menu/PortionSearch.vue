<template>
	<jet-dialog-modal :show="show" @close="closeModal">
		<template #title>
			<span class="pt-4 pb-1 pl-1 text-gray-700 text-2xl block">Hae annoskorteista</span></template
		>

		<template #content>
			<input
				type="text"
				class="
					block
					mt-1
					w-full
					rounded-md
					border-gray-300
					shadow-sm
					focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
				"
				:placeholder="placeHolder"
				:value="search"
				@keyup="search = $event.target.value"
			/>
			<div v-if="!fetchingData">
				<div v-if="!search || search.length < 3" class="text-green-600 text-center mt-3">
					<b>Anna vähintään kolme ensimmäistä kirjainta.</b>
				</div>
				<div v-if="zeroResults" class="text-red-500 text-center mt-3">
					<b>Valitettavasti emme löytäneet yhtään hakuun sopivaa tulosta...</b>
				</div>
			</div>
		</template>

		<template #footer>
			<jet-button @click.native="closeModal" action="delete"> Sulje haku... </jet-button>
		</template>

		<template #results>
			<div v-if="result.data" class="grid grid-cols-1 sm:grid-cols-2 gap-2 my-6">
				<div
					v-for="(portion, i) in result.data"
					:key="portion + i"
					class="rounded-md bg-gray-100 p-3"
				>
					<div class="flex justify-between pb-3 text-2xl text-gray-700">
						<div class="break-all">{{ i + 1 }}. {{ portion.title }}</div>
						<div>
							<jet-button class="px-6 ml-3" @click.native="selectPortion(portion)" action="add">
								Valitse
							</jet-button>
						</div>
					</div>

					<span class="pt-4 pb-1 block"><b>Nimike: </b>{{ portion.title }}</span>
					<span class="pt-4 pb-1 block"><b>Tarkempi kuvaus: </b>{{ portion.body }}</span>
					<span class="pt-4 pb-1 block"><b>Ainesosat: </b>{{ portion.ingredients }}</span>
					<span class="pt-4 pb-1 block"><b>Allergiatiedot: </b>{{ portion.allergenic }}</span>
					<span class="pt-4 pb-1 block"><b>Hinta: </b>{{ portion.price }} EUR</span>
					<span class="pt-4 pb-1 block"><b>Hinta(max): </b>{{ portion.price_additional }} EUR</span>
					<span class="pt-4 pb-1 block"><b>Allergiatiedot: </b>{{ portion.allergenic }}</span>
				</div>
			</div>
		</template>
	</jet-dialog-modal>
</template>
<script>
import JetButton from "@/Jetstream/Button"
import JetDialogModal from "@/Jetstream/DialogModal"

import { getPortionsSearchApiUrl } from "@/Helpers/js/apiEndPoints"
import { axios } from "@/Helpers/js/axios"

export default {
	components: {
		// JetButton,

		JetButton,
		JetDialogModal
	},
	props: {
		show: { Type: Boolean, default: false }
	},
	data() {
		return {
			result: { data: undefined, fetchingData: false },
			search: undefined,
			portions: undefined,
			zeroResults: false,
			fetchingData: false,
			placeHolder: "Syötä hakusana..."
		}
	},
	watch: {
		show: {
			handler() {
				this.resetModal()
			}
		},
		search: {
			handler() {
				if (typeof this.search === "string") {
					if (this.search.length >= 3) {
						this.searchHandlerWithDelay()
					} else this.zeroResults = false
				}
			}
		},
		result: {
			deep: true,
			handler() {
				this.zeroResults = false
				if (!this.result.data && !this.result.fetchingData) {
					if (typeof this.search === "string") {
						if (this.search.length >= 3) {
							this.zeroResults = true
						}
					}
				}
			}
		}
	},
	methods: {
		resetModal() {
			this.result = { data: undefined, fetchingData: undefined }
			this.search = undefined
			this.portions = undefined
			this.zeroResults = false
			this.fetchingData = false
			this.placeHolder = "Syötä hakusana..."
		},
		closeModal() {
			this.resetModal()
			this.$emit("close")
		},
		selectPortion(portion) {
			this.resetModal()
			this.$emit("select", portion)
		},
		searchHandlerWithDelay() {
			this.result.fetchingData = true
			if (this.timer) {
				clearTimeout(this.timer)
				this.timer = null
			}
			this.timer = setTimeout(() => {
				this.fetchSearch()
			}, 800)
		},

		async fetchSearch() {
			const url = getPortionsSearchApiUrl(this.search)
			const response = await axios(url)
			if (response) {
				this.result.data = response
				this.result.fetchingData = false
			} else {
				this.result.data = undefined
				this.result.fetchingData = false
			}
		}
	}
}
</script>

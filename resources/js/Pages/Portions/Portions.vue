<template>
	<app-layout>
		<template #header>
			<h2 class="font-semibold text-xl text-gray-800 text-2xl text-center">Annoskortit</h2>
		</template>
		<div class="py-12">
			<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
				<div class="bg-white shadow-xl sm:rounded-lg">
					<div class="py-6 px-3 sm:px-5 md:px-20 bg-white border-b border-gray-200">
						<div class="grid justify-items-stretch">
							<div class="justify-self-center">
								<div class="text-2xl text-center">Uudet annokset</div>
								<div class="flex justify-center w-100 py-6 px-24">
									<jet-button class="mr-3" action="add" @click.native="addPortion()">
										Lisää uusi
									</jet-button>
									<jet-button class="ml-3" action="delete" @click.native="clearAddPortions()">
										Tyhjennä tämä näkymä
									</jet-button>
								</div>
							</div>
						</div>
					</div>
					<div class="bg-gray-200 bg-opacity-25">
						<div class="p-4">
							<PortionItems
								:data="newPortions"
								:target="'newPortions'"
								class="pb-12"
								@delete="deletePortion"
								@change="updatePortion"
							/>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="pb-6">
			<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
				<div class="bg-white shadow-xl sm:rounded-lg">
					<div class="py-6 px-3 sm:px-5 md:px-20 bg-white border-b border-gray-200">
						<div class="mt-8 mb-6 text-2xl text-center">Hae ja muokkaa vanhoja annoksia</div>
						<label>
							<span class="pt-4 pb-1 pl-2 text-gray-700 block">Nimike</span>
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
								placeholder="Etsi nimikettä..."
								@keyup="search = $event.target.value"
							/>
						</label>
						<div v-if="zeroResults" class="text-red-500 text-center mt-3">
							<b>Valitettavasti emme löytäneet yhtään hakuun sopivaa tulosta...</b>
						</div>
						<div class="flex justify-center w-100 py-6 px-24">
							<jet-button class="mr-3" action="add" @click.native="fetchAllPortions()">
								Hae kaikki annokset
							</jet-button>
							<jet-button class="ml-3" action="delete" @click.native="clearSearchPortions()">
								Tyhjennä tämä näkymä
							</jet-button>
						</div>
					</div>
					<div class="bg-gray-200 bg-opacity-25">
						<div class="p-4">
							<PortionItems
								:data="portions"
								:target="'portions'"
								class="pb-12"
								@delete="deletePortion"
								@change="updatePortion"
							/>
						</div>
					</div>
				</div>
			</div>
		</div>
	</app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout"

import {
	getPortionsApiUrl,
	postPortionApiUrl,
	getPortionsSearchApiUrl,
	deletePortionApiUrl
} from "@/Helpers/js/apiEndPoints"
import { axios, axiosPost, axiosDelete } from "@/Helpers/js/axios"
import JetButton from "@/Jetstream/Button"
import PortionItems from "./PortionItems"

export default {
	components: {
		AppLayout,
		JetButton,
		PortionItems
	},
	data() {
		return {
			newPortions: undefined,
			portions: undefined,
			search: undefined,
			zeroResults: false
		}
	},
	watch: {
		search: {
			handler() {
				this.searchHandlerWithDelay()
			}
		}
	},
	methods: {
		addPortion() {
			const json = {
				title: "",
				body: "",
				ingredients: "",
				allergenic: "",
				price: "",
				price_additional: ""
			}
			if (!Array.isArray(this.newPortions)) this.newPortions = []
			this.newPortions.push(json)
		},
		clearAddPortions() {
			this.newPortions = []
		},
		clearSearchPortions() {
			this.portions = []
		},
		async fetchAllPortions() {
			const url = getPortionsApiUrl()
			const response = await axios(url)
			if (response) {
				this.portions = response
			}
		},
		async updatePortion({ target, i }) {
			const portion = target === "newPortions" ? this.newPortions[i] : this.portions[i]
			const data = window._.omit(portion, ["created_at", "updated_at"])
			const url = postPortionApiUrl()
			const json = JSON.stringify(data)
			const response = await axiosPost({ url, json })
			if (response) {
				if (response.message) {
					this.$message.success(response.message)
					if (response.id) portion.id = response.id
				} else this.$message.success(response)
			} else this.$message.error("Tietojen tallentamisessa tapahtui virhe")
		},
		async deletePortion({ target, i }) {
			const portion = target === "newPortions" ? this.newPortions[i] : this.portions[i]
			if (portion.id) {
				const url = deletePortionApiUrl()
				const { id } = portion
				const request = { url, id }
				const response = await axiosDelete(request)
				if (response) {
					this.$message.success(response)
				} else this.$message.error("Annoskortin poistossa tapahtui virhe")
			}
			this.portions.splice(i, 1)
		},

		searchHandlerWithDelay() {
			if (this.search.length < 3) return

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
				this.portions = response
				this.zeroResults = false
			} else this.zeroResults = true
		}
	}
}
</script>

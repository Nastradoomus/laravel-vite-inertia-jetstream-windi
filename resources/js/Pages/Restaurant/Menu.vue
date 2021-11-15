<template>
	<app-layout>
		<template #header>
			<h2 class="font-semibold text-xl text-gray-800 text-2xl text-center">
				Ravintolan ruoka/juomalista
			</h2>
		</template>
		<div class="py-12">
			<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
				<div class="bg-white shadow-xl sm:rounded-lg">
					<div class="py-6 px-3 sm:px-5 md:px-20 bg-white border-b border-gray-200">
						<div class="mt-8 text-2xl text-center">Valikoima</div>
						<div class="grid justify-items-stretch">
							<div class="justify-self-center"></div>
						</div>
					</div>
					<MenuIterator :data="menu" :type="'restaurant'" @delete="deleteType" />
					<div class="flex justify-center w-100 py-6">
						<jet-button class="px-24" @click.native="addType()" action="add">
							Lisää uusi kategoria
						</jet-button>
					</div>
				</div>
			</div>
		</div>
	</app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout"
import JetButton from "@/Jetstream/Button"
import { axiosPost, axiosDelete } from "@/Helpers/js/axios"
import { postRestaurantTypeApiUrl } from "@/Helpers/js/apiEndPoints"
import MenuIterator from "@/Components/Common/Menu/MenuIterator"

const url = postRestaurantTypeApiUrl()
export default {
	components: {
		AppLayout,
		MenuIterator,
		JetButton
	},
	props: {
		data: { type: Array, required: true }
	},
	computed: {
		menu: {
			set(val) {
				return val
			},
			get() {
				let result
				if (this.data) {
					result = this.data
				} else {
					result = [{ type: "", icon: "", json: "", id: null }]
				}
				return result
			}
		}
	},
	methods: {
		async addType() {
			const item = { type: "", icon: "", json: "", id: null }
			const i = this.menu.push(item) - 1
			const json = JSON.stringify(item)
			const request = { url, json }
			const response = await axiosPost(request)
			if (response) {
				this.$message.success(response.message)
				this.menu[i].id = response.id
			} else this.$message.error("Kategorian tallentamisessa tapahtui virhe")
		},
		async deleteType(i) {
			const { id } = this.menu[i]
			const request = { url, id }
			const response = await axiosDelete(request)

			if (response) {
				this.$message.success(response)
				this.menu.splice(i, 1)
			} else this.$message.error("Kategorian poistossa tapahtui virhe")
		}
	}
}
</script>

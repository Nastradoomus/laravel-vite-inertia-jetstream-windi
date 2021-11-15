<template>
	<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
		<div v-for="(item, i) in portions" :key="item + i">
			<div class="mr-4">
				<div class="pb-3 text-2xl text-gray-700">
					<div class="break-words">{{ i + 1 }}. {{ item.title }}</div>
					<div class="flex justify-end">
						<jet-button class="px-6 ml-3" @click.native="searchHandler(i)" action="search">
							Hae
						</jet-button>
						<jet-button class="px-6 ml-3" @click.native="deleteHandler(target, i)" action="delete">
							Poista
						</jet-button>
					</div>
				</div>
				<text-input v-model="item.title">Nimike</text-input>
				<text-area v-model="item.body" :heightClass="'h16'">Tarkempi kuvaus</text-area>
				<text-input v-model="item.ingredients">Ainesosat</text-input>
				<number-between-input
					:price="item.price"
					@price="item.price = $event"
					:priceAdditional="item.price_additional"
					@priceAdditional="item.price_additional = $event"
					>Hinta</number-between-input
				>
				<text-input v-model="item.allergenic">Allergeniatiedot</text-input>
			</div>
		</div>
		<Search :show="searchModal" @select="searchResult" @close="searchModal = false" />
	</div>
</template>
<script>
import JetButton from "@/Jetstream/Button"
import Search from "./PortionSearch"
import TextInput from "@/Components/Common/InputText"
import TextArea from "@/Components/Common/TextArea"
import NumberBetweenInput from "@/Components/Common/InputNumberBetween"

export default {
	components: {
		JetButton,
		Search,
		TextInput,
		TextArea,
		NumberBetweenInput
	},
	props: {
		data: {
			Type: Object
		},
		date: {
			Type: String
		},
		target: { Type: Number }
	},
	data() {
		return {
			searchModal: false,
			searchIndex: undefined,
			portions: undefined
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
						this.portions = data
					}
				}
			}
		},
		portions: {
			deep: true,
			handler() {
				this.changeHandler()
			}
		}
	},
	methods: {
		changeHandler() {
			const { target, portions } = this
			this.$emit("change", { target, portions })
		},
		deleteHandler(target, i) {
			this.$emit("delete", { target, i })
		},
		searchHandler(i) {
			this.searchIndex = i
			this.searchModal = true
		},
		searchResult(portion) {
			this.searchModal = false
			if (typeof this.searchIndex === "number" && this.searchIndex >= 0) {
				this.portions[this.searchIndex] = window._.pick(portion, [
					"title",
					"body",
					"allergenic",
					"ingredients",
					"price",
					"price_additional"
				])
				this.changeHandler()
			} else this.$message.warn("Annoksen lisääminen epäonnistui")
			this.searchModal = false
		}
	},
	created() {
		this.emitHandler = window._.debounce(this.changeHandler, 2000)
	}
}
</script>

<template>
	<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
		<div v-for="(portion, i) in data" :key="portion + i">
			<div class="mr-4">
				<div class="flex justify-between pb-3 text-2xl text-gray-700">
					<div class="break-all">{{ i + 1 }}. {{ portion.title }}</div>
					<div>
						<jet-button
							class="px-6 ml-3"
							@click.native="$emit('delete', { target, i })"
							action="delete"
						>
							Poista
						</jet-button>
					</div>
				</div>
				<div @change="updateHandler(i)">
					<text-input v-model="portion.title">Nimike</text-input>
					<text-area v-model="portion.body">Nimike</text-area>
					<text-input v-model="portion.ingredients">Ainesosat</text-input>
					<number-between-input
						:price="portion.price"
						@price="portion.price = $event"
						:priceAdditional="portion.price_additional"
						@priceAdditional="portion.price_additional = $event"
						>Hinta</number-between-input
					>
					<text-input v-model="portion.allergenic">Allergeniatiedot</text-input>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
import JetButton from "@/Jetstream/Button"
import TextInput from "@/Components/Common/InputText"
import TextArea from "@/Components/Common/TextArea"
import NumberBetweenInput from "@/Components/Common/InputNumberBetween"

export default {
	components: {
		JetButton,
		TextInput,
		TextArea,
		NumberBetweenInput
	},
	props: {
		data: {
			type: Array
		},
		target: {
			type: String,
			default: ""
		}
	},
	methods: {
		updateHandler(i) {
			const { target } = this
			this.$emit("change", { target, i })
		}
	},
	created() {
		this.updateHandler = window._.debounce(this.updateHandler, 2000)
	}
}
</script>

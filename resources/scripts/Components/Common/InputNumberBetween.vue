<template>
	<label>
		<span class="pt-4 pb-1 pl-2 text-gray-700 block"><slot /></span>
		<div class="text-center">
			<input
				title="Kiinteä hinta tai vaihtuvan hinnan alaraja"
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
				:value="proxyPrice"
				@change="proxyPrice = $event.target.value"
			/>
			<b>-</b>
			<input
				title="Vaihtelevan hinnan yläraja"
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
				:value="proxyPriceAdditional"
				@change="proxyPriceAdditional = $event.target.value"
			/>
			<b>EUR</b>
		</div>
	</label>
</template>

<script>
export default {
	props: {
		price: {
			type: String
		},
		priceAdditional: {
			type: String
		}
	},
	computed: {
		proxyPrice: {
			get() {
				return this.price
			},
			set(val) {
				this.$emit("price", val)
			}
		},
		proxyPriceAdditional: {
			get() {
				return this.priceAdditional
			},
			set(val) {
				this.$emit("priceAdditional", val)
			}
		}
	}
}
</script>

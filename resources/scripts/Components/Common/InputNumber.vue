<template>
	<span>
		<span class="pt-4 pb-1 pl-2 text-gray-700 block"><slot /></span>
		<input
			v-if="role === 'price'"
			type="number"
			step=".01"
			class="
				px-1
				w-24
				mt-1
				rounded-md
				border-gray-300
				shadow-sm
				focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
			"
			v-model="proxyValue"
		/>
		<input
			v-if="role !== 'price'"
			type="number"
			class="
				mt-1
				rounded-md
				border-gray-300
				shadow-sm
				focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
			"
			v-model="proxyValue"
		/>
	</span>
</template>

<script>
export default {
	model: {
		prop: "value",
		event: "change"
	},
	props: {
		value: {
			type: String
		},
		role: {
			type: String,
			default: "default"
		}
	},
	computed: {
		proxyValue: {
			get() {
				return this.value
			},
			set(val) {
				this.$emit("change", val)
			}
		}
	}
}
</script>

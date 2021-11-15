<template>
	<span>
		<span class="pt-4 pb-1 pl-2 text-gray-700 block"><slot /></span>
		<input
			type="date"
			pattern="\d{4}-\d{2}-\d{2}"
			class="
				block
				mt-1
				w-full
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

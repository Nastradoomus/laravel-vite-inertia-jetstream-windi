<template>
	<label>
		<span class="pt-4 pb-1 pl-2 text-gray-700 block"><slot /></span>
		<textarea
			type="text"
			:class="heightClass"
			class="
				block
				mt-1
				w-full
				rounded-md
				border-gray-300
				shadow-sm
				focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
			"
			:value="proxyValue"
			@change="proxyValue = $event.target.value"
		/>
	</label>
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
		heightClass: { type: String }
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

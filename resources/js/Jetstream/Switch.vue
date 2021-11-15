<template>
	<div v-if="!disabled" class="flex cursor-pointer" @click="proxyChecked = !proxyChecked">
		<div
			class="w-8 h-5 flex items-center bg-gray-300 rounded-full p-1 duration-300 ease-in-out"
			:class="{ 'bg-red-600': proxyChecked }"
		>
			<div
				class="bg-white w-4 h-4 rounded-full shadow-md transform duration-300 ease-in-out"
				:class="{ 'translate-x-2': proxyChecked }"
			></div>
		</div>
		<span class="mx-2" ref="switchLabel">{{ label }}</span>
		<slot></slot>
	</div>
	<div v-else class="flex tooltip relative cursor-not-allowed">
		<span
			class="
				tooltip-text
				bg-red-100
				text-center
				rounded-full
				px-3
				transition
				duration-500
				ease-in-out
			"
			>Pois päältä. Viimeistele ensin nykyiset valinnat...</span
		>
		<div
			class="w-8 h-5 flex items-center bg-gray-300 rounded-full p-1 duration-300 ease-in-out"
			:class="{ 'bg-red-600': proxyChecked }"
		>
			<div
				class="bg-white w-4 h-4 rounded-full shadow-md transform duration-300 ease-in-out"
				:class="{ 'translate-x-2': proxyChecked }"
			></div>
		</div>
		<span class="ml-2" ref="switchLabel">{{ label }}</span>
	</div>
</template>

<script>
export default {
	props: {
		label: { type: String, default: "" },
		disabled: { type: Boolean, default: false },
		checked: {
			type: Boolean,
			default: false
		}
	},
	data() {
		return {
			proxyChecked: null
		}
	},
	mounted() {
		this.$nextTick(() => {
			this.proxyChecked = this.checked
		})
	},
	watch: {
		proxyChecked(val) {
			const el = this.$refs.switchLabel
			if (val === true) {
				el.classList.add("text-red-500")
				el.classList.add("line-through")
			} else {
				el.classList.remove("text-red-500")
				el.classList.remove("line-through")
			}
			this.$emit("change", val)
		}
	}
}
</script>
<style scoped>
.tooltip-text {
	visibility: hidden;
	opacity: 0;
	left: 37px;
	top: -1px;
	position: absolute;
	z-index: 1;
}

.tooltip:hover .tooltip-text {
	visibility: visible;
	opacity: 1;
}
</style>

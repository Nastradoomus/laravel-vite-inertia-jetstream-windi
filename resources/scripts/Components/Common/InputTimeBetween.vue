<template>
	<label>
		<span class="pt-4 pb-1 pl-2 text-gray-700 block"><slot /></span>
		<input
			type="time"
			class="
				mt-1
				rounded-md
				border-gray-300
				shadow-sm
				focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
			"
			name="start"
			step="300"
			:value="proxyStart"
			@change="proxyStart = $event.target.value"
		/>
		<b>-</b>
		<input
			type="time"
			class="
				mt-1
				rounded-md
				border-gray-300
				shadow-sm
				focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
			"
			name="end"
			step="300"
			:value="proxyEnd"
			@change="proxyEnd = $event.target.value"
		/>
	</label>
</template>

<script>
export default {
	props: {
		start: {
			type: String
		},
		end: {
			type: String
		}
	},
	computed: {
		proxyStart: {
			get() {
				return this.start
			},
			set(val) {
				this.$emit("start", val)
			}
		},
		proxyEnd: {
			get() {
				return this.end
			},
			set(val) {
				this.$emit("end", val)
			}
		}
	}
}
</script>

<style></style>

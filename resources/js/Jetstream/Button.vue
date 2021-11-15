<template>
	<button
		v-if="!disabled && action === ''"
		:type="type"
		class="
			inline-flex
			items-center
			px-4
			py-2
			bg-gray-800
			border border-transparent
			rounded-md
			font-semibold
			text-xs text-white
			uppercase
			tracking-widest
			hover:bg-gray-700
			active:bg-gray-900
			focus:outline-none focus:border-gray-900 focus:shadow-outline-gray
			transition
			ease-in-out
			duration-150
		"
	>
		<slot></slot>
	</button>
	<button
		v-else-if="!disabled && action === 'delete'"
		:type="type"
		class="
			inline-flex
			items-center
			px-4
			py-2
			bg-white-800
			border border-red-500
			text-red-500
			rounded-md
			font-semibold
			text-xs
			uppercase
			tracking-widest
			hover:bg-red-700 hover:text-white
			active:bg-darkred active:text-white-600
			focus:outline-none focus:border-darkred focus:shadow-outline-red-300 focus:text-color-white
			transition
			ease-in-out
			duration-150
		"
	>
		<slot></slot>
	</button>
	<button
		v-else-if="!disabled && action === 'add'"
		:type="type"
		class="
			inline-flex
			items-center
			px-4
			py-2
			bg-white-800
			border border-green-600
			text-green-600
			rounded-md
			font-semibold
			text-xs
			uppercase
			tracking-widest
			hover:bg-green-700 hover:text-white
			active:bg-darkgreen active:text-white-600
			focus:outline-none
			focus:border-darkgreen
			focus:shadow-outline-green-300
			focus:text-color-white
			transition
			ease-in-out
			duration-150
		"
	>
		<slot></slot>
	</button>
	<button
		v-else-if="!disabled && action === 'search'"
		:type="type"
		class="
			inline-flex
			items-center
			px-4
			py-2
			bg-white-800
			border border-green-600
			text-green-600
			rounded-md
			font-semibold
			text-xs
			uppercase
			tracking-widest
			hover:bg-green-700 hover:text-white
			active:bg-darkgreen active:text-white-600
			focus:outline-none
			focus:border-darkgreen
			focus:shadow-outline-green-300
			focus:text-color-white
			transition
			ease-in-out
			duration-150
		"
	>
		<slot></slot>
	</button>
	<button
		v-else
		disabled
		class="
			inline-flex
			items-center
			px-4
			py-2
			bg-white-800
			border border-gray-900
			rounded-md
			font-semibold
			text-xs text-grey-800
			uppercase
			tracking-widest
			cursor-default
		"
	>
		<slot></slot>
	</button>
</template>

<script>
export default {
	props: {
		type: {
			type: String,
			default: "submit"
		},
		disabled: {
			type: Boolean,
			default: false
		},
		action: {
			type: String,
			default: ""
		}
	}
}
</script>

<template>
	<span>
		{{ translated }}
	</span>
</template>
<script>
export default {
	props: { text: { type: String } },
	computed: {
		translated: {
			get() {
				if (this.text === "lunch") {
					return "Lounas";
				}
				if (this.text === "brunch") {
					return "Brunssi";
				}
				return "Ei valittu";
			},
			set(val) {
				if (val === "lunch") {
					return "Lounas";
				}
				if (val === "brunch") {
					return "Brunssi";
				}
				return "Ei valittu";
			},
		},
	},
};
</script>

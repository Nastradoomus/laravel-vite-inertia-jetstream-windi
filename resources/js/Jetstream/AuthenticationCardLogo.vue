<template>
	<inertia-link :href="'/'">
		<img src="/images/villa-sibbe-small.png" alt="Villa Sibbe" />
	</inertia-link>
</template>

<script>
import { Link as InertiaLink } from "@inertiajs/inertia-vue3"

export default {
	components: {
		InertiaLink
	}
}
</script>

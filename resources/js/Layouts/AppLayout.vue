<template>
	<div>
		<BreakPoints v-if="developerMode" />
		<jet-banner />
		<div class="min-h-screen bg-gray-100">
			<nav class="bg-white border-b border-gray-100">
				<!-- Primary Navigation Menu -->
				<div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
					<div class="flex justify-between h-16">
						<div class="flex">
							<!-- Logo -->
							<div class="flex-shrink-0 flex items-center">
								<inertia-link :href="route('dashboard')">
									<jet-application-mark class="block h-9 w-auto" />
								</inertia-link>
							</div>

							<!-- Navigation Links -->
							<div class="hidden space-x-8 md:-my-px md:ml-10 md:flex">
								<jet-nav-link
									:href="route('dashboard')"
									:active="route().current('dashboard')"
								>
									Hallintapaneeli
								</jet-nav-link>
							</div>
							<div class="hidden md:flex md:items-center md:ml-6">
								<jet-dropdown align="left" width="48">
									<template #trigger>
										<span class="inline-flex rounded-md">
											<button
												type="button"
												class="
													inline-flex
													items-center
													border border-transparent
													text-sm
													leading-4
													font-medium
													rounded-md
													text-gray-500
													bg-white
													hover:text-gray-700
													focus:outline-none
													transition
													ease-in-out
													duration-150
												"
											>
												Ravintola
												<JetDropdownSVG />
											</button>
										</span>
									</template>

									<template #content>
										<jet-dropdown-link
											:href="route('restaurant.lunch')"
											:active="route().current('restaurant.lunch')"
										>
											Lounas
										</jet-dropdown-link>

										<jet-dropdown-link
											:href="route('restaurant.menu')"
											:active="route().current('restaurant.menu')"
										>
											Menu
										</jet-dropdown-link>

										<jet-dropdown-link
											:href="route('restaurant.data')"
											:active="route().current('restaurant.data')"
										>
											Muut asiat
										</jet-dropdown-link>

										<div class="border-t border-gray-100"></div>
									</template>
								</jet-dropdown>
							</div>
							<div class="hidden space-x-8 md:-my-px md:flex md:ml-6">
								<jet-nav-link
									:href="route('cafe')"
									:active="route().current('cafe')"
								>
									Kahvila
								</jet-nav-link>
							</div>
							<div class="hidden space-x-8 md:-my-px md:flex md:ml-6">
								<jet-nav-link
									:href="route('servicehours')"
									:active="route().current('servicehours')"
								>
									Aukioloajat
								</jet-nav-link>
							</div>
							<div class="hidden space-x-8 md:-my-px md:flex md:ml-6">
								<jet-nav-link
									:href="route('portions')"
									:active="route().current('portions')"
								>
									Annospohjat
								</jet-nav-link>
							</div>
						</div>

						<div class="hidden md:flex md:items-center md:ml-6">
							<!-- Settings Dropdown -->
							<div class="ml-3 relative">
								<jet-dropdown align="right" width="48">
									<template #trigger>
										<button
											v-if="$page.props.jetstream.managesProfilePhotos"
											class="
												flex
												text-sm
												border-2 border-transparent
												rounded-full
												focus:outline-none focus:border-gray-300
												transition
												duration-150
												ease-in-out
											"
										>
											<img
												class="h-8 w-8 rounded-full object-cover"
												:src="$page.props.user.profile_photo_url"
												:alt="$page.props.user.name"
											/>
										</button>

										<span v-else class="inline-flex rounded-md">
											<button
												type="button"
												class="
													inline-flex
													items-center
													px-3
													py-2
													border border-transparent
													text-sm
													leading-4
													font-medium
													rounded-md
													text-gray-500
													bg-white
													hover:text-gray-700
													focus:outline-none
													transition
													ease-in-out
													duration-150
												"
											>
												{{ $page.props.user.name }}

												<JetDropdownSVG />
											</button>
										</span>
									</template>

									<template #content>
										<!-- Account Management -->
										<div class="block px-4 py-2 text-xs text-gray-400">
											Hallinnoi tiliä
										</div>

										<jet-dropdown-link :href="route('profile.show')">
											Profiili
										</jet-dropdown-link>

										<jet-dropdown-link
											v-if="$page.props.jetstream.hasApiFeatures"
											:href="route('api-tokens.index')"
										>
											API avaimet
										</jet-dropdown-link>

										<div class="border-t border-gray-100"></div>

										<!-- Authentication -->
										<form @submit.prevent="logout">
											<jet-dropdown-link role="button">
												Kirjaudu ulos
											</jet-dropdown-link>
										</form>
									</template>
								</jet-dropdown>
							</div>
						</div>

						<!-- Hamburger -->
						<div class="-mr-2 flex items-center md:hidden">
							<button
								class="
									inline-flex
									items-center
									justify-center
									p-2
									rounded-md
									text-gray-400
									hover:text-gray-500 hover:bg-gray-100
									focus:outline-none focus:bg-gray-100 focus:text-gray-500
									transition
									duration-150
									ease-in-out
								"
								@click="showingNavigationDropdown = !showingNavigationDropdown"
							>
								<svg
									class="h-6 w-6"
									stroke="currentColor"
									fill="none"
									viewBox="0 0 24 24"
								>
									<path
										:class="{
											hidden: showingNavigationDropdown,
											'inline-flex': !showingNavigationDropdown
										}"
										stroke-linecap="round"
										stroke-linejoin="round"
										stroke-width="2"
										d="M4 6h16M4 12h16M4 18h16"
									/>
									<path
										:class="{
											hidden: !showingNavigationDropdown,
											'inline-flex': showingNavigationDropdown
										}"
										stroke-linecap="round"
										stroke-linejoin="round"
										stroke-width="2"
										d="M6 18L18 6M6 6l12 12"
									/>
								</svg>
							</button>
						</div>
					</div>
				</div>

				<!-- Responsive Navigation Menu -->
				<div
					:class="{
						block: showingNavigationDropdown,
						hidden: !showingNavigationDropdown
					}"
					class="md:hidden"
				>
					<div class="pt-2 pb-3 space-y-1">
						<jet-responsive-nav-link
							:href="route('dashboard')"
							:active="route().current('dashboard')"
						>
							Hallintapaneeli
						</jet-responsive-nav-link>
						<div
							class="
								inline-flex
								items-center
								pl-3
								pr-4
								py-2
								border-l-4 border-transparent
								text-base
								font-medium
							"
						>
							Ravintola
							<JetDropdownSVG />
						</div>
						<div class="pl-3">
							<jet-responsive-nav-link
								:href="route('restaurant.lunch')"
								:active="route().current('restaurant.lunch')"
							>
								Lounas
							</jet-responsive-nav-link>
							<jet-responsive-nav-link
								:href="route('restaurant.menu')"
								:active="route().current('restaurant.menu')"
							>
								Menu
							</jet-responsive-nav-link>
							<jet-responsive-nav-link
								:href="route('restaurant.data')"
								:active="route().current('restaurant.data')"
							>
								Muut asiat
							</jet-responsive-nav-link>
						</div>
						<jet-responsive-nav-link
							:href="route('cafe')"
							:active="route().current('cafe')"
						>
							Kahvila
						</jet-responsive-nav-link>
						<jet-responsive-nav-link
							:href="route('servicehours')"
							:active="route().current('servicehours')"
						>
							Aukioloajat
						</jet-responsive-nav-link>
						<jet-responsive-nav-link
							:href="route('portions')"
							:active="route().current('portions')"
						>
							Annospohjat
						</jet-responsive-nav-link>
					</div>

					<!-- Responsive Settings Options -->
					<div class="pt-4 pb-1 border-t border-gray-200">
						<div class="flex items-center px-4">
							<div
								v-if="$page.props.jetstream.managesProfilePhotos"
								class="flex-shrink-0 mr-3"
							>
								<img
									class="h-10 w-10 rounded-full object-cover"
									:src="$page.props.user.profile_photo_url"
									:alt="$page.props.user.name"
								/>
							</div>

							<div>
								<div class="font-medium text-base text-gray-800">
									{{ $page.props.user.name }}
								</div>
								<div class="font-medium text-sm text-gray-500">
									{{ $page.props.user.email }}
								</div>
							</div>
						</div>

						<div class="mt-3 space-y-1">
							<jet-responsive-nav-link
								:href="route('profile.show')"
								:active="route().current('profile.show')"
							>
								Profiili
							</jet-responsive-nav-link>

							<jet-responsive-nav-link
								v-if="$page.props.jetstream.hasApiFeatures"
								:href="route('api-tokens.index')"
								:active="route().current('api-tokens.index')"
							>
								API Avaimet
							</jet-responsive-nav-link>

							<!-- Authentication -->
							<form method="POST" @submit.prevent="logout">
								<jet-responsive-nav-link role="button">
									Kirjaudu ulos
								</jet-responsive-nav-link>
							</form>
						</div>
					</div>
				</div>
			</nav>

			<!-- Page Heading -->
			<header v-if="$slots.header" class="bg-white shadow">
				<div class="max-w-7xl mx-auto py-6 px-4 md:px-6 lg:px-8">
					<slot name="header"></slot>
				</div>
			</header>

			<!-- Page Content -->
			<main>
				<slot></slot>
			</main>

			<!-- Modal Portal -->
			<portal-target name="modal" multiple> </portal-target>
		</div>
	</div>
</template>

<script>
import { Link as InertiaLink } from "@inertiajs/inertia-vue3"
import BreakPoints from "@/Helpers/Vue/Breakpoints.vue"
import JetApplicationMark from "@/Jetstream/ApplicationMark"
import JetBanner from "@/Jetstream/Banner"
import JetDropdown from "@/Jetstream/Dropdown"
import JetDropdownLink from "@/Jetstream/DropdownLink"
import JetDropdownSVG from "@/Jetstream/DropDownSVG"
import JetNavLink from "@/Jetstream/NavLink"
import JetResponsiveNavLink from "@/Jetstream/ResponsiveNavLink"

export default {
	components: {
		BreakPoints,
		JetApplicationMark,
		JetBanner,
		JetDropdown,
		JetDropdownLink,
		JetDropdownSVG,
		JetNavLink,
		JetResponsiveNavLink,
		InertiaLink
	},

	data() {
		return {
			showingNavigationDropdown: false
		}
	},
	computed: {
		developerMode() {
			return process.env.NODE_ENV === "development"
		}
	},
	methods: {
		logout() {
			// eslint-disable-next-line no-undef
			this.$inertia.post(route("logout"))
		}
	}
}
</script>

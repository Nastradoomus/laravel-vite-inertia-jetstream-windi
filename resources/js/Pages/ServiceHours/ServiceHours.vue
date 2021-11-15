<template>
	<app-layout>
		<template #header>
			<h2 class="font-semibold text-xl text-gray-800 text-2xl text-center">Aukioloajat</h2>
		</template>
		<div class="py-12">
			<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
				<div class="bg-white shadow-xl sm:rounded-lg pb-6">
					<div class="pt-2 px-6">
						<div class="font-semibold text-xl pb-1">Aukioloaikojen täyttöohje</div>
						<ul class="list-disc prose px-6 pb-3">
							<li>
								Raksi ruudussa, jolloin viikonpäivä ei ole punaisella, merkitsee sitä että olemme
								auki.
							</li>
							<li>
								Täyttäkää huolellisesti pyydetyt ajat. Jos päivä ei ole punaisella eli olemme auki
								ja jokin aika puuttuu se tulee puuttumaan myös asiakasnäkymästä.
							</li>
							<li>
								Jos olemme kiinni aukioloaikoja ei tarvitse poistaa vaan ne voivat odottaa rauhassa
								aukeamista.
							</li>
						</ul>
						<div class="font-semibold text-lg">Pidempiaikainen kiinniolo</div>
						<ul class="list-disc prose px-6">
							<li>Muista laittaa ensin kaikki päivät pois päältä.</li>
							<li>
								Jos kaikki ylläolevat päivät eivät ole punaisella on kyseinen paikka myös auki sinä
								päivänä.
							</li>
						</ul>
					</div>
					<div
						v-for="(d, i) in data"
						:key="d.title"
						class="grid grid-cols-1 lg:grid-cols-2 gap-4 p-2"
						@change="update(i)"
					>
						<div
							class="
								mt-3
								py-6
								text-grey-600 text-2xl text-center
								bg-gray-300
								lg:col-span-2
								bg-gray-300
							"
						>
							{{ capitalize(translate(d.title)) }}
						</div>
						<div class="justify-self-center">
							<div class="text-xl text-bold text-center mt-6 mb-3">
								{{ capitalize(translate(d.title)) }}n aukioloajat
							</div>
							<table class="table-auto break-words">
								<thead class="text-center font-semibold">
									<th class="px-1"></th>
									<th class="px-1">Viikon&shy;päivä</th>
									<th class="px-1">Avataan</th>
									<th class="px-1">&nbsp;</th>
									<th class="px-1">Suljetaan</th>
								</thead>
								<tr v-for="(day, j) in d.json" :key="j" :class="{ 'text-red-500': !day.openToday }">
									<td>
										<input class="ml-3 mr-1 rounded-md" type="checkbox" v-model="day.openToday" />
									</td>
									<td>
										<span class="pr-1">
											{{ day.day }}
										</span>
									</td>
									<td>
										<input
											:disabled="!day.openToday"
											:class="('text-red-500', day.openToday)"
											type="time"
											class="
												my-2
												rounded-md
												border-gray-300
												shadow-sm
												focus:border-indigo-300
												focus:ring
												focus:ring-indigo-200
												focus:ring-opacity-50
											"
											step="300"
											v-model="day.open"
										/>
										<div
											v-if="day.openToday && notValid(day.open)"
											class="text-center text-green-600 -mt-2"
										>
											Täytä
										</div>
										<div v-else-if="day.openToday" class="-mt-2">&nbsp;</div>
									</td>
									<td class="text-center">-</td>
									<td>
										<input
											type="time"
											:disabled="!day.openToday"
											class="
												mr-3
												my-2
												rounded-md
												border-gray-300
												shadow-sm
												focus:border-indigo-300
												focus:ring
												focus:ring-indigo-200
												focus:ring-opacity-50
												inline-block
											"
											v-model="day.close"
										/>
										<div
											v-if="day.openToday && notValid(day.close)"
											class="text-center text-green-600 -mt-2"
										>
											Täytä
										</div>
										<div v-else-if="day.openToday" class="-mt-2">&nbsp;</div>
									</td>
								</tr>
							</table>
						</div>
						<div>
							<div class="text-xl text-bold text-center mt-6 mb-3">
								{{ capitalize(translate(d.title)) }}n pidempiaikainen kiinniolo
							</div>
							<div class="text-bold text-center mt-6 mb-3">Avaamispäivä jos on tiedossa</div>
							<div class="flex justify-center">
								<div>
									<v-date-picker
										timezone="Europe/Helsinki"
										locale="fi"
										:min-date="new Date()"
										:value="d.closedUntil"
										@input="updateClosedUntil(i, $event)"
									/>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout"
import { axiosPost } from "@/Helpers/js/axios"
import { postServiceHoursApiUrl } from "@/Helpers/js/apiEndPoints"
import { capitalize } from "@/Helpers/js/common"
import { dateToStringYYYYMMDD } from "@/Helpers/js/dateFunctions"

const url = postServiceHoursApiUrl()

export default {
	components: {
		AppLayout
	},
	props: {
		data: Array
	},
	methods: {
		updateClosedUntil(dayIndex, date) {
			const i = dayIndex
			const isoDate = date ? dateToStringYYYYMMDD(date) : null
			this.update(i, isoDate)
		},
		notValid(string) {
			if (!string || !string.match(/\d+:\d+/)) {
				return true
			}
			return false
		},
		capitalize(string) {
			return capitalize(string)
		},
		translate(string) {
			if (string === "cafe") return "kahvila"
			if (string === "restaurant") return "ravintola"
			return undefined
		},
		async update(i, closedUntil) {
			const data = window._.pick(this.$props.data[i], ["title", "json", "closed_until"])
			if (closedUntil !== data.closed_until) {
				data.closed_until = closedUntil
			}
			const l = data.json.length
			for (let j = 0; j < l; j += 1) {
				const day = data.json[j]
				if (day.open === (undefined || "")) data.json[j].open = null
				if (day.close === (undefined || "")) data.json[j].close = null
			}
			const json = JSON.stringify(data)
			const response = await axiosPost({ url, json })
			if (response) {
				this.$message.success(response)
			} else this.$message.error("Tietojen tallentamisessa tapahtui virhe")
		}
	},
	created() {
		this.update = window._.debounce(this.update, 1000)
	}
}
</script>
<style>
tr:nth-child(2n) {
	background-color: rgba(0, 0, 0, 0.05);
}
</style>

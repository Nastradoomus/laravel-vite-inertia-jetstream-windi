<template>
  <div>
    <div class="py-6 px-3 sm:px-5 md:px-20 bg-white border-b border-gray-200">
      <div>
        <jet-application-logo class="block h-12 w-auto" />
      </div>

      <div class="mt-8 text-2xl">
        Tervetuloa Villa Sibben sivuston hallintaan.
      </div>
    </div>

    <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">
      <div class="p-6">
        <div class="flex items-center">
          <svg
            fill="none"
            stroke="currentColor"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            viewBox="0 0 24 24"
            class="w-8 h-8 text-gray-400"
          >
            <path
              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
            ></path>
          </svg>
          <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
            Ohjeita
          </div>
        </div>

        <div class="ml-12">
          <div class="mt-2 text-sm text-gray-500">
            Tiedot tallentuvat automaattisesti n. 1 sekunnin kuluttua siitä kun
            tietoa on muutettu. Täyttäkää siis tietoja aina rauhallisesti ja
            odotelkaa täyttämisen jälkeen hetken aikaa ennenkuin suljette
            selaimen tai menette toiselle sivulle.
            <br />
            <br />
            Pääsääntöisesti ne tiedot, jotka on täytetty näkyvät sivuilla.
            Joitain poikkeuksia voi olla esimerkiksi ruoka-annos joka on tyhjä,
            näkyy myös tyhjänä ruoka-annoksena sivuilla.
            <br />
            <br />
            Tarkistakaa tietojen täytön jälkeen aina vielä itse
            <a
              href="https://sibbe.fi"
              class="underline text-sm text-indigo-600 hover:text-indigo-900"
              >sivustolta</a
            >
            että tiedot näkyvät oikein.
          </div>
        </div>
      </div>

      <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
        <div class="flex items-center">
          <svg
            fill="currentColor"
            viewBox="0 0 24 24"
            class="w-8 h-8 text-gray-400"
          >
            <path
              d="M16.79,23C16.37,22.83 16.07,22.45 16,22C15.95,21.74 16,21.56 16.4,20.84C17.9,18.14 18.67,15.09 18.63,12C18.67,9 17.94,6.07 16.5,3.44C16.29,3 16.1,2.58 15.94,2.13C16,1.75 16.19,1.4 16.5,1.19C16.95,0.95 17.5,1 17.91,1.28C18.19,1.64 18.43,2 18.63,2.42C19.71,4.5 20.44,6.7 20.8,9C21.03,10.81 21.06,12.65 20.89,14.47C20.58,16.81 19.89,19.07 18.83,21.18C18.19,22.46 17.83,23 17.45,23C17.37,23 17.28,23 17.2,23C17.06,23 16.93,23 16.79,23V23M12.43,20.79C11.86,20.63 11.5,20.05 11.62,19.47C11.62,19.35 11.93,18.8 12.21,18.24C13.39,15.97 13.9,13.41 13.67,10.86C13.53,9.03 13,7.25 12.13,5.64C11.5,4.38 11.46,4.18 11.83,3.64C12.27,3.15 13,3.08 13.54,3.5C14.26,4.56 14.83,5.72 15.25,6.94C16.53,10.73 16.33,14.86 14.69,18.5C13.85,20.39 13.26,21 12.43,20.74V20.79M7.93,18.56C7.57,18.4 7.3,18.08 7.2,17.7C7.2,17.5 7.2,17.24 7.65,16.44C9.14,13.74 9.14,10.46 7.65,7.76C7,6.5 7,6.24 7.53,5.76C7.72,5.54 8,5.43 8.3,5.47C8.94,5.47 9.3,5.78 9.84,6.91C10.69,8.47 11.13,10.22 11.12,12C11.16,13.81 10.72,15.61 9.85,17.2C9.31,18.25 9.04,18.5 8.5,18.59C8.31,18.61 8.11,18.59 7.93,18.5V18.56M3.72,16.43C3.39,16.27 3.13,16 3,15.65C2.9,15.3 3,15 3.4,14.36C3.9,13.68 4.14,12.84 4.09,12C4.16,11.15 3.93,10.31 3.44,9.61C3.27,9.36 3.13,9.09 3,8.82C2.89,8.19 3.31,7.59 4,7.47C4.54,7.37 4.92,7.6 5.42,8.36C6.87,10.57 6.87,13.42 5.42,15.63C4.91,16.4 4.33,16.63 3.73,16.43H3.72Z"
            ></path>
          </svg>
          <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
            <a href="https://laracasts.com">Ohjelmisto</a>
          </div>
        </div>

        <div class="ml-12">
          <div class="mt-2 text-sm text-gray-500">
            Ohjelmistossa voi olla virheitä, jonka johdosta jokin asia ei näy
            sivuilla niinkuin pitää. Olisi siksi hyvä jos virheistä
            ilmoitettaisiin eteenpäin niin ne saadaan siten korjattua.
            <br />
            <br />
            Jos havaitsette ohjelmistossa virheitä tai parannettavaa niin otakaa
            yhteyttä sähköpostilla
            <a
              href="mailto:manne@helppoelama.net"
              class="underline text-sm text-indigo-600 hover:text-indigo-900"
              >manne@helppoelama.net</a
            >
            tai kiireellisissä asioissa puhelimitse
            <a
              href="tel:+358407578626"
              class="underline text-sm text-indigo-600 hover:text-indigo-900"
              >+358 40 757 8626</a
            >.
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import JetApplicationLogo from "@/Jetstream/Logo/ApplicationMark.vue";

export default {
  components: {
    JetApplicationLogo,
  },
};
</script>

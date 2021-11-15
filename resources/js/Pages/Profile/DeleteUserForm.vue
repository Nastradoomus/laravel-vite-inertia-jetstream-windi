<template>
  <jet-action-section>
    <template #title> Poista tili </template>

    <template #description> Poista käyttäjätilisi kokonaan. </template>

    <template #content>
      <div class="max-w-xl text-sm text-gray-600">
        Kun käyttäjätilisi poistetaan kaikki tilin tiedot poistuvat samalla.
        Ennen poisto mieti onko tilillä jotain jota voit tarvita myöhemmin.
      </div>

      <div class="mt-5">
        <jet-danger-button @click.native="confirmUserDeletion">
          Poista tili
        </jet-danger-button>
      </div>

      <!-- Delete Account Confirmation Modal -->
      <jet-dialog-modal :show="confirmingUserDeletion" @close="closeModal">
        <template #title> Poista tili </template>

        <template #content>
          Oletko varma että haluat poistaa tilisi? Syötä vielä varmuuden vuoksi
          salasana, jotta tiedämme että se olet sinä.
          <br /><br />
          <b>Tämä ominaisuus on toistaiseksi pois käytöstä.</b>

          <div class="mt-4">
            <jet-input
              type="password"
              class="mt-1 block w-3/4"
              placeholder="Salasana"
              ref="password"
              v-model="form.password"
              @keyup.enter.native="deleteUser"
            />

            <jet-input-error :message="form.errors.password" class="mt-2" />
          </div>
        </template>

        <template #footer>
          <jet-secondary-button @click.native="closeModal">
            Ei sittenkään...
          </jet-secondary-button>

          <jet-danger-button
            class="ml-2 disabled"
            @click.native="deleteUser"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            Poista tili
          </jet-danger-button>
        </template>
      </jet-dialog-modal>
    </template>
  </jet-action-section>
</template>

<script>
import JetActionSection from "@/Jetstream/ActionSection";
import JetDialogModal from "@/Jetstream/DialogModal";
import JetDangerButton from "@/Jetstream/DangerButton";
import JetInput from "@/Jetstream/Input";
import JetInputError from "@/Jetstream/InputError";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";

export default {
  components: {
    JetActionSection,
    JetDangerButton,
    JetDialogModal,
    JetInput,
    JetInputError,
    JetSecondaryButton,
  },

  data() {
    return {
      confirmingUserDeletion: false,

      form: this.$inertia.form({
        password: "",
      }),
    };
  },

  methods: {
    confirmUserDeletion() {
      this.confirmingUserDeletion = true;

      setTimeout(() => this.$refs.password.focus(), 250);
    },

    deleteUser() {
      this.form.delete(route("current-user.destroy"), {
        preserveScroll: true,
        onSuccess: () => this.closeModal(),
        onError: () => this.$refs.password.focus(),
        onFinish: () => this.form.reset(),
      });
    },

    closeModal() {
      this.confirmingUserDeletion = false;

      this.form.reset();
    },
  },
};
</script>

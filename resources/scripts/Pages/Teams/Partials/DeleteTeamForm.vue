<script setup lang="ts">
import { ref, reactive, toRefs } from "vue"
import { Inertia } from "@inertiajs/inertia"
import JetActionSection from "@/Jetstream/ActionSection.vue"
import JetConfirmationModal from "@/Jetstream/ConfirmationModal.vue"
import JetDangerButton from "@/Jetstream/DangerButton.vue"
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue"
import { Router } from "@inertiajs/inertia/types/router"

interface Form {
  form(): {
    processing: any
    delete(route: any, target: any): void
  }
}

const props = defineProps(["team"])

const { team } = toRefs(props)

const confirmingTeamDeletion = ref(false)
const deleting = ref(false)

const form = reactive((Inertia as Router & Form).form())
function confirmTeamDeletion() {
  confirmingTeamDeletion.value = true
}

function deleteTeam() {
  form.delete(route("teams.destroy", team.value), {
    errorBag: "deleteTeam"
  })
}
</script>
<template>
  <jet-action-section>
    <template #title> Delete Team </template>

    <template #description> Permanently delete this team. </template>

    <template #content>
      <div class="max-w-xl text-sm text-gray-600">
        Once a team is deleted, all of its resources and data will be
        permanently deleted. Before deleting this team, please download any data
        or information regarding this team that you wish to retain.
      </div>

      <div class="mt-5">
        <jet-danger-button @click="confirmTeamDeletion">
          Delete Team
        </jet-danger-button>
      </div>

      <!-- Delete Team Confirmation Modal -->
      <jet-confirmation-modal
        :show="confirmingTeamDeletion"
        @close="confirmingTeamDeletion = false"
      >
        <template #title> Delete Team </template>

        <template #content>
          Are you sure you want to delete this team? Once a team is deleted, all
          of its resources and data will be permanently deleted.
        </template>

        <template #footer>
          <jet-secondary-button @click="confirmingTeamDeletion = false">
            Cancel
          </jet-secondary-button>

          <jet-danger-button
            class="ml-2"
            @click="deleteTeam"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            Delete Team
          </jet-danger-button>
        </template>
      </jet-confirmation-modal>
    </template>
  </jet-action-section>
</template>

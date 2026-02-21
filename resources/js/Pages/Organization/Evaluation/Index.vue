<template>
  <OrganizationLayout>
    <div class="p-6 bg-white rounded shadow">
      <h1 class="text-2xl font-bold text-green-600 mb-4">All Event Evaluations</h1>
      <table class="w-full border border-gray-300">
        <thead class="bg-gray-200">
          <tr>
            <th class="p-2 border">Event Name</th>
            <th class="p-2 border text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          <!-- Loop through finished events -->
          <tr v-for="event in events" :key="event.id">
            <td class="p-2 border">{{ event.event_name }}</td>
            <td class="p-2 border text-center space-x-2">
              <!-- View Evaluation Results -->
              <a
                :href="`/organization/evaluations/${event.id}/results`"
                class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700"
              >
                View Results
              </a>
              <!-- View QR Code -->
              <a
                :href="`/organization/evaluations/${event.id}/qr`"
                class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700"
              >
                View QR
              </a>
            </td>
          </tr>
          <!-- If no finished events -->
          <tr v-if="events.length === 0">
            <td colspan="2" class="p-3 text-center text-gray-500">
              No finished events available for evaluation.
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </OrganizationLayout>
</template>

<script setup>
import OrganizationLayout from '@/Layouts/OrganizationLayout.vue';

const props = defineProps({
  events: {
    type: Array,
    default: () => [],
  },
});
</script>

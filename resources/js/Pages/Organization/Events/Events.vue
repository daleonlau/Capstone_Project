<template>
  <OrganizationLayout>
    <div class="bg-white rounded-lg shadow-md p-6 text-black">
      <!-- Header -->
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-red-600">Activity Design</h1>
        <button
          @click="showModal = true"
          class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700"
        >
          + Create Activity
        </button>
      </div>

      <!-- Filter -->
      <div class="mb-4">
        <label for="status" class="font-semibold mr-2">Filter by Status:</label>
        <select
          v-model="filterStatus"
          id="status"
          class="border rounded px-3 py-2"
        >
          <option value="">All</option>
          <option value="Pending">Pending</option>
          <option value="Approved">Approved</option>
          <option value="Finished">Finished</option>
        </select>
      </div>

      <!-- Event List -->
      <table class="w-full border border-gray-300 rounded-lg overflow-hidden">
        <thead class="bg-gray-200">
          <tr>
            <th class="p-2 border">Name</th>
            <th class="p-2 border">Date</th>
            <th class="p-2 border">Fee</th>
            <th class="p-2 border">Year Level</th>
            <th class="p-2 border">Department</th>
            <th class="p-2 border">Course</th>
            <th class="p-2 border">Status</th>
            <th class="p-2 border">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="event in filteredEvents"
            :key="event.id"
            class="hover:bg-gray-100"
          >
            <td class="p-2 border">{{ event.event_name }}</td>
            <td class="p-2 border">{{ event.event_date }}</td>
            <td class="p-2 border">₱{{ event.event_fee }}</td>
            <td class="p-2 border">{{ event.year_level }}</td>
            <td class="p-2 border">{{ event.department }}</td>
            <td class="p-2 border">{{ event.course }}</td>
            <td class="p-2 border">
              <span
                class="px-2 py-1 rounded text-sm font-medium"
                :class="{
                  'bg-yellow-200 text-yellow-800': event.status === 'Pending',
                  'bg-green-200 text-green-800': event.status === 'Approved',
                  'bg-purple-200 text-purple-800': event.status === 'Finished'
                }"
              >
                {{ event.status }}
              </span>
            </td>
            <td class="p-2 border flex gap-2 items-center">
              <button
                v-if="event.status === 'Pending'"
                @click="approveEvent(event.id)"
                class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 text-sm"
              >
                Approve
              </button>

              <button
                v-if="event.status === 'Approved'"
                @click="finishEvent(event.id)"
                class="bg-purple-600 text-white px-3 py-1 rounded hover:bg-purple-700 text-sm"
              >
                Mark as Finished
              </button>

              <Link
                :href="`/organization/events/${event.id}/edit`"
                class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-sm"
              >
                Edit
              </Link>

              <button
                @click="deleteEvent(event.id)"
                class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm"
              >
                Delete
              </button>
            </td>
          </tr>
          <tr v-if="filteredEvents.length === 0">
            <td colspan="8" class="text-center p-4 text-gray-500">
              No events found
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Create Event Modal -->
    <CreateEventModal :show="showModal" @close="showModal = false" />
  </OrganizationLayout>
</template>

<script setup>
import { ref, computed } from "vue";
import { Link, router } from "@inertiajs/vue3";
import OrganizationLayout from "@/Layouts/OrganizationLayout.vue";
import CreateEventModal from "./CreateEvent.vue";

const props = defineProps({ events: Array });
const filterStatus = ref("");
const showModal = ref(false);

const filteredEvents = computed(() => {
  if (!filterStatus.value) return props.events;
  return props.events.filter((e) => e.status === filterStatus.value);
});

// Delete event
const deleteEvent = (id) => {
  if (confirm("Are you sure you want to delete this event?")) {
    router.delete(`/organization/events/${id}`);
  }
};

// Approve event
const approveEvent = (id) => {
  router.patch(`/organization/events/${id}/approve`);
};

// Finish event
const finishEvent = (id) => {
  if (confirm("Mark this event as Finished? This will enable evaluation QR.")) {
    router.patch(`/organization/events/${id}/finish`);
  }
};
</script>

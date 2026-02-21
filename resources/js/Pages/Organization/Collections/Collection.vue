<template>
  <OrganizationLayout>
    <div class="p-6 space-y-8">
      <!-- Title -->
      <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-800">Collection Management</h1>
        <p class="text-gray-500">Welcome back, Organization 👋</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Event List -->
        <div
          class="bg-gradient-to-r from-blue-50 to-blue-100 p-5 rounded-xl shadow-md border border-blue-200"
        >
          <h2 class="text-xl font-semibold mb-4 text-blue-800">Events</h2>
          <ul class="space-y-2">
            <li
              v-for="event in events"
              :key="event.id"
              @click="selectEvent(event.id)"
              class="cursor-pointer p-3 rounded-lg border transition flex justify-between items-center hover:scale-105 hover:shadow-lg"
              :class="{
                'bg-blue-100 border-blue-400 shadow-inner': selectedEvent && selectedEvent.id === event.id
              }"
            >
              <div>
                <span class="font-medium text-gray-800">{{ event.event_name }}</span>
                <p class="text-sm text-gray-500">{{ event.course }} - {{ event.year_level }}</p>
              </div>
              <span
                class="text-xs font-semibold px-3 py-1 rounded-full"
                :class="{
                  'bg-green-100 text-green-700': event.status === 'Approved',
                  'bg-yellow-100 text-yellow-700': event.status === 'Finished' || event.status === 'Completed'
                }"
              >
                {{ event.status }}
              </span>
            </li>

            <li v-if="events.length === 0" class="text-gray-500 text-sm text-center py-4">
              No events found.
            </li>
          </ul>
        </div>

        <!-- Students List -->
        <div
          class="md:col-span-2 bg-gradient-to-r from-gray-50 to-gray-100 p-6 rounded-xl shadow-md border border-gray-200 relative"
        >
          <h2 class="text-xl font-semibold mb-6 text-gray-800">
            Students for {{ selectedEvent ? selectedEvent.event_name : '...' }}
          </h2>

          <table
            v-if="selectedEvent"
            class="w-full border border-gray-300 text-sm rounded-lg overflow-hidden shadow-sm"
          >
            <thead class="bg-gray-200">
              <tr>
                <th class="p-3 border">Student ID</th>
                <th class="p-3 border">Full Name</th>
                <th class="p-3 border">Course</th>
                <th class="p-3 border">Year Level</th>
                <th class="p-3 border">Payment Status</th>
                <th class="p-3 border">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="student in students"
                :key="student.student_id"
                class="hover:bg-gray-50 transition"
              >
                <td class="p-2 border">{{ student.student_id }}</td>
                <td class="p-2 border">{{ student.firstname }} {{ student.lastname }}</td>
                <td class="p-2 border">{{ student.course }}</td>
                <td class="p-2 border">{{ student.yearlevel }}</td>
                <td class="p-2 border">
                  <span
                    v-if="isPaid(student)"
                    class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700 font-semibold"
                    >Paid</span
                  >
                  <span
                    v-else
                    class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700 font-semibold"
                    >Unpaid</span
                  >
                </td>
                <td class="p-2 border text-center">
                  <button
                    v-if="!isPaid(student)"
                    @click="confirmPayment(student)"
                    class="bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700 transition text-sm shadow-sm hover:shadow-md"
                  >
                    Pay
                  </button>
                  <span v-else class="text-gray-500 text-xs italic">Paid</span>
                </td>
              </tr>

              <tr v-if="students.length === 0">
                <td colspan="6" class="text-center text-gray-500 p-4">
                  No students found for this event.
                </td>
              </tr>
            </tbody>
          </table>

          <p v-else class="text-gray-500 text-sm">
            Please select an event to view students.
          </p>
        </div>
      </div>

      <!-- ✅ Confirmation Modal -->
      <div
        v-if="showConfirmModal"
        class="fixed inset-0 flex items-center justify-center z-50 pointer-events-auto"
      >
        <div
          class="bg-white rounded-2xl shadow-2xl p-8 w-96 text-center animate-popIn border-t-4 border-blue-600"
        >
          <h2 class="text-xl font-bold text-gray-800 mb-4">Confirm Payment</h2>
          <p class="text-gray-600 mb-6">
            Are you sure you want to mark this student as <strong>Paid</strong>?
          </p>
          <div class="flex justify-center gap-4">
            <button
              @click="processPayment"
              class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition shadow"
            >
              Yes, Confirm
            </button>
            <button
              @click="showConfirmModal = false"
              class="bg-gray-300 text-gray-800 px-5 py-2 rounded-lg hover:bg-gray-400 transition"
            >
              Cancel
            </button>
          </div>
        </div>
      </div>

      <!-- ✅ Success Modal -->
      <div
        v-if="showSuccessModal"
        class="fixed inset-0 flex items-center justify-center z-50 pointer-events-auto"
      >
        <div
          class="bg-white rounded-2xl shadow-2xl p-8 w-80 text-center animate-popIn border-t-4 border-green-600"
        >
          <i class="fa-solid fa-circle-check text-green-500 text-5xl mb-3 animate-bounce"></i>
          <h2 class="text-2xl font-semibold text-gray-800 mb-2">Payment Successful!</h2>
          <p class="text-gray-600 mb-6">The student payment has been recorded.</p>
          <button
            @click="closeSuccessModal"
            class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition shadow"
          >
            OK
          </button>
        </div>
      </div>

      <!-- ⚠️ Error Modal -->
      <div
        v-if="showErrorModal"
        class="fixed inset-0 flex items-center justify-center z-50 pointer-events-auto"
      >
        <div
          class="bg-white rounded-2xl shadow-2xl p-8 w-80 text-center animate-popIn border-t-4 border-red-600"
        >
          <i class="fa-solid fa-triangle-exclamation text-red-500 text-5xl mb-3"></i>
          <h2 class="text-2xl font-semibold text-gray-800 mb-2">Payment Failed!</h2>
          <p class="text-gray-600 mb-6">{{ errorMessage }}</p>
          <button
            @click="closeErrorModal"
            class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition shadow"
          >
            OK
          </button>
        </div>
      </div>
    </div>
  </OrganizationLayout>
</template>

<script setup>
import { ref, computed, watch } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import OrganizationLayout from "@/Layouts/OrganizationLayout.vue";

const props = defineProps({
  events: Array,
  selectedEvent: Object,
  students: Array,
});

const showConfirmModal = ref(false);
const showSuccessModal = ref(false);
const showErrorModal = ref(false);
const selectedStudentId = ref(null);
const errorMessage = ref("");

const page = usePage();
const flash = computed(() => page.props?.flash || {});

// 🔔 Automatically display modals for Laravel flash messages
watch(
  flash,
  (f) => {
    if (f?.success) {
      showSuccessModal.value = true;
      setTimeout(() => (showSuccessModal.value = false), 2000);
    }
    if (f?.error) {
      errorMessage.value = f.error;
      showErrorModal.value = true;
    }
  },
  { deep: true }
);

function selectEvent(eventId) {
  router.visit(`/organization/collections/${eventId}`);
}

function isPaid(student) {
  if (!student.events || student.events.length === 0) return false;
  return student.events.some((e) => e.pivot && e.pivot.status === "Paid");
}

function confirmPayment(student) {
  selectedStudentId.value = student.student_id;
  showConfirmModal.value = true;
}

function processPayment() {
  if (!props.selectedEvent || !selectedStudentId.value) return;

  router.post(
    `/organization/collections/${props.selectedEvent.id}/${selectedStudentId.value}/pay`,
    {},
    {
      onSuccess: () => {
        showConfirmModal.value = false;
        showSuccessModal.value = true;

        // Auto close after 2s
        setTimeout(() => (showSuccessModal.value = false), 2000);
      },
      onError: () => {
        showConfirmModal.value = false;
        errorMessage.value = "Something went wrong while confirming payment.";
        showErrorModal.value = true;
      },
    }
  );
}

function closeSuccessModal() {
  showSuccessModal.value = false;
}

function closeErrorModal() {
  showErrorModal.value = false;
}
</script>

<style scoped>
@keyframes popIn {
  0% {
    transform: scale(0.9);
    opacity: 0;
  }
  100% {
    transform: scale(1);
    opacity: 1;
  }
}
.animate-popIn {
  animation: popIn 0.25s ease-out forwards;
}
</style>

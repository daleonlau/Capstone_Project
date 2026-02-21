<template>
  <AuthLayout>
    <div class="p-6 flex gap-6">
      <!-- Event Info -->
      <div class="w-1/2 bg-white rounded shadow p-4 text-black">
        <h2 class="font-semibold mb-2 text-red-600 text">{{ event.event_name }}</h2>
        <p><strong>Date:</strong> {{ event.event_date }}</p>
        <p><strong>Course:</strong> {{ event.course }}</p>
        <p><strong>Year Level:</strong> {{ event.year_level }}</p>
        <p><strong>Fee:</strong> ₱{{ event.event_fee }}</p>
      </div>

      <!-- Students Table -->
      <div class="w-1/2 bg-white rounded shadow p-4 overflow-auto max-h-[70vh]">
        <h2 class="font-semibold mb-2 text-red-600">Students</h2>
        <table class="w-full border">
          <thead class="bg-gray-200 text-black">
            <tr>
              <th class="p-2 border">Name</th>
              <th class="p-2 border">ID Number</th> 
              <th class="p-2 border">Course</th>
              <th class="p-2 border">Year Level</th>
              <th class="p-2 border">Status</th>
              <th class="p-2 border">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="student in students" :key="student.student_id" class="hover:bg-gray-100 text-black">
              <td class="p-2 border">{{ student.firstname }} {{ student.lastname }}</td>
              <td class="p-2 border">{{ student.student_id }}</td>
              <td class="p-2 border">{{ student.course }}</td>
              <td class="p-2 border">{{ student.yearlevel }}</td>
              <td class="p-2 border">{{ student.pivot.status }}</td>
              <td class="p-2 border">
                <button
                  v-if="student.pivot.status !== 'Paid'"
                  @click="payStudent(student)"
                  class="bg-green-600 text-black px-3 py-1 rounded hover:bg-green-700 text-sm"
                >
                  Pay
                </button>
                <span v-else class="text-gray-500 text-sm">Paid</span>
              </td>
            </tr>
            <tr v-if="students.length === 0">
              <td colspan="6" class="text-center p-4 text-gray-500">No students found</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AuthLayout>
</template>

<script setup>
import { router } from '@inertiajs/vue3';
import AuthLayout from '@/Layouts/AuthLayout.vue';

const props = defineProps({
  event: Object,       // Event object with columns: event_name, event_date, course, year_level, event_fee
  students: Array      // Array of students with pivot data
});

// Function to mark a student as paid
const payStudent = (student) => {
  if (confirm(`Mark ${student.firstname} ${student.lastname} as paid?`)) {
    router.post(`/collection/${props.event.event_id}/${student.student_id}/pay`, {}, {
      onSuccess: () => {
        alert('Payment updated successfully!');
        // Refresh the page or students list
        location.reload();
      },
      onError: (errors) => {
        console.error(errors);
        alert('Failed to update payment.');
      }
    });
  }
};
</script>

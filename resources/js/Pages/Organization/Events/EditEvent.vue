<template>
    <OrganizationLayout>
      <div class="bg-white rounded-lg shadow-md p-6 text-black max-w-lg mx-auto">
        <h1 class="text-2xl font-bold mb-6 text-red-600">Edit Event</h1>
  
        <form @submit.prevent="submit">
          <!-- Event Name -->
          <div class="mb-4">
            <label for="event_name" class="block font-semibold mb-1">Event Name</label>
            <input
              v-model="form.event_name"
              type="text"
              id="event_name"
              class="w-full border rounded px-3 py-2"
              required
            />
            <div v-if="form.errors.event_name" class="text-red-500 text-sm mt-1">
              {{ form.errors.event_name }}
            </div>
          </div>
  
          <!-- Event Date -->
          <div class="mb-4">
            <label for="event_date" class="block font-semibold mb-1">Event Date</label>
            <input
              v-model="form.event_date"
              type="date"
              id="event_date"
              class="w-full border rounded px-3 py-2"
              required
            />
            <div v-if="form.errors.event_date" class="text-red-500 text-sm mt-1">
              {{ form.errors.event_date }}
            </div>
          </div>
  
          <!-- Event Fee -->
          <div class="mb-4">
            <label for="event_fee" class="block font-semibold mb-1">Fee</label>
            <input
              v-model="form.event_fee"
              type="number"
              step="0.01"
              id="event_fee"
              class="w-full border rounded px-3 py-2"
            />
            <div v-if="form.errors.event_fee" class="text-red-500 text-sm mt-1">
              {{ form.errors.event_fee }}
            </div>
          </div>
  
          <!-- Course -->
          <div class="mb-4">
            <label for="course" class="block font-semibold mb-1">Course</label>
            <select
              v-model="form.course"
              id="course"
              class="w-full border rounded px-3 py-2"
              required
            >
              <option value="">Select course</option>
              <option value="Bachelor of Science in Information Technology">BSIT</option>
              <option value="Bachelor of Science in Computer Science">BSCS</option>
              <option value="Bachelor of Science in Information Systems">BSIS</option>
            </select>
            <div v-if="form.errors.course" class="text-red-500 text-sm mt-1">
              {{ form.errors.course }}
            </div>
          </div>
  
          <!-- Year Level -->
          <div class="mb-4">
            <label for="year_level" class="block font-semibold mb-1">Year Level</label>
            <select
              v-model="form.year_level"
              id="year_level"
              class="w-full border rounded px-3 py-2"
              required
            >
              <option value="">Select year level</option>
              <option value="firstyear">First Year</option>
              <option value="secondyear">Second Year</option>
              <option value="thirdyear">Third Year</option>
              <option value="fourthyear">Fourth Year</option>
            </select>
            <div v-if="form.errors.year_level" class="text-red-500 text-sm mt-1">
              {{ form.errors.year_level }}
            </div>
          </div>
  
          <!-- Department -->
          <div class="mb-4">
            <label for="department" class="block font-semibold mb-1">Department</label>
            <input
              v-model="form.department"
              type="text"
              id="department"
              class="w-full border rounded px-3 py-2"
            />
            <div v-if="form.errors.department" class="text-red-500 text-sm mt-1">
              {{ form.errors.department }}
            </div>
          </div>
  
          <!-- Status -->
          <div class="mb-4">
            <label for="status" class="block font-semibold mb-1">Status</label>
            <select
              v-model="form.status"
              id="status"
              class="w-full border rounded px-3 py-2"
            >
              <option value="Pending">Pending</option>
              <option value="Approved">Approved</option>
            </select>
            <div v-if="form.errors.status" class="text-red-500 text-sm mt-1">
              {{ form.errors.status }}
            </div>
          </div>
  
          <!-- Buttons -->
          <div class="flex justify-between mt-6">
            <Link
              href="/activity-design"
              class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
            >
              Cancel
            </Link>
            <button
              type="submit"
              class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700"
              :disabled="form.processing"
            >
              {{ form.processing ? "Updating..." : "Update Event" }}
            </button>
          </div>
        </form>
      </div>
    </OrganizationLayout>
  </template>
  
  <script setup>
  import { useForm, Link } from "@inertiajs/vue3";
  import OrganizationLayout from "@/Layouts/OrganizationLayout.vue";

  
  const props = defineProps({
    event: Object,
    errors: Object,
  });
  
  // Prefill form with existing event data
  const form = useForm({
    event_name: props.event.event_name,
    event_date: props.event.event_date,
    event_fee: props.event.event_fee,
    course: props.event.course,
    year_level: props.event.year_level,
    department: props.event.department,
    status: props.event.status,
  });
  
  // Submit form to update event
  const submit = () => {
    form.put(`/activity-design/${props.event.event_id}`, {
      onSuccess: () => form.reset(),
    });
  };
  </script>
  
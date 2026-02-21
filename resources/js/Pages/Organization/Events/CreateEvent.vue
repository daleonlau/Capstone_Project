<template>
  <div
    v-if="show"
    class="fixed inset-0 flex justify-center items-start pt-20 z-50"
  >
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-lg relative">
      <h1 class="text-2xl font-bold text-red-600 mb-6">Create New Event</h1>

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
          <select v-model="form.status" id="status" class="w-full border rounded px-3 py-2">
            <option value="Pending">Pending</option>
            <option value="Approved">Approved</option>
          </select>
          <div v-if="form.errors.status" class="text-red-500 text-sm mt-1">
            {{ form.errors.status }}
          </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex justify-end gap-2">
          <button
            type="button"
            @click="$emit('close')"
            class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400"
          >
            Cancel
          </button>
          <button
            type="submit"
            class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700"
            :disabled="form.processing"
          >
            {{ form.processing ? "Saving..." : "Save Event" }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
  show: Boolean,
});

const form = useForm({
  event_name: "",
  event_date: "",
  event_fee: "",
  course: "",
  year_level: "",
  department: "",
  status: "Pending",
});

const submit = () => {
  form.post("/organization/events", {
    onSuccess: () => {
      form.reset();
      // Emit close event to parent
      props.show && (props.show = false);
      emit("close");
    },
  });
};

const emit = defineEmits(["close"]);
</script>

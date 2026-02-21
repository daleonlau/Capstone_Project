<template>
  <OrganizationLayout>
    <div class="bg-white rounded-lg shadow-md p-6 text-black max-w-lg mx-auto">
      <h1 class="text-2xl font-bold text-red-600 mb-6">Add Student</h1>

      <form @submit.prevent="submit">
        <!-- Student ID -->
        <div class="mb-4">
          <label for="student_id" class="block font-semibold mb-1">Student ID</label>
          <input
            v-model="form.student_id"
            type="text"
            id="student_id"
            class="w-full border rounded px-3 py-2"
            required
          />
          <span v-if="form.errors.student_id" class="text-red-600 text-sm">{{ form.errors.student_id }}</span>
        </div>

        <!-- First Name -->
        <div class="mb-4">
          <label for="firstname" class="block font-semibold mb-1">First Name</label>
          <input
            v-model="form.firstname"
            type="text"
            id="firstname"
            class="w-full border rounded px-3 py-2"
            required
          />
          <span v-if="form.errors.firstname" class="text-red-600 text-sm">{{ form.errors.firstname }}</span>
        </div>

        <!-- Last Name -->
        <div class="mb-4">
          <label for="lastname" class="block font-semibold mb-1">Last Name</label>
          <input
            v-model="form.lastname"
            type="text"
            id="lastname"
            class="w-full border rounded px-3 py-2"
            required
          />
          <span v-if="form.errors.lastname" class="text-red-600 text-sm">{{ form.errors.lastname }}</span>
        </div>

        <!-- Course -->
        <div class="mb-4">
          <label for="course" class="block font-semibold mb-1">Course</label>
          <input
            v-model="form.course"
            type="text"
            id="course"
            class="w-full border rounded px-3 py-2"
          />
          <span v-if="form.errors.course" class="text-red-600 text-sm">{{ form.errors.course }}</span>
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
          <span v-if="form.errors.department" class="text-red-600 text-sm">{{ form.errors.department }}</span>
        </div>

        <!-- Year Level -->
        <div class="mb-4">
          <label for="yearlevel" class="block font-semibold mb-1">Year Level</label>
          <select
            v-model="form.yearlevel"
            id="yearlevel"
            class="w-full border rounded px-3 py-2"
          >
            <option value="">Select year level</option>
            <option value="firstyear">First Year</option>
            <option value="secondyear">Second Year</option>
            <option value="thirdyear">Third Year</option>
            <option value="fourthyear">Fourth Year</option>
          </select>
          <span v-if="form.errors.yearlevel" class="text-red-600 text-sm">{{ form.errors.yearlevel }}</span>
        </div>

        <!-- Buttons -->
        <div class="flex justify-between mt-6">
          <Link href="/students" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</Link>
          <button
            type="submit"
            class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700"
            :disabled="form.processing"
          >
            {{ form.processing ? "Saving..." : "Save Student" }}
          </button>
        </div>
      </form>
    </div>
  </OrganizationLayout>
</template>

<script setup>
import { useForm, Link } from "@inertiajs/vue3";
import OrganizationLayout from "@/Layouts/OrganizationLayout.vue";

const form = useForm({
  student_id: "",
  firstname: "",
  lastname: "",
  course: "",
  department: "",
  yearlevel: "",
});

const submit = () => {
  form.post("/organization/students", {
    onSuccess: () => {
      form.reset();
    },
  });
};
</script>

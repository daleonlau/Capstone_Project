<template>
  <OrganizationLayout>
    <div class="bg-white rounded-lg shadow-md p-6 text-black max-w-lg mx-auto">
      <h1 class="text-2xl font-bold text-red-600 mb-6">Bulk Upload Students</h1>

      <form @submit.prevent="submit" enctype="multipart/form-data">
        <div class="mb-4">
          <label class="block font-semibold mb-1">Upload CSV/Excel File</label>
          <input type="file" @change="handleFile" class="w-full border rounded px-3 py-2" accept=".csv,.xlsx"/>
          <span v-if="form.errors.file" class="text-red-600 text-sm">{{ form.errors.file }}</span>
        </div>

        <div class="flex justify-between mt-6">
          <Link href="/organization/students" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            Cancel
          </Link>
          <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700" :disabled="form.processing">
            {{ form.processing ? "Uploading..." : "Upload & Import" }}
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
  file: null,
});

const handleFile = (e) => {
  form.file = e.target.files[0];
};

const submit = () => {
  form.post("/organization/students/bulk-upload", { forceFormData: true });
};
</script>

<template>
  <AdminLayout>
    <div class="bg-white rounded-lg shadow-md p-6 text-black max-w-lg mx-auto">
      <h1 class="text-2xl font-bold text-red-600 mb-6">Register Organization Account</h1>

      <form @submit.prevent="submit">
        <!-- Organization Name -->
        <div class="mb-4">
          <label for="name" class="block font-semibold mb-1">Organization Name</label>
          <input v-model="form.name" type="text" id="name" class="w-full border rounded px-3 py-2" required />
          <span v-if="form.errors.name" class="text-red-600 text-sm">{{ form.errors.name }}</span>
        </div>

        <!-- Email -->
        <div class="mb-4">
          <label for="email" class="block font-semibold mb-1">Email</label>
          <input v-model="form.email" type="email" id="email" class="w-full border rounded px-3 py-2" required />
          <span v-if="form.errors.email" class="text-red-600 text-sm">{{ form.errors.email }}</span>
        </div>

        <!-- Password -->
        <div class="mb-4">
          <label for="password" class="block font-semibold mb-1">Password</label>
          <input v-model="form.password" type="password" id="password" class="w-full border rounded px-3 py-2" required />
          <span v-if="form.errors.password" class="text-red-600 text-sm">{{ form.errors.password }}</span>
        </div>

        <div class="flex justify-between mt-6">
          <Link href="/admin/dashboard" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</Link>
          <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700" :disabled="form.processing">
            {{ form.processing ? "Registering..." : "Register Organization" }}
          </button>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>

<script setup>
import { useForm, Link } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";

const form = useForm({
  name: "",
  email: "",
  password: "",
});

const submit = () => {
  form.post("/admin/organizations");
};
</script>

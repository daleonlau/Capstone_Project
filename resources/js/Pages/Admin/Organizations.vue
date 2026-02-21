<template>
  <AdminLayout>
    <div class="p-6 bg-gray-50 min-h-screen">
      <!-- Header -->
      <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-extrabold text-red-600 tracking-tight">
          Manage Organizations
        </h1>
        <div class="h-1 w-24 bg-red-600 rounded-full"></div>
      </div>

      <!-- Two-column layout -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Left: Table of Organizations -->
        <div class="bg-white shadow-lg rounded-2xl border border-gray-100 p-6">
          <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-700">
              Registered Organizations
            </h2>
            <span
              class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full"
              >{{ organizations.length }} total</span
            >
          </div>

          <div class="overflow-x-auto rounded-md border border-gray-200">
            <table class="w-full text-left text-gray-700">
              <thead class="bg-gray-100 text-sm uppercase tracking-wide">
                <tr>
                  <th class="p-3">Name</th>
                  <th class="p-3">Email</th>
                  <th class="p-3 text-center">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="org in organizations"
                  :key="org.id"
                  class="hover:bg-gray-50 transition border-t"
                >
                  <td class="p-3 font-medium">{{ org.name }}</td>
                  <td class="p-3">{{ org.email }}</td>
                  <td class="p-3 text-center flex justify-center gap-2">
                    <!-- Edit Password -->
                    <button
                      @click="openPasswordModal(org)"
                      class="flex items-center gap-1 bg-blue-500 hover:bg-blue-600 text-white text-sm px-3 py-1.5 rounded-md shadow-sm transition"
                    >
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 11c0-1.657 1.343-3 3-3s3 1.343 3 3v1H12v-1zM9 15h6v2H9v-2zm3-10a5 5 0 00-5 5v2h10V10a5 5 0 00-5-5z" />
                      </svg>
                      Edit
                    </button>

                    <!-- Delete -->
                    <button
                      @click="openDeleteModal(org)"
                      class="bg-red-500 hover:bg-red-600 text-white text-sm px-3 py-1.5 rounded-md shadow-sm transition"
                    >
                      Delete
                    </button>
                  </td>
                </tr>

                <tr v-if="organizations.length === 0">
                  <td colspan="3" class="p-4 text-center text-gray-500">
                    No organizations found.
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Right: Register Organization Form -->
        <div class="bg-white shadow-lg rounded-2xl border border-gray-100 p-6">
          <h2 class="text-xl font-semibold text-gray-700 mb-4">
            Register New Organization
          </h2>

          <form @submit.prevent="confirmRegister" class="space-y-5">
            <div>
              <label class="block text-sm font-medium text-gray-600 mb-1">
                Organization Name
              </label>
              <input
                v-model="form.name"
                type="text"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500"
                placeholder="Enter organization name"
                required
              />
              <span v-if="form.errors.name" class="text-red-600 text-sm">
                {{ form.errors.name }}
              </span>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-600 mb-1">
                Organization Email
              </label>
              <input
                v-model="form.email"
                type="email"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500"
                placeholder="Enter email address"
                required
              />
              <span v-if="form.errors.email" class="text-red-600 text-sm">
                {{ form.errors.email }}
              </span>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-600 mb-1">
                Password
              </label>
              <input
                v-model="form.password"
                type="password"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500"
                placeholder="Enter password"
                required
              />
              <span v-if="form.errors.password" class="text-red-600 text-sm">
                {{ form.errors.password }}
              </span>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-600 mb-1">
                Confirm Password
              </label>
              <input
                v-model="form.password_confirmation"
                type="password"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500"
                placeholder="Re-enter password"
                required
              />
            </div>

            <div class="flex justify-end">
              <button
                type="submit"
                class="bg-red-600 hover:bg-red-700 text-white font-semibold px-5 py-2 rounded-lg shadow transition"
              >
                Register Organization
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- Registration Confirmation Modal -->
      <transition name="fade">
        <div
          v-if="showConfirmModal"
          class="fixed inset-0 flex items-center justify-center z-50"
          @click.self="cancelRegistration"
        >
          <div
            class="bg-white border border-gray-200 rounded-xl shadow-2xl p-8 w-full max-w-md text-center"
          >
            <h2 class="text-2xl font-bold text-gray-800 mb-3">
              Confirm Registration
            </h2>
            <p class="text-gray-600 mb-6">
              Do you want to confirm the registration of this organization?
            </p>
            <div class="flex justify-center gap-4">
              <button
                @click="cancelRegistration"
                class="px-5 py-2 rounded-lg border border-gray-400 hover:bg-gray-100 transition"
              >
                No
              </button>
              <button
                @click="registerOrganization"
                class="px-5 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 transition"
              >
                Yes, Confirm
              </button>
            </div>
          </div>
        </div>
      </transition>

      <!-- Password Update Modal -->
      <transition name="fade">
        <div
          v-if="showPasswordModal"
          class="fixed inset-0 flex items-center justify-center z-50"
          @click.self="closePasswordModal"
        >
          <div
            class="bg-white border border-gray-200 rounded-xl shadow-2xl p-8 w-full max-w-md text-center"
          >
            <h2 class="text-2xl font-bold text-blue-600 mb-3">
              Update Password for {{ selectedOrg.name }}
            </h2>
            <div class="space-y-4">
              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">
                  New Password
                </label>
                <input
                  v-model="form.password"
                  type="password"
                  class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                  placeholder="Enter new password"
                />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">
                  Confirm Password
                </label>
                <input
                  v-model="form.password_confirmation"
                  type="password"
                  class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                  placeholder="Re-enter new password"
                />
              </div>
            </div>
            <div class="flex justify-center gap-4 mt-6">
              <button
                @click="closePasswordModal"
                class="px-5 py-2 rounded-lg border border-gray-400 hover:bg-gray-100 transition"
              >
                Cancel
              </button>
              <button
                @click="updatePassword"
                class="px-5 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition"
              >
                Update Password
              </button>
            </div>
          </div>
        </div>
      </transition>

      <!-- Delete Confirmation Modal -->
      <transition name="fade">
        <div
          v-if="showDeleteModal"
          class="fixed inset-0 flex items-center justify-center z-50"
          @click.self="closeDeleteModal"
        >
          <div
            class="bg-white border border-gray-200 rounded-xl shadow-2xl p-8 w-full max-w-md text-center"
          >
            <h2 class="text-2xl font-bold text-red-600 mb-3">
              Delete Organization
            </h2>
            <p class="text-gray-600 mb-6">
              Are you sure you want to delete <strong>{{ selectedOrg.name }}</strong>?
            </p>
            <div class="flex justify-center gap-4">
              <button
                @click="closeDeleteModal"
                class="px-5 py-2 rounded-lg border border-gray-400 hover:bg-gray-100 transition"
              >
                Cancel
              </button>
              <button
                @click="confirmDelete"
                class="px-5 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 transition"
              >
                Delete
              </button>
            </div>
          </div>
        </div>
      </transition>

      <!-- Success Modal -->
      <transition name="fade">
        <div
          v-if="showSuccessModal"
          class="fixed inset-0 flex items-center justify-center z-50"
          @click.self="closeSuccessModal"
        >
          <div
            class="bg-white border border-green-300 rounded-xl shadow-2xl p-8 w-full max-w-md text-center"
          >
            <h2 class="text-2xl font-bold text-green-600 mb-3">
              🎉 Success!
            </h2>
            <p class="text-gray-600 mb-6">
              {{ successMessage }}
            </p>
            <button
              @click="closeSuccessModal"
              class="bg-green-600 text-white px-5 py-2 rounded-lg hover:bg-green-700 transition"
            >
              OK
            </button>
          </div>
        </div>
      </transition>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
  organizations: Array,
});

const form = useForm({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
});

const showConfirmModal = ref(false);
const showPasswordModal = ref(false);
const showDeleteModal = ref(false);
const showSuccessModal = ref(false);
const selectedOrg = ref(null);
const successMessage = ref("");

// --- Registration ---
function confirmRegister() {
  if (!form.name || !form.email || !form.password) {
    alert("Please fill in all fields before confirming.");
    return;
  }
  showConfirmModal.value = true;
}

function cancelRegistration() {
  showConfirmModal.value = false;
}

function registerOrganization() {
  showConfirmModal.value = false;
  form.post("/admin/organizations", {
    onSuccess: (page) => {
      form.reset();
      successMessage.value = page.props.flash?.success || "Organization registered successfully!";
      showSuccessModal.value = true;
    },
  });
}

// --- Password ---
function openPasswordModal(org) {
  selectedOrg.value = org;
  form.password = '';
  form.password_confirmation = '';
  showPasswordModal.value = true;
}

function closePasswordModal() {
  showPasswordModal.value = false;
}

function updatePassword() {
  if (!form.password || !form.password_confirmation) {
    alert("Please fill both password fields.");
    return;
  }

  Inertia.put(`/admin/organizations/${selectedOrg.value.id}/password`, {
    password: form.password,
    password_confirmation: form.password_confirmation,
  }, {
    preserveScroll: true,
    onSuccess: (page) => {
      form.password = '';
      form.password_confirmation = '';
      showPasswordModal.value = false;
      successMessage.value = page.props.flash?.success || "Organization password updated successfully!";
      showSuccessModal.value = true;
    },
  });
}

// --- Delete ---
function openDeleteModal(org) {
  selectedOrg.value = org;
  showDeleteModal.value = true;
}

function closeDeleteModal() {
  showDeleteModal.value = false;
}

function confirmDelete() {
  Inertia.delete(`/admin/organizations/${selectedOrg.value.id}`, {
    preserveScroll: true,
    onSuccess: (page) => {
      showDeleteModal.value = false;
      successMessage.value = page.props.flash?.success || "Organization deleted successfully!";
      showSuccessModal.value = true;
    },
  });
}

// --- Success ---
function closeSuccessModal() {
  showSuccessModal.value = false;
}
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.25s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>

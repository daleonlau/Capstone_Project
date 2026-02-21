<template>
  <OrganizationLayout>
    <div class="p-6 min-h-screen flex items-center justify-center">
      <!-- Profile Card -->
      <div
        class="bg-white/60 backdrop-blur-md shadow-2xl rounded-3xl border border-gray-200 p-10 max-w-3xl w-full hover:shadow-3xl transition-shadow duration-300"
      >
        <!-- Header -->
        <div class="flex flex-col md:flex-row items-center justify-between mb-8">
          <h1 class="text-3xl md:text-4xl font-extrabold text-red-600 tracking-tight drop-shadow-sm">
            My Profile
          </h1>
          <div class="mt-3 md:mt-0 flex items-center gap-4">
            <span class="px-3 py-1 rounded-full bg-red-200 text-red-800 font-semibold text-sm shadow-inner">
              Organization
            </span>
            <span :class="props.organization.email_verified_at ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800'"
              class="px-3 py-1 rounded-full font-semibold text-sm shadow-inner">
              {{ props.organization.email_verified_at ? 'Verified' : 'Unverified' }}
            </span>
          </div>
        </div>

        <!-- User Info -->
        <div class="flex flex-col md:flex-row items-center md:items-start gap-6 mb-6">
          <div class="flex-shrink-0">
            <div
              class="w-28 h-28 rounded-full bg-red-600 text-white flex items-center justify-center text-4xl font-extrabold shadow-lg"
            >
              {{ props.organization.name.charAt(0) }}
            </div>
          </div>
          <div class="flex-1 w-full">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-1">{{ props.organization.name }}</h2>
            <p class="text-gray-500 mb-2">{{ props.organization.email }}</p>
            <p class="text-gray-400 text-sm">
              Last login: {{ props.organization.last_login || 'N/A' }}
            </p>
          </div>
        </div>

        <hr class="my-6 border-gray-300" />

        <!-- Update Form -->
        <form @submit.prevent="updateProfile" class="space-y-6">
          <div>
            <label class="block text-sm font-medium text-gray-600 mb-2">Full Name</label>
            <input
              v-model="form.name"
              type="text"
              class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-red-500 focus:border-red-500 placeholder-gray-300 px-4 py-2 transition duration-200 hover:shadow-md"
              placeholder="Enter full name"
              required
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-600 mb-2">Email Address</label>
            <input
              v-model="form.email"
              type="email"
              class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-red-500 focus:border-red-500 placeholder-gray-300 px-4 py-2 transition duration-200 hover:shadow-md"
              placeholder="Enter email"
              required
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-600 mb-2">New Password</label>
            <input
              v-model="form.password"
              type="password"
              class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-red-500 focus:border-red-500 placeholder-gray-300 px-4 py-2 transition duration-200 hover:shadow-md"
              placeholder="Leave blank to keep current password"
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-600 mb-2">Confirm New Password</label>
            <input
              v-model="form.password_confirmation"
              type="password"
              class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-red-500 focus:border-red-500 placeholder-gray-300 px-4 py-2 transition duration-200 hover:shadow-md"
              placeholder="Confirm new password"
            />
          </div>

          <div class="flex justify-end">
            <button
              type="submit"
              class="bg-red-600 hover:bg-red-700 text-white font-semibold px-8 py-3 rounded-xl shadow-lg transition transform hover:scale-105 hover:shadow-2xl duration-300"
            >
              Update Profile
            </button>
          </div>
        </form>
      </div>

      <!-- Password Confirmation Modal -->
      <transition name="fade">
        <div
          v-if="showPasswordConfirmModal"
          class="fixed inset-0 flex items-center justify-center z-50 bg-black/30"
          @click.self="cancelPasswordUpdate"
        >
          <div class="bg-white border border-gray-200 rounded-2xl shadow-2xl p-8 w-full max-w-md text-center">
            <h2 class="text-2xl font-bold text-blue-600 mb-4 drop-shadow-sm">Confirm Password Update</h2>
            <p class="text-gray-600 mb-6">Are you sure you want to update your password?</p>
            <div class="flex justify-center gap-4">
              <button @click="cancelPasswordUpdate" class="px-5 py-2 rounded-xl border border-gray-400 hover:bg-gray-100 transition">
                Cancel
              </button>
              <button @click="confirmPasswordUpdate" class="px-5 py-2 rounded-xl bg-blue-600 text-white hover:bg-blue-700 transition">
                Yes, Update
              </button>
            </div>
          </div>
        </div>
      </transition>

      <!-- Success Modal -->
      <transition name="fade">
        <div
          v-if="showSuccessModal"
          class="fixed inset-0 flex items-center justify-center z-50 bg-black/20"
          @click.self="closeSuccessModal"
        >
          <div class="bg-white border border-green-300 rounded-2xl shadow-2xl p-8 w-full max-w-md text-center">
            <h2 class="text-2xl font-bold text-green-600 mb-3 drop-shadow-sm">🎉 Success!</h2>
            <p class="text-gray-600 mb-6">{{ successMessage }}</p>
            <button @click="closeSuccessModal" class="bg-green-600 text-white px-5 py-2 rounded-xl hover:bg-green-700 transition">
              OK
            </button>
          </div>
        </div>
      </transition>
    </div>
  </OrganizationLayout>
</template>

<script setup>
import { ref } from "vue";
import OrganizationLayout from "@/Layouts/OrganizationLayout.vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
  organization: Object
});

const form = useForm({
  name: props.organization.name,
  email: props.organization.email,
  password: "",
  password_confirmation: "",
});

const successMessage = ref("");
const showSuccessModal = ref(false);
const showPasswordConfirmModal = ref(false);

function updateProfile() {
  if (form.password || form.password_confirmation) {
    showPasswordConfirmModal.value = true;
  } else {
    submitProfileUpdate();
  }
}

function cancelPasswordUpdate() {
  showPasswordConfirmModal.value = false;
}

function confirmPasswordUpdate() {
  showPasswordConfirmModal.value = false;
  submitProfileUpdate();
}

function submitProfileUpdate() {
  form.put("/organization/profile", {
    onSuccess: () => {
      form.password = "";
      form.password_confirmation = "";
      successMessage.value = "Profile updated successfully!";
      showSuccessModal.value = true;
    },
  });
}

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

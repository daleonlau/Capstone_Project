<template>
  <div
    class="min-h-screen flex items-center justify-center relative"
    :style="{
      backgroundImage: `url(${backgroundUrl})`,
      backgroundSize: 'cover',
      backgroundPosition: 'center'
    }"
  >
    <!-- Overlay -->
    <!-- <div class="absolute inset-0 bg-black bg-opacity-50"></div> -->

    <!-- Login Card -->
    <div class="relative bg-white rounded-lg shadow-lg w-full max-w-md p-8 z-10">
      <!-- University Logos -->
      <div class="flex justify-center mb-6 gap-2">
        <img src="/public/images/csu-logo.png" alt="CSU Logo" class="h-12 w-12" />
        <img src="/public/images/seal.png" alt="College Logo" class="h-12 w-12" />
      </div>

      <h2 class="text-center text-2xl font-bold text-red-600 mb-2">LOGIN</h2>
      <p class="text-center text-gray-600 mb-6 text-sm">
        Please enter your details to login.
      </p>

      <!-- Form -->
      <form @submit.prevent="submit">
        <div class="mb-4">
          <label for="email" class="sr-only">Email</label>
          <input
            id="email"
            type="email"
            v-model="form.email"
            placeholder="Email"
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-red-600"
            autocomplete="email"
            required
          />
        </div>

        <div class="mb-4">
          <label for="password" class="sr-only">Password</label>
          <input
            id="password"
            type="password"
            v-model="form.password"
            placeholder="Password"
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-red-600"
            autocomplete="current-password"
            required
          />
        </div>

        <div class="flex justify-between items-center mb-4 text-sm">
          <label class="flex items-center gap-2">
            <input type="checkbox" class="form-checkbox text-red-600" />
            Remember me
          </label>
          <a href="#" class="text-red-600 hover:underline">Forgot Password?</a>
        </div>

        <button
          type="submit"
          class="w-full bg-red-600 text-white font-semibold py-2 rounded hover:bg-red-700 transition"
          :disabled="form.processing"
        >
          {{ form.processing ? 'Logging in...' : 'Login' }}
        </button>
      </form>

      <p class="mt-6 text-center text-gray-500 text-xs">
        2024 All Rights Reserved - Caraga State University<br />
        Ampayon, Butuan City, Caraga Region, 8600 Philippines
      </p>
    </div>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

// Correctly reference the public image
const backgroundUrl = '/images/bg.png'

const form = useForm({
  email: '',
  password: '',
})

function submit() {
  form.post('/login')
}
</script>

<style scoped>
/* Optional: smooth focus effects */
input:focus {
  outline: none;
}
</style>

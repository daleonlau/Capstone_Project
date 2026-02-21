<template>
  <div class="flex flex-col items-center justify-center h-screen bg-gray-50">
    <div class="bg-white shadow-lg rounded-2xl p-10 text-center">
      <h1 class="text-3xl font-bold text-green-600 mb-4">Thank You!</h1>
      <p class="text-gray-700 text-lg">
        Your evaluation has been successfully submitted.
      </p>
      <button
        @click="goBack"
        class="mt-6 px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg"
      >
        Back to Events
      </button>
    </div>
  </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3';

const goBack = () => {
  router.visit('/evaluations');
};
</script>

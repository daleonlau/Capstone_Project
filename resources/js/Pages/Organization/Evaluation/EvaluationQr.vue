<template>
  <OrganizationLayout>
    <div
      class="flex flex-col items-center justify-center h-[80vh] bg-white p-8 rounded-lg shadow"
    >
      <h1 class="text-2xl font-bold text-red-600 mb-4">Scan to Evaluate</h1>
      <p class="text-gray-600 mb-4">Event: {{ event.event_name }}</p>

      <div class="bg-white p-4 border rounded shadow">
        <qrcode-vue :value="evaluationUrl" :size="250" />
      </div>

      <p class="mt-4 text-gray-500 text-sm">
        Scan this QR code to access the evaluation form.
      </p>
      <p class="text-xs text-gray-400">{{ evaluationUrl }}</p>
    </div>
  </OrganizationLayout>
</template>

<script setup>
import QrcodeVue from 'qrcode.vue';
import OrganizationLayout from '@/Layouts/OrganizationLayout.vue';

const props = defineProps({
  event: Object,
  evaluationUrl: String,
});
</script>

<template>
  <AdminLayout>
    <div class="text-white">
      <h1 class="text-2xl font-bold mb-4">Welcome in, {{ $page.props.auth.user.name }}</h1>
      <p class="mb-6">Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>

      <!-- Cards -->
      <div class="grid grid-cols-4 gap-6">
        <div class="bg-white text-black p-6 rounded shadow">
          <h2 class="font-bold text-red-600">Number of Events</h2>
          <p class="text-3xl font-bold">5</p>
        </div>
        <div class="bg-white text-black p-6 rounded shadow">
          <h2 class="font-bold text-red-600">Number of Students</h2>
          <p class="text-3xl font-bold">689</p>
        </div>
        <div class="bg-white text-black p-6 rounded shadow">
          <h2 class="font-bold text-red-600">Collection of Money</h2>
          <p class="text-xl">80%</p>
        </div>
        <div class="bg-white text-black p-6 rounded shadow">
          <h2 class="font-bold text-red-600">Collection of Evaluation</h2>
          <p class="text-xl">50%</p>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";

</script>

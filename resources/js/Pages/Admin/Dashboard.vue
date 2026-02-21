<template>
  <AdminLayout>
    <div class="p-6">
      <!-- Header -->
      <div class="flex justify-between items-center mb-6">
       
        <p class="text-sm text-gray-500">Welcome back, Admin 👋</p>
      </div>

      <!-- Stat Cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Students -->
        <div
          class="group relative bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl p-6 shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all"
        >
          <div class="flex items-center justify-between">
            <div>
              <h2 class="text-sm uppercase tracking-wide font-semibold opacity-90">
                Total Students
              </h2>
              <p class="text-3xl font-bold mt-2">{{ totalStudents }}</p>
            </div>
            <div
              class="bg-white/20 rounded-full p-3 group-hover:bg-white/30 transition"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M17 20h5V4H2v16h5m10 0v-6H7v6"
                />
              </svg>
            </div>
          </div>
        </div>

        <!-- Total Events -->
        <div
          class="group relative bg-gradient-to-r from-orange-400 to-orange-500 text-white rounded-xl p-6 shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all"
        >
          <div class="flex items-center justify-between">
            <div>
              <h2 class="text-sm uppercase tracking-wide font-semibold opacity-90">
                Total Events
              </h2>
              <p class="text-3xl font-bold mt-2">{{ totalEvents }}</p>
            </div>
            <div
              class="bg-white/20 rounded-full p-3 group-hover:bg-white/30 transition"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M8 7V3m8 4V3M4 11h16M5 19h14a2 2 0 002-2v-6H3v6a2 2 0 002 2z"
                />
              </svg>
            </div>
          </div>
        </div>

        <!-- Pending Approvals -->
        <div
          class="group relative bg-gradient-to-r from-yellow-400 to-yellow-500 text-white rounded-xl p-6 shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all"
        >
          <div class="flex items-center justify-between">
            <div>
              <h2 class="text-sm uppercase tracking-wide font-semibold opacity-90">
                Pending Approvals
              </h2>
              <p class="text-3xl font-bold mt-2">{{ pendingEvents }}</p>
            </div>
            <div
              class="bg-white/20 rounded-full p-3 group-hover:bg-white/30 transition"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                />
              </svg>
            </div>
          </div>
        </div>

        <!-- Total Organizations -->
        <div
          class="group relative bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl p-6 shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all"
        >
          <div class="flex items-center justify-between">
            <div>
              <h2 class="text-sm uppercase tracking-wide font-semibold opacity-90">
                Total Organizations
              </h2>
              <p class="text-3xl font-bold mt-2">{{ totalOrganizations }}</p>
            </div>
            <div
              class="bg-white/20 rounded-full p-3 group-hover:bg-white/30 transition"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M3 7l9 6 9-6M21 7v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"
                />
              </svg>
            </div>
          </div>
        </div>
      </div>

      <!-- Optional: small recent activity / chart placeholder -->
      <div class="mt-10">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">
          Overview (Coming Soon)
        </h2>
        <div
          class="h-48 flex items-center justify-center bg-gray-50 border border-dashed border-gray-300 rounded-lg text-gray-400"
        >
          Charts or recent activity can go here
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";

const props = defineProps({
  totalStudents: Number,
  totalEvents: Number,
  pendingEvents: Number,
  totalOrganizations: Number, // 👈 added
});
</script>

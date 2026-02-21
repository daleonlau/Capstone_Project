<template>
  <OrganizationLayout>
    <div class="p-6">
      <!-- Header -->
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Organization Dashboard</h1>
        <p class="text-sm text-gray-500">Welcome back, Organization 👋</p>
      </div>

      <!-- Stat Cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
        <!-- My Events -->
        <div
          class="group relative bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl p-6 shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all"
        >
          <div class="flex items-center justify-between">
            <div>
              <h2 class="text-sm uppercase tracking-wide font-semibold opacity-90">
                My Events
              </h2>
              <p class="text-3xl font-bold mt-2">{{ myEvents }}</p>
            </div>
            <div class="bg-white/20 rounded-full p-3 group-hover:bg-white/30 transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                   viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 17v-6h13V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h7z" />
              </svg>
            </div>
          </div>
        </div>

        <!-- Approved Events -->
        <div
          class="group relative bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl p-6 shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all"
        >
          <div class="flex items-center justify-between">
            <div>
              <h2 class="text-sm uppercase tracking-wide font-semibold opacity-90">
                Approved Events
              </h2>
              <p class="text-3xl font-bold mt-2">{{ approvedEvents }}</p>
            </div>
            <div class="bg-white/20 rounded-full p-3 group-hover:bg-white/30 transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                   viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M5 13l4 4L19 7" />
              </svg>
            </div>
          </div>
        </div>

        <!-- Pending Events -->
        <div
          class="group relative bg-gradient-to-r from-yellow-400 to-yellow-500 text-white rounded-xl p-6 shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all"
        >
          <div class="flex items-center justify-between">
            <div>
              <h2 class="text-sm uppercase tracking-wide font-semibold opacity-90">
                Pending Events
              </h2>
              <p class="text-3xl font-bold mt-2">{{ pendingEvents }}</p>
            </div>
            <div class="bg-white/20 rounded-full p-3 group-hover:bg-white/30 transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                   viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
          </div>
        </div>

        <!-- Total Collected -->
        <div
          class="group relative bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl p-6 shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all"
        >
          <div class="flex items-center justify-between">
            <div>
              <h2 class="text-sm uppercase tracking-wide font-semibold opacity-90">
                Total Collected
              </h2>
              <p class="text-3xl font-bold mt-2">₱{{ totalCollected }}</p>
            </div>
            <div class="bg-white/20 rounded-full p-3 group-hover:bg-white/30 transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                   viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8c-3.866 0-7 1.79-7 4s3.134 4 7 4 7-1.79 7-4-3.134-4-7-4z" />
              </svg>
            </div>
          </div>
        </div>

        <!-- Number of Students -->
        <div
          class="group relative bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-xl p-6 shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all"
        >
          <div class="flex items-center justify-between">
            <div>
              <h2 class="text-sm uppercase tracking-wide font-semibold opacity-90">
                Number of Students
              </h2>
              <p class="text-3xl font-bold mt-2">{{ numberOfStudents }}</p>
            </div>
            <div class="bg-white/20 rounded-full p-3 group-hover:bg-white/30 transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                   viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 20h5V4H2v16h5m10 0v-6H7v6" />
              </svg>
            </div>
          </div>
        </div>
      </div>

      <!-- Overview Placeholder -->
      <div class="mt-10">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Overview (Coming Soon)</h2>
        <div
          class="h-48 flex items-center justify-center bg-gray-50 border border-dashed border-gray-300 rounded-lg text-gray-400"
        >
          Charts or reports can go here
        </div>
      </div>
    </div>
  </OrganizationLayout>
</template>

<script setup>
import OrganizationLayout from "@/Layouts/OrganizationLayout.vue";

const props = defineProps({
  myEvents: Number,
  approvedEvents: Number,
  pendingEvents: Number,
  totalCollected: Number,
  numberOfStudents: Number,
});
</script>

<template>
  <OrganizationLayout>
    <div class="p-8 min-h-screen bg-gray-50">
      <h1 class="text-3xl font-bold text-gray-800 mb-6">
        Evaluation Results for {{ event.title }}
      </h1>

      <!-- No data -->
      <div
        v-if="evaluationData.length === 0"
        class="text-center py-20 text-gray-500 text-lg"
      >
        No evaluations have been submitted yet.
      </div>

      <!-- Results -->
      <div v-else>
        <!-- Averages Table -->
        <div class="bg-white shadow-md rounded-2xl p-6 mb-10">
          <h2 class="text-2xl font-semibold text-gray-700 mb-4">📊 Average Ratings per Question</h2>
          <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left border border-gray-200">
              <thead class="bg-gray-100 text-gray-700">
                <tr>
                  <th class="px-6 py-3">Question</th>
                  <th class="px-6 py-3 text-center">Average Score</th>
                  <th class="px-6 py-3 text-center">Responses</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="(data, index) in evaluationData"
                  :key="index"
                  class="border-t hover:bg-gray-50"
                >
                  <td class="px-6 py-3 font-medium text-gray-800">{{ data.question }}</td>
                  <td class="px-6 py-3 text-center text-blue-600 font-semibold">{{ data.average }}</td>
                  <td class="px-6 py-3 text-center">{{ data.responses }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Bar Chart -->
        <div class="bg-white shadow-md rounded-2xl p-6 mb-10">
          <h2 class="text-2xl font-semibold text-gray-700 mb-4">📈 Visual Representation</h2>
          <Bar :data="chartData" :options="chartOptions" />
        </div>

        <!-- Raw Data -->
        <div class="bg-white shadow-md rounded-2xl p-6">
          <h2 class="text-2xl font-semibold text-gray-700 mb-4">🧾 Raw Evaluation Data</h2>
          <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left border border-gray-200">
              <thead class="bg-gray-100 text-gray-700">
                <tr>
                  <th class="px-6 py-3">Question</th>
                  <th class="px-6 py-3">All Responses</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="(data, index) in rawData"
                  :key="index"
                  class="border-t hover:bg-gray-50"
                >
                  <td class="px-6 py-3 font-medium text-gray-800">{{ data.question }}</td>
                  <td class="px-6 py-3 text-gray-700">
                    <span
                      v-for="(val, i) in data.answers"
                      :key="i"
                      class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded-lg mr-1 mb-1"
                    >
                      {{ val }}
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </OrganizationLayout>
</template>

<script setup>
import OrganizationLayout from '@/Layouts/OrganizationLayout.vue';
import { Bar } from 'vue-chartjs';
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
} from 'chart.js';

// Register Chart.js components
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

const props = defineProps({
  event: Object,
  evaluationData: Array,
  rawData: Array,
});

// Prepare data for the bar chart
const chartData = {
  labels: props.evaluationData.map((d) => d.question),
  datasets: [
    {
      label: 'Average Rating',
      backgroundColor: '#3b82f6',
      data: props.evaluationData.map((d) => d.average),
      borderRadius: 8,
    },
  ],
};

// Chart options
const chartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  scales: {
    y: {
      beginAtZero: true,
      max: 5,
      title: { display: true, text: 'Average Rating' },
    },
    x: {
      title: { display: true, text: 'Questions' },
    },
  },
  plugins: {
    legend: { display: true, position: 'top' },
    title: { display: false },
  },
};
</script>

<style scoped>
canvas {
  width: 100% !important;
  height: 400px !important;
}
</style>

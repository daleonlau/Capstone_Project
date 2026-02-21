<template>
  <div class="min-h-screen bg-gray-50 flex items-center justify-center p-6">
    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-2xl">
      <h1 class="text-2xl font-bold text-red-600 mb-6 text-center">
        Event Evaluation: {{ event.event_name }}
      </h1>

      <form @submit.prevent="submitForm" class="space-y-6">
        <!-- Student ID Input -->
        <div>
          <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">
            Student ID
          </label>
          <input
            v-model="student_id"
            id="student_id"
            type="text"
            placeholder="Enter your Student ID"
            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500"
            required
          />
        </div>

        <!-- Questions -->
        <div
          v-for="(question, index) in questions"
          :key="index"
          class="border-b pb-4"
        >
          <p class="text-lg font-medium mb-3">
            {{ index + 1 }}. {{ question }}
          </p>
          <div class="flex justify-between">
            <label
              v-for="(label, value) in scaleLabels"
              :key="value"
              class="flex flex-col items-center text-sm"
            >
              <input
                type="radio"
                :name="'question-' + index"
                :value="value"
                v-model="answers[index]"
                class="text-red-600 focus:ring-red-500"
                required
              />
              <span class="mt-1">{{ label }}</span>
            </label>
          </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-center">
          <button
            type="submit"
            class="mt-6 px-6 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition"
          >
            Submit Evaluation
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
  event: Object,
  questions: Array,
  scaleLabels: Object,
});

const student_id = ref('');
const answers = ref(Array(props.questions.length).fill(null));

const submitForm = () => {
  if (!student_id.value.trim()) {
    alert('Please enter your Student ID.');
    return;
  }

  if (answers.value.includes(null)) {
    alert('Please answer all questions before submitting.');
    return;
  }

  router.post(
    `/evaluations/${props.event.id}`,
    {
      student_id: student_id.value,
      answers: answers.value,
    },
    {
      onSuccess: () => router.visit('/evaluations/thankyou'),
      onError: () =>
        alert(
          'Failed to submit evaluation. You may have already evaluated this event.'
        ),
    }
  );
};
</script>

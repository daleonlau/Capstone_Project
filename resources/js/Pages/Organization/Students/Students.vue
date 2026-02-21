<template>
  <OrganizationLayout>
    <div class="bg-white rounded-lg shadow-md p-6 text-black">

      <!-- Header & Buttons -->
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-red-600">Students</h1>
        <div class="flex gap-2">
          <button @click="showAddModal = true" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
            + Add Student
          </button>
          <button @click="showBulkModal = true" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
            + Bulk Upload
          </button>
        </div>
      </div>

      <!-- Filters -->
      <div class="mb-4 flex gap-4">
        <div>
          <label class="font-semibold mr-2">Filter by Course:</label>
          <select v-model="filterCourse" class="border rounded px-3 py-2">
            <option value="">All</option>
            <option v-for="course in uniqueCourses" :key="course" :value="course">
              {{ course }}
            </option>
          </select>
        </div>
        <div>
          <label class="font-semibold mr-2">Filter by Year Level:</label>
          <select v-model="filterYear" class="border rounded px-3 py-2">
            <option value="">All</option>
            <option v-for="year in uniqueYears" :key="year" :value="year">
              {{ year }}
            </option>
          </select>
        </div>
      </div>

      <!-- Students Table -->
      <table class="w-full border rounded-lg overflow-hidden">
        <thead class="bg-gray-200">
          <tr>
            <th class="p-2 border">Student ID</th>
            <th class="p-2 border">First Name</th>
            <th class="p-2 border">Last Name</th>
            <th class="p-2 border">Course</th>
            <th class="p-2 border">Year Level</th>
            <th class="p-2 border">Department</th>
            <th class="p-2 border">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="student in filteredStudents" :key="student.student_id" class="hover:bg-gray-100">
            <td class="p-2 border">{{ student.student_id }}</td>
            <td class="p-2 border">{{ student.firstname }}</td>
            <td class="p-2 border">{{ student.lastname }}</td>
            <td class="p-2 border">{{ student.course }}</td>
            <td class="p-2 border">{{ student.yearlevel }}</td>
            <td class="p-2 border">{{ student.department }}</td>
            <td class="p-2 border flex gap-2">
              <button @click="editStudentModal(student)" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-sm">Edit</button>
              <button @click="confirmDelete(student.student_id)" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm">Delete</button>
            </td>
          </tr>
          <tr v-if="filteredStudents.length === 0">
            <td colspan="7" class="text-center p-4 text-gray-500">No students found</td>
          </tr>
        </tbody>
      </table>

      <!-- Add/Edit Student Modal -->
      <transition name="fade">
        <div v-if="showAddModal" class="fixed inset-0 flex items-center justify-center z-50 bg-black/30" @click.self="closeAddModal">
          <div class="bg-white rounded-lg shadow-2xl p-6 w-full max-w-md">
            <h2 class="text-xl font-bold text-red-600 mb-4">{{ editStudent ? 'Edit Student' : 'Add Student' }}</h2>
            <form @submit.prevent="submitStudent">
              <div class="mb-3">
                <label class="block font-semibold mb-1">Student ID</label>
                <input v-model="form.student_id" type="text" class="w-full border rounded px-3 py-2" required />
                <span v-if="form.errors.student_id" class="text-red-600 text-sm">{{ form.errors.student_id }}</span>
              </div>
              <div class="mb-3">
                <label class="block font-semibold mb-1">First Name</label>
                <input v-model="form.firstname" type="text" class="w-full border rounded px-3 py-2" required />
                <span v-if="form.errors.firstname" class="text-red-600 text-sm">{{ form.errors.firstname }}</span>
              </div>
              <div class="mb-3">
                <label class="block font-semibold mb-1">Last Name</label>
                <input v-model="form.lastname" type="text" class="w-full border rounded px-3 py-2" required />
                <span v-if="form.errors.lastname" class="text-red-600 text-sm">{{ form.errors.lastname }}</span>
              </div>
              <div class="mb-3">
                <label class="block font-semibold mb-1">Course</label>
                <input v-model="form.course" type="text" class="w-full border rounded px-3 py-2" />
                <span v-if="form.errors.course" class="text-red-600 text-sm">{{ form.errors.course }}</span>
              </div>
              <div class="mb-3">
                <label class="block font-semibold mb-1">Department</label>
                <input v-model="form.department" type="text" class="w-full border rounded px-3 py-2" />
              </div>
              <div class="mb-3">
                <label class="block font-semibold mb-1">Year Level</label>
                <select v-model="form.yearlevel" class="w-full border rounded px-3 py-2" required>
                  <option value="">Select Year Level</option>
                  <option value="firstyear">First Year</option>
                  <option value="secondyear">Second Year</option>
                  <option value="thirdyear">Third Year</option>
                  <option value="fourthyear">Fourth Year</option>
                </select>
              </div>
              <div class="flex justify-end gap-2 mt-4">
                <button type="button" @click="closeAddModal" class="px-4 py-2 rounded border hover:bg-gray-100">Cancel</button>
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                  {{ editStudent ? 'Update' : 'Add' }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </transition>

      <!-- Bulk Upload Modal -->
      <transition name="fade">
        <div v-if="showBulkModal" class="fixed inset-0 flex items-center justify-center z-50 bg-black/30" @click.self="closeBulkModal">
          <div class="bg-white rounded-lg shadow-2xl p-6 w-full max-w-md">
            <h2 class="text-xl font-bold text-red-600 mb-4">Bulk Upload Students</h2>
            <form @submit.prevent="submitBulkUpload" enctype="multipart/form-data">
              <div class="mb-4">
                <input type="file" @change="handleFile" class="w-full border rounded px-3 py-2" accept=".csv,.xlsx" />
                <span v-if="form.errors.file" class="text-red-600 text-sm">{{ form.errors.file }}</span>
              </div>
              <div class="flex justify-end gap-2 mt-4">
                <button type="button" @click="closeBulkModal" class="px-4 py-2 rounded border hover:bg-gray-100">Cancel</button>
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Upload</button>
              </div>
            </form>
          </div>
        </div>
      </transition>

      <!-- Delete Confirmation Modal -->
      <transition name="fade">
        <div v-if="showDeleteConfirm" class="fixed inset-0 flex items-center justify-center z-50 bg-black/30" @click.self="showDeleteConfirm=false">
          <div class="bg-white rounded-lg shadow-2xl p-6 w-full max-w-sm text-center">
            <h2 class="text-lg font-bold text-red-600 mb-4">Confirm Delete</h2>
            <p class="mb-4">Are you sure you want to delete this student?</p>
            <div class="flex justify-center gap-2">
              <button @click="showDeleteConfirm=false" class="px-4 py-2 rounded border hover:bg-gray-100">Cancel</button>
              <button @click="deleteStudent" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Delete</button>
            </div>
          </div>
        </div>
      </transition>

      <!-- Success Modal -->
      <transition name="fade">
        <div v-if="showSuccessModal" class="fixed top-5 right-5 z-50">
          <div class="bg-green-600 text-white p-3 rounded shadow-lg">
            {{ successMessage }}
          </div>
        </div>
      </transition>

    </div>
  </OrganizationLayout>
</template>

<script setup>
import { ref, computed } from "vue";
import { useForm, router } from "@inertiajs/vue3";
import OrganizationLayout from "@/Layouts/OrganizationLayout.vue";

const props = defineProps({ students: Array });

// Filters
const filterCourse = ref("");
const filterYear = ref("");

// Unique options
const uniqueCourses = computed(() => [...new Set(props.students.map(s => s.course))]);
const uniqueYears = computed(() => [...new Set(props.students.map(s => s.yearlevel))]);

const filteredStudents = computed(() =>
  props.students.filter(s => (filterCourse.value ? s.course === filterCourse.value : true)
                         && (filterYear.value ? s.yearlevel === filterYear.value : true))
);

// Modals
const showAddModal = ref(false);
const showBulkModal = ref(false);
const showDeleteConfirm = ref(false);
const showSuccessModal = ref(false);

// Student form
const form = useForm({
  student_id: "",
  firstname: "",
  lastname: "",
  course: "",
  department: "",
  yearlevel: "",
  file: null
});

const editStudent = ref(null);
const deleteId = ref(null);

// Add/Edit Modal Functions
const closeAddModal = () => { showAddModal.value = false; form.reset(); editStudent.value = null; };
const editStudentModal = (student) => {
  editStudent.value = student;
  Object.assign(form, student);
  showAddModal.value = true;
};

// Bulk Modal Functions
const closeBulkModal = () => { showBulkModal.value = false; form.reset(); };
const handleFile = (e) => { form.file = e.target.files[0]; };

// Delete Modal
const confirmDelete = (id) => { deleteId.value = id; showDeleteConfirm.value = true; };

// Actions
const submitStudent = () => {
  if (editStudent.value) {
    form.put(`/organization/students/${editStudent.value.student_id}`, {
      onSuccess: () => {
        showSuccessModal.value = true;
        editStudent.value = null;
        form.reset();
        showAddModal.value = false;
        successMessage.value = "Student updated successfully.";
        setTimeout(() => showSuccessModal.value=false, 3000);
      }
    });
  } else {
    form.post("/organization/students", {
      onSuccess: () => {
        showSuccessModal.value = true;
        form.reset();
        showAddModal.value = false;
        successMessage.value = "Student added successfully.";
        setTimeout(() => showSuccessModal.value=false, 3000);
      }
    });
  }
};

const submitBulkUpload = () => {
  form.post("/organization/students/bulk-upload", {
    forceFormData: true,
    onSuccess: () => {
      showSuccessModal.value = true;
      form.reset();
      showBulkModal.value = false;
      successMessage.value = "Students uploaded successfully.";
      setTimeout(() => showSuccessModal.value=false, 3000);
    }
  });
};

const deleteStudent = () => {
  router.delete(`/organization/students/${deleteId.value}`, {
    onSuccess: () => {
      showDeleteConfirm.value = false;
      showSuccessModal.value = true;
      successMessage.value = "Student deleted successfully.";
      setTimeout(() => showSuccessModal.value=false, 3000);
    }
  });
};
</script>

<style scoped>
.fade-enter-active, .fade-leave-active { transition: opacity 0.25s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
</style>

<template>
  <div
    class="min-h-screen flex"
    :style="{
      backgroundImage: 'url(/images/campus-bg.png)',
      backgroundSize: 'cover',
      backgroundPosition: 'center',
      backgroundRepeat: 'no-repeat',
      backgroundAttachment: 'scroll'
    }"
  >
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md flex flex-col">
      <!-- Header with logo -->
      <div class="p-6 border-b flex items-center gap-3">
        <img src="/public/images/csu-logo.png" alt="CSU Logo" class="w-10 h-10 object-contain rounded-full shadow-sm" />
        <h1 class="text-2xl font-bold text-red-600">CSUCC EMS - Organization</h1>
      </div>

      <!-- Navigation -->
      <nav class="flex-1 p-4 space-y-2">
        <Link
          href="/organization/dashboard"
          class="flex items-center gap-3 px-3 py-2 rounded hover:bg-red-100 transition"
          :class="{'bg-red-50 font-semibold': activeLink === 'dashboard'}"
          @click="setActive('dashboard')"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6" />
          </svg>
          Dashboard
        </Link>

        <Link
          href="/organization/events"
          class="flex items-center gap-3 px-3 py-2 rounded hover:bg-red-100 transition"
          :class="{'bg-red-50 font-semibold': activeLink === 'events'}"
          @click="setActive('events')"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7H3v12a2 2 0 002 2z" />
          </svg>
          Events
        </Link>

        <Link
          href="/organization/students"
          class="flex items-center gap-3 px-3 py-2 rounded hover:bg-red-100 transition"
          :class="{'bg-red-50 font-semibold': activeLink === 'students'}"
          @click="setActive('students')"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1112 21a9 9 0 01-6.879-3.196zM12 12a3 3 0 100-6 3 3 0 000 6z" />
          </svg>
          Students
        </Link>

        <Link
          href="/organization/collections"
          class="flex items-center gap-3 px-3 py-2 rounded hover:bg-red-100 transition"
          :class="{'bg-red-50 font-semibold': activeLink === 'collections'}"
          @click="setActive('collections')"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zM12 2v2m0 16v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2m16 0h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41" />
          </svg>
          Collections
        </Link>

        <Link
          href="/organization/evaluations"
          class="flex items-center gap-3 px-3 py-2 rounded hover:bg-red-100 transition"
          :class="{'bg-red-50 font-semibold': activeLink === 'evaluations'}"
          @click="setActive('evaluations')"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m2 0a2 2 0 01-2 2H9a2 2 0 01-2-2m0 0a2 2 0 012-2h6a2 2 0 012 2z" />
          </svg>
          Evaluations
        </Link>

        <Link
          href="/organization/profile"
          class="flex items-center gap-3 px-3 py-2 rounded hover:bg-red-100 transition"
          :class="{'bg-red-50 font-semibold': activeLink === 'profile'}"
          @click="setActive('profile')"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1112 21a9 9 0 01-6.879-3.196zM12 12a3 3 0 100-6 3 3 0 000 6z" />
          </svg>
          Profile
        </Link>
      </nav>

      <!-- Logout Button -->
      <div class="p-4 border-t">
        <button
          @click="showLogoutModal = true"
          class="w-full bg-red-600 text-white px-3 py-2 rounded hover:bg-red-700 flex items-center justify-center gap-2 transition"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 11-6 0v-1m6-10V5a3 3 0 00-6 0v1" />
          </svg>
          Logout
        </button>
      </div>

      <!-- Logout Confirmation Modal -->
      <transition name="fade">
        <div v-if="showLogoutModal" class="fixed inset-0 flex items-center justify-center z-50" @click.self="showLogoutModal = false">
          <div class="bg-white border border-gray-200 rounded-lg shadow-xl p-6 w-full max-w-sm text-center">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Confirm Logout</h2>
            <p class="text-gray-600 mb-6">Are you sure you want to log out?</p>
            <div class="flex justify-center gap-4">
              <button @click="showLogoutModal = false" class="px-4 py-2 rounded border border-gray-400 hover:bg-gray-100 transition">
                No
              </button>
              <button @click="logout" class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700 transition">
                Yes, Logout
              </button>
            </div>
          </div>
        </div>
      </transition>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6">
      <slot />
    </main>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const showLogoutModal = ref(false);

const activeLink = ref(
  window.location.pathname.includes('events') ? 'events' :
  window.location.pathname.includes('students') ? 'students' :
  window.location.pathname.includes('collections') ? 'collections' :
  window.location.pathname.includes('evaluations') ? 'evaluations' :
  window.location.pathname.includes('profile') ? 'profile' :
  'dashboard'
);

function setActive(link) {
  activeLink.value = link;
}

function logout() {
  Inertia.post('/logout');
}
</script>

<style scoped>
/* Fade animation */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.25s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>

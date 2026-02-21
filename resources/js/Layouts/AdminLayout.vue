<template>
  <div class="min-h-screen flex bg-gray-100">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md flex flex-col">
      <div class="p-6 border-b">
        <h1 class="text-2xl font-bold text-red-600">CSUCC EMS - Admin</h1>
      </div>

      <nav class="flex-1 p-4 space-y-2">
        <Link
          href="/admin/dashboard"
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
          href="/admin/organizations"
          class="flex items-center gap-3 px-3 py-2 rounded hover:bg-red-100 transition"
          :class="{'bg-red-50 font-semibold': activeLink === 'organizations'}"
          @click="setActive('organizations')"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M19 3v4M4 7h16v14H4V7z" />
          </svg>
          Manage Organizations
        </Link>

        <Link
          href="/admin/profile"
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
        <div
          v-if="showLogoutModal"
          class="fixed inset-0 flex items-center justify-center z-50"
          @click.self="showLogoutModal = false"
        >
          <div class="bg-white border border-gray-200 rounded-lg shadow-xl p-6 w-full max-w-sm text-center">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Confirm Logout</h2>
            <p class="text-gray-600 mb-6">
              Are you sure you want to log out?
            </p>
            <div class="flex justify-center gap-4">
              <button
                @click="showLogoutModal = false"
                class="px-4 py-2 rounded border border-gray-400 hover:bg-gray-100 transition"
              >
                No
              </button>
              <button
                @click="logout"
                class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700 transition"
              >
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
import { Inertia } from '@inertiajs/inertia';
import { ref } from 'vue';

const showLogoutModal = ref(false);
const activeLink = ref(window.location.pathname.includes('organizations') ? 'organizations' :
                       window.location.pathname.includes('profile') ? 'profile' : 'dashboard');

function logout() {
  Inertia.post('/logout');
}

function setActive(link) {
  activeLink.value = link;
}
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.25s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}


</style>

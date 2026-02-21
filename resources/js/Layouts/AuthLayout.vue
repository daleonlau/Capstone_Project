<template>
    <div class="flex h-screen bg-gray-100">
      <!-- Sidebar -->
      <aside class="w-64 bg-white shadow flex flex-col">
        <!-- Logo -->
        <div class="p-4 flex items-center space-x-2 border-b">
          <img src="/public/images/csu-logo.png" alt="Logo" class="h-10 w-10" />
          <h1 class="font-bold text-sm leading-tight">
            Caraga State University<br />
            <span class="text-xs">Cabadbaran City</span>
          </h1>
        </div>
  
        <!-- Menu -->
        <nav class="flex-1 p-2">
          <ul class="space-y-1">
            <li>
              <Link
                href="/dashboard"
                class="block px-4 py-2 rounded hover:bg-red-600 hover:text-white"
                :class="{ 'bg-red-600 text-white': $page.url.startsWith('/dashboard') }"
              >
                Dashboard
              </Link>
            </li>
            <li>
              <Link
                href="/activity-design"
                class="block px-4 py-2 rounded hover:bg-red-600 hover:text-white"
                :class="{ 'bg-red-600 text-white': $page.url.startsWith('/activity-design') }"
              >
                Activity Design
              </Link>
            </li>
            <li>
              <Link
                href="/collection"
                class="block px-4 py-2 rounded hover:bg-red-600 hover:text-white"
                :class="{ 'bg-red-600 text-white': $page.url.startsWith('/collection') }"
              >
                Collection
              </Link>
            </li>
            <li>
              <Link
                href="/evaluation"
                class="block px-4 py-2 rounded hover:bg-red-600 hover:text-white"
                :class="{ 'bg-red-600 text-white': $page.url.startsWith('/evaluation') }"
              >
                Evaluation
              </Link>
            </li>
            <li>
              <Link
                href="/students"
                class="block px-4 py-2 rounded hover:bg-red-600 hover:text-white"
                :class="{ 'bg-red-600 text-white': $page.url.startsWith('/students') }"
              >
                Students
              </Link>
            </li>
            <li>
              <Link
                href="/users"
                class="block px-4 py-2 rounded hover:bg-red-600 hover:text-white"
                :class="{ 'bg-red-600 text-white': $page.url.startsWith('/users') }"
              >
                Users
              </Link>
            </li>
            <li>
              <Link
                href="/dss"
                class="block px-4 py-2 rounded hover:bg-red-600 hover:text-white"
                :class="{ 'bg-red-600 text-white': $page.url.startsWith('/dss') }"
              >
                DSS
              </Link>
            </li>
          </ul>
        </nav>
  
        <!-- Footer -->
        <footer class="p-2 text-xs text-center text-gray-600 border-t">
          <p>2024 All Rights Reserved - Caraga State University</p>
          <p>Ampayon, Butuan City, Caraga Region, 8600 Philippines</p>
          <p>Powered by: CSU - ICT Center, CSU - Main Campus</p>
        </footer>
      </aside>
  
      <!-- Main Content -->
      <div class="flex-1 flex flex-col bg-cover bg-center" style="background-image: url('/images/bg.jpg')">
        <!-- Header -->
        <header class="p-4 bg-gray-900 bg-opacity-70 text-white flex justify-between items-center">
          <h2 class="text-lg font-semibold">Welcome, {{ $page.props.auth.user.name }}</h2>
          <div class="space-x-4">
            <button class="hover:text-red-400"><i class="fas fa-cog"></i></button>
            <button class="hover:text-red-400"><i class="fas fa-user"></i></button>
            <Link href="/logout" method="post" as="button" class="hover:text-red-400">
              Logout
            </Link>
          </div>
        </header>
  
        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto p-6 bg-black bg-opacity-50 text-white">
          <slot />
        </main>
      </div>
    </div>
  </template>
  
  <script setup>
  import { Link } from "@inertiajs/vue3";
  </script>
  
  <style>
  @import url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css");
  </style>
  
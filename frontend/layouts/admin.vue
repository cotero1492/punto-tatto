<template>
  <div class="min-h-screen bg-gray-50">
    <AdminNavbar />
    <div class="flex">
      <AdminSidebar />
      <main class="flex-1 p-6">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import AdminNavbar from '~/components/layouts/AdminNavbar.vue'
import AdminSidebar from '~/components/layouts/AdminSidebar.vue'
</script>


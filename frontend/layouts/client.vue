<template>
  <div class="min-h-screen bg-gray-50">
    <ClientNavbar />
    <div class="flex">
      <ClientSidebar />
      <main class="flex-1 p-6">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import ClientNavbar from '~/components/layouts/ClientNavbar.vue'
import ClientSidebar from '~/components/layouts/ClientSidebar.vue'
</script>


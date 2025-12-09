<template>
  <div class="min-h-screen bg-gray-50">
    <ArtistNavbar />
    <div class="flex">
      <ArtistSidebar />
      <main class="flex-1 p-6">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import ArtistNavbar from '~/components/layouts/ArtistNavbar.vue'
import ArtistSidebar from '~/components/layouts/ArtistSidebar.vue'
</script>


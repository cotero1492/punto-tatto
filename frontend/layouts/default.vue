<template>
  <div class="min-h-screen bg-gray-50">
    <Navbar />
    <main>
      <slot />
    </main>
    <Footer />
  </div>
</template>

<script setup>
import Navbar from '~/components/layouts/Navbar.vue'
import Footer from '~/components/layouts/Footer.vue'
</script>


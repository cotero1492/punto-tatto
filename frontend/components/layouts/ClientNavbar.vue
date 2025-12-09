<template>
  <nav class="bg-white shadow-lg">
    <div class="container mx-auto px-4">
      <div class="flex justify-between items-center py-4">
        <NuxtLink to="/cliente/dashboard" class="text-2xl font-bold text-primary-600">
          PUNTO TATTO - Cliente
        </NuxtLink>
        <div class="flex items-center gap-4">
          <NuxtLink to="/" class="text-gray-700 hover:text-primary-600">Ver sitio público</NuxtLink>
          <button @click="handleLogout" class="btn btn-outline">
            Cerrar sesión
          </button>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
const authStore = useAuthStore()
const router = useRouter()

const handleLogout = async () => {
  await authStore.logout()
  router.push('/')
}
</script>


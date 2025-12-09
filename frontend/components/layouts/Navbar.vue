<template>
  <nav class="bg-white shadow-lg">
    <div class="container mx-auto px-4">
      <div class="flex justify-between items-center py-4">
        <NuxtLink to="/" class="text-2xl font-bold text-primary-600">
          PUNTO TATTO
        </NuxtLink>
        <div class="flex items-center gap-4">
          <NuxtLink to="/artists" class="text-gray-700 hover:text-primary-600">
            Artistas
          </NuxtLink>
          <template v-if="authStore.isAuthenticated">
            <NuxtLink 
              v-if="authStore.isArtist"
              to="/artista/dashboard"
              class="text-gray-700 hover:text-primary-600"
            >
              Mi Panel
            </NuxtLink>
            <NuxtLink 
              v-else-if="authStore.isClient"
              to="/cliente/dashboard"
              class="text-gray-700 hover:text-primary-600"
            >
              Mi Panel
            </NuxtLink>
            <button @click="handleLogout" class="btn btn-outline">
              Cerrar sesión
            </button>
          </template>
          <template v-else>
            <NuxtLink to="/login" class="text-gray-700 hover:text-primary-600">
              Iniciar sesión
            </NuxtLink>
            <NuxtLink to="/register" class="btn btn-primary">
              Registrarse
            </NuxtLink>
          </template>
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


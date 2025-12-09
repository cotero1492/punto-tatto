<template>
  <div>
    <h1 class="text-3xl font-bold mb-6">Dashboard</h1>

    <div v-if="stats" class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
      <div class="card">
        <h3 class="text-lg font-semibold text-gray-600">Favoritos</h3>
        <p class="text-3xl font-bold text-primary-600">{{ stats.favorites_count }}</p>
        <NuxtLink to="/cliente/favoritos" class="text-primary-600 hover:underline mt-2 inline-block">
          Ver favoritos →
        </NuxtLink>
      </div>
      <div class="card">
        <h3 class="text-lg font-semibold text-gray-600">Reseñas</h3>
        <p class="text-3xl font-bold text-primary-600">{{ stats.reviews_count }}</p>
      </div>
      <div class="card">
        <h3 class="text-lg font-semibold text-gray-600">Mensajes sin leer</h3>
        <p class="text-3xl font-bold text-primary-600">{{ stats.messages_unread }}</p>
        <NuxtLink to="/cliente/mensajes" class="text-primary-600 hover:underline mt-2 inline-block">
          Ver mensajes →
        </NuxtLink>
      </div>
    </div>

    <div class="card">
      <h2 class="text-2xl font-bold mb-4">Buscar Artistas</h2>
      <NuxtLink to="/artists" class="btn btn-primary">
        Explorar Artistas
      </NuxtLink>
    </div>
  </div>
</template>

<script setup>
const api = useApi()

const stats = ref(null)

const loadDashboard = async () => {
  try {
    const { data } = await api.get('/client/dashboard')
    stats.value = data.stats
  } catch (error) {
    console.error('Error al cargar dashboard:', error)
  }
}

onMounted(() => {
  loadDashboard()
})

definePageMeta({
  layout: 'client',
  middleware: ['auth', 'role'],
  role: 'client'
})
</script>


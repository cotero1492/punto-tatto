<template>
  <div>
    <h1 class="text-3xl font-bold mb-6">Dashboard</h1>

    <div v-if="stats" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      <div class="card">
        <h3 class="text-lg font-semibold text-gray-600">Vistas totales</h3>
        <p class="text-3xl font-bold text-primary-600">{{ stats.total_views }}</p>
      </div>
      <div class="card">
        <h3 class="text-lg font-semibold text-gray-600">Contactos</h3>
        <p class="text-3xl font-bold text-primary-600">{{ stats.total_contacts }}</p>
      </div>
      <div class="card">
        <h3 class="text-lg font-semibold text-gray-600">Calificación</h3>
        <p class="text-3xl font-bold text-primary-600">{{ stats.rating?.toFixed(1) }}</p>
      </div>
      <div class="card">
        <h3 class="text-lg font-semibold text-gray-600">Posición Ranking</h3>
        <p class="text-3xl font-bold text-primary-600">#{{ stats.ranking_position || 'N/A' }}</p>
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="card">
        <h2 class="text-2xl font-bold mb-4">Mensajes sin leer</h2>
        <p class="text-3xl font-bold text-primary-600">{{ stats.messages_unread }}</p>
        <NuxtLink to="/artista/mensajes" class="btn btn-primary mt-4 inline-block">
          Ver mensajes
        </NuxtLink>
      </div>
      <div class="card">
        <h2 class="text-2xl font-bold mb-4">Estado de membresía</h2>
        <p class="text-lg">{{ artist?.membership?.membership?.name || 'Sin membresía' }}</p>
        <NuxtLink to="/artista/membresia" class="btn btn-primary mt-4 inline-block">
          Gestionar membresía
        </NuxtLink>
      </div>
    </div>
  </div>
</template>

<script setup>
const api = useApi()
const authStore = useAuthStore()

const stats = ref(null)
const artist = ref(null)

const loadDashboard = async () => {
  try {
    const { data } = await api.get('/artist/dashboard')
    stats.value = data.stats
    artist.value = data.artist
  } catch (error) {
    console.error('Error al cargar dashboard:', error)
  }
}

onMounted(() => {
  loadDashboard()
})

definePageMeta({
  layout: 'artist',
  middleware: ['auth', 'role'],
  role: 'artist'
})
</script>


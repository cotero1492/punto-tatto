<template>
  <div>
    <h1 class="text-3xl font-bold mb-6">Dashboard Administrador</h1>

    <div v-if="stats" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      <div class="card">
        <h3 class="text-lg font-semibold text-gray-600">Artistas</h3>
        <p class="text-3xl font-bold text-primary-600">{{ stats.artists?.total || 0 }}</p>
        <p class="text-sm text-gray-500 mt-1">
          {{ stats.artists?.with_membership || 0 }} con membresía
        </p>
      </div>
      <div class="card">
        <h3 class="text-lg font-semibold text-gray-600">Clientes</h3>
        <p class="text-3xl font-bold text-primary-600">{{ stats.clients?.total || 0 }}</p>
      </div>
      <div class="card">
        <h3 class="text-lg font-semibold text-gray-600">Pagos este mes</h3>
        <p class="text-3xl font-bold text-primary-600">${{ stats.payments?.this_month || 0 }}</p>
      </div>
      <div class="card">
        <h3 class="text-lg font-semibold text-gray-600">Reseñas pendientes</h3>
        <p class="text-3xl font-bold text-primary-600">{{ stats.reviews?.pending || 0 }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
const api = useApi()

const stats = ref(null)

const loadDashboard = async () => {
  try {
    const { data } = await api.get('/admin/dashboard')
    stats.value = data.stats
  } catch (error) {
    console.error('Error al cargar dashboard:', error)
  }
}

onMounted(() => {
  loadDashboard()
})

definePageMeta({
  layout: 'admin',
  middleware: ['auth', 'role'],
  role: 'admin'
})
</script>


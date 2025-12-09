<template>
  <div>
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-20">
      <div class="container mx-auto px-4 text-center">
        <h1 class="text-5xl font-bold mb-4">PUNTO TATTO</h1>
        <p class="text-xl mb-8">Encuentra a los mejores artistas de tatuaje</p>
        <NuxtLink to="/artists" class="btn btn-outline text-white border-white hover:bg-white hover:text-primary-600">
          Explorar Artistas
        </NuxtLink>
      </div>
    </section>

    <!-- Featured Artists -->
    <section class="py-16">
      <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-8 text-center">Artistas Destacados</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
          <div v-for="artist in featuredArtists" :key="artist.id" class="card hover:shadow-lg transition-shadow">
            <NuxtLink :to="`/artists/${artist.id}`">
              <img 
                :src="artist.user?.photo || '/placeholder-avatar.jpg'" 
                :alt="artist.studio_name || artist.user?.name"
                class="w-full h-48 object-cover rounded-lg mb-4"
              />
              <h3 class="text-xl font-semibold">{{ artist.studio_name || artist.user?.name }}</h3>
              <p class="text-gray-600">{{ artist.location }}</p>
              <div class="flex items-center mt-2">
                <span class="text-yellow-400">★★★★★</span>
                <span class="ml-2 text-sm">{{ artist.rating_average?.toFixed(1) }}</span>
              </div>
            </NuxtLink>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
const api = useApi()
const featuredArtists = ref([])

onMounted(async () => {
  try {
    const { data } = await api.get('/public/artists', {
      params: { per_page: 8, sort: 'ranking' }
    })
    featuredArtists.value = data.data || []
  } catch (error) {
    console.error('Error al cargar artistas:', error)
  }
})

definePageMeta({
  layout: 'default'
})
</script>


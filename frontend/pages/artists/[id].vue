<template>
  <div v-if="artist" class="container mx-auto px-4 py-8">
    <!-- Header del artista -->
    <div class="card mb-6">
      <div class="flex flex-col md:flex-row gap-6">
        <img 
          :src="artist.user?.photo || '/placeholder-avatar.jpg'" 
          :alt="artist.studio_name || artist.user?.name"
          class="w-32 h-32 rounded-full object-cover"
        />
        <div class="flex-1">
          <h1 class="text-3xl font-bold">{{ artist.studio_name || artist.user?.name }}</h1>
          <p class="text-gray-600">{{ artist.location }}</p>
          <div class="flex items-center mt-2">
            <span class="text-yellow-400">★★★★★</span>
            <span class="ml-2">{{ artist.rating_average?.toFixed(1) }} ({{ artist.reviews_count }} reseñas)</span>
          </div>
          <div class="mt-4">
            <span 
              v-for="style in artist.styles" 
              :key="style"
              class="inline-block bg-primary-100 text-primary-800 text-xs px-3 py-1 rounded mr-2"
            >
              {{ style }}
            </span>
          </div>
        </div>
        <div v-if="authStore.isClient" class="flex flex-col gap-2">
          <button @click="contactArtist" class="btn btn-primary">
            Contactar
          </button>
          <button @click="toggleFavorite" class="btn btn-outline">
            {{ isFavorite ? '★ Favorito' : '☆ Agregar a favoritos' }}
          </button>
        </div>
      </div>
    </div>

    <!-- Información -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <!-- Contenido principal -->
      <div class="md:col-span-2">
        <div class="card mb-6">
          <h2 class="text-2xl font-bold mb-4">Sobre el artista</h2>
          <p class="text-gray-700">{{ artist.bio || 'No hay descripción disponible' }}</p>
        </div>

        <!-- Galería -->
        <div class="card mb-6">
          <h2 class="text-2xl font-bold mb-4">Galería</h2>
          <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            <img 
              v-for="gallery in artist.galleries" 
              :key="gallery.id"
              :src="gallery.image_url" 
              :alt="gallery.title"
              class="w-full h-48 object-cover rounded-lg"
            />
          </div>
        </div>

        <!-- Reseñas -->
        <div class="card">
          <h2 class="text-2xl font-bold mb-4">Reseñas</h2>
          <div v-for="review in artist.reviews" :key="review.id" class="border-b pb-4 mb-4 last:border-0">
            <div class="flex items-center mb-2">
              <span class="text-yellow-400">{{ '★'.repeat(review.rating) }}{{ '☆'.repeat(5 - review.rating) }}</span>
              <span class="ml-2 font-semibold">{{ review.client?.user?.name }}</span>
            </div>
            <p class="text-gray-700">{{ review.comment }}</p>
          </div>
        </div>
      </div>

      <!-- Sidebar -->
      <div>
        <div class="card mb-6">
          <h3 class="text-xl font-bold mb-4">Información</h3>
          <div class="space-y-3">
            <div v-if="artist.price_per_hour">
              <strong>Precio por hora:</strong> ${{ artist.price_per_hour }}
            </div>
            <div v-if="artist.working_hours">
              <strong>Horarios:</strong>
              <pre class="text-sm">{{ JSON.stringify(artist.working_hours, null, 2) }}</pre>
            </div>
            <div v-if="artist.portfolio_url">
              <strong>Portafolio:</strong>
              <a :href="artist.portfolio_url" target="_blank" class="text-primary-600 hover:underline">Ver enlace</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const route = useRoute()
const api = useApi()
const authStore = useAuthStore()

const artist = ref(null)
const isFavorite = ref(false)

const loadArtist = async () => {
  try {
    const { data } = await api.get(`/public/artists/${route.params.id}`)
    artist.value = data.artist
  } catch (error) {
    console.error('Error al cargar artista:', error)
    throw createError({ statusCode: 404, message: 'Artista no encontrado' })
  }
}

const contactArtist = () => {
  navigateTo(`/cliente/mensajes/${artist.value.user.id}`)
}

const toggleFavorite = async () => {
  try {
    if (isFavorite.value) {
      await api.delete(`/client/favorites/${artist.value.id}`)
      isFavorite.value = false
    } else {
      await api.post(`/client/favorites/${artist.value.id}`)
      isFavorite.value = true
    }
  } catch (error) {
    console.error('Error al actualizar favorito:', error)
  }
}

onMounted(() => {
  loadArtist()
})

definePageMeta({
  layout: 'default'
})
</script>


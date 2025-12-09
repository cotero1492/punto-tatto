<template>
  <div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Artistas de Tatuaje</h1>

    <!-- Filtros -->
    <div class="card mb-6">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
          <label class="label">Buscar</label>
          <input 
            v-model="filters.search" 
            type="text" 
            class="input" 
            placeholder="Nombre o estudio..."
            @input="loadArtists"
          />
        </div>
        <div>
          <label class="label">Estilo</label>
          <select v-model="filters.style" class="input" @change="loadArtists">
            <option value="">Todos los estilos</option>
            <option v-for="style in styles" :key="style" :value="style">{{ style }}</option>
          </select>
        </div>
        <div>
          <label class="label">Ciudad</label>
          <input 
            v-model="filters.city" 
            type="text" 
            class="input" 
            placeholder="Ciudad..."
            @input="loadArtists"
          />
        </div>
      </div>
    </div>

    <!-- Lista de artistas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div 
        v-for="artist in artists" 
        :key="artist.id" 
        class="card hover:shadow-lg transition-shadow cursor-pointer"
        @click="navigateTo(`/artists/${artist.id}`)"
      >
        <img 
          :src="artist.user?.photo || '/placeholder-avatar.jpg'" 
          :alt="artist.studio_name || artist.user?.name"
          class="w-full h-64 object-cover rounded-lg mb-4"
        />
        <h3 class="text-xl font-semibold">{{ artist.studio_name || artist.user?.name }}</h3>
        <p class="text-gray-600">{{ artist.location }}</p>
        <div class="flex items-center mt-2">
          <span class="text-yellow-400">★★★★★</span>
          <span class="ml-2 text-sm">{{ artist.rating_average?.toFixed(1) }} ({{ artist.reviews_count }})</span>
        </div>
        <div class="mt-4">
          <span 
            v-for="style in artist.styles?.slice(0, 3)" 
            :key="style"
            class="inline-block bg-primary-100 text-primary-800 text-xs px-2 py-1 rounded mr-2 mb-2"
          >
            {{ style }}
          </span>
        </div>
      </div>
    </div>

    <!-- Paginación -->
    <div v-if="pagination" class="mt-8 flex justify-center">
      <button 
        v-if="pagination.prev_page_url"
        @click="loadArtists(pagination.current_page - 1)"
        class="btn btn-secondary mr-2"
      >
        Anterior
      </button>
      <span class="px-4 py-2">{{ pagination.current_page }} de {{ pagination.last_page }}</span>
      <button 
        v-if="pagination.next_page_url"
        @click="loadArtists(pagination.current_page + 1)"
        class="btn btn-secondary ml-2"
      >
        Siguiente
      </button>
    </div>
  </div>
</template>

<script setup>
const api = useApi()

const artists = ref([])
const styles = ref([])
const pagination = ref(null)
const filters = ref({
  search: '',
  style: '',
  city: '',
})

const loadArtists = async (page = 1) => {
  try {
    const params = {
      page,
      ...filters.value,
    }
    Object.keys(params).forEach(key => {
      if (!params[key]) delete params[key]
    })

    const { data } = await api.get('/public/artists', { params })
    artists.value = data.data || []
    pagination.value = {
      current_page: data.current_page,
      last_page: data.last_page,
      prev_page_url: data.prev_page_url,
      next_page_url: data.next_page_url,
    }
  } catch (error) {
    console.error('Error al cargar artistas:', error)
  }
}

const loadStyles = async () => {
  try {
    const { data } = await api.get('/public/styles')
    styles.value = data.styles || []
  } catch (error) {
    console.error('Error al cargar estilos:', error)
  }
}

onMounted(() => {
  loadArtists()
  loadStyles()
})

definePageMeta({
  layout: 'default'
})
</script>


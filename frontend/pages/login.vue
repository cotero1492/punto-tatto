<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
      <div>
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
          Inicia sesión en tu cuenta
        </h2>
      </div>
      <form class="mt-8 space-y-6" @submit.prevent="handleLogin">
        <div class="rounded-md shadow-sm -space-y-px">
          <div>
            <label for="email" class="sr-only">Email</label>
            <input
              id="email"
              v-model="form.email"
              type="email"
              required
              class="input rounded-t-md"
              placeholder="Email"
            />
          </div>
          <div>
            <label for="password" class="sr-only">Contraseña</label>
            <input
              id="password"
              v-model="form.password"
              type="password"
              required
              class="input rounded-b-md"
              placeholder="Contraseña"
            />
          </div>
        </div>

        <div>
          <button
            type="submit"
            class="btn btn-primary w-full"
            :disabled="loading"
          >
            {{ loading ? 'Iniciando sesión...' : 'Iniciar sesión' }}
          </button>
        </div>

        <div class="text-center">
          <NuxtLink to="/register" class="text-primary-600 hover:underline">
            ¿No tienes cuenta? Regístrate
          </NuxtLink>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
const authStore = useAuthStore()
const router = useRouter()

const form = ref({
  email: '',
  password: '',
})
const loading = ref(false)

const handleLogin = async () => {
  loading.value = true
  try {
    await authStore.login(form.value.email, form.value.password)
    
    // Redirigir según el rol
    if (authStore.isArtist) {
      router.push('/artista/dashboard')
    } else if (authStore.isClient) {
      router.push('/cliente/dashboard')
    } else if (authStore.isAdmin) {
      router.push('/admin/dashboard')
    } else {
      router.push('/')
    }
  } catch (error) {
    alert('Error al iniciar sesión: ' + (error.response?.data?.message || error.message))
  } finally {
    loading.value = false
  }
}
</script>


<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
      <div>
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
          Crea tu cuenta
        </h2>
      </div>
      <form class="mt-8 space-y-6" @submit.prevent="handleRegister">
        <div class="space-y-4">
          <div>
            <label class="label">Nombre</label>
            <input
              v-model="form.name"
              type="text"
              required
              class="input"
              placeholder="Tu nombre"
            />
          </div>
          <div>
            <label class="label">Email</label>
            <input
              v-model="form.email"
              type="email"
              required
              class="input"
              placeholder="tu@email.com"
            />
          </div>
          <div>
            <label class="label">Contraseña</label>
            <input
              v-model="form.password"
              type="password"
              required
              class="input"
              placeholder="Mínimo 8 caracteres"
            />
          </div>
          <div>
            <label class="label">Confirmar contraseña</label>
            <input
              v-model="form.password_confirmation"
              type="password"
              required
              class="input"
              placeholder="Confirma tu contraseña"
            />
          </div>
          <div>
            <label class="label">Tipo de cuenta</label>
            <select v-model="form.role" required class="input">
              <option value="">Selecciona...</option>
              <option value="client">Cliente</option>
              <option value="artist">Artista</option>
            </select>
          </div>
        </div>

        <div>
          <button
            type="submit"
            class="btn btn-primary w-full"
            :disabled="loading"
          >
            {{ loading ? 'Registrando...' : 'Registrarse' }}
          </button>
        </div>

        <div class="text-center">
          <NuxtLink to="/login" class="text-primary-600 hover:underline">
            ¿Ya tienes cuenta? Inicia sesión
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
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  role: '',
})
const loading = ref(false)

const handleRegister = async () => {
  if (form.value.password !== form.value.password_confirmation) {
    alert('Las contraseñas no coinciden')
    return
  }

  loading.value = true
  try {
    await authStore.register(form.value)
    
    // Redirigir según el rol
    if (authStore.isArtist) {
      router.push('/artista/dashboard')
    } else if (authStore.isClient) {
      router.push('/cliente/dashboard')
    } else {
      router.push('/')
    }
  } catch (error) {
    alert('Error al registrarse: ' + (error.response?.data?.message || error.message))
  } finally {
    loading.value = false
  }
}
</script>


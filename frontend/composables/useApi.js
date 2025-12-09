import axios from 'axios'

export const useApi = () => {
  const config = useRuntimeConfig()
  const tokenCookie = useCookie('auth_token')

  const api = axios.create({
    baseURL: config.public.apiBase || 'http://localhost:8000/api',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    },
    withCredentials: true,
  })

  // Interceptor para agregar token de autenticación
  api.interceptors.request.use(
    (config) => {
      if (tokenCookie.value) {
        config.headers.Authorization = `Bearer ${tokenCookie.value}`
      }
      return config
    },
    (error) => {
      return Promise.reject(error)
    }
  )

  // Interceptor para manejar errores
  api.interceptors.response.use(
    (response) => response,
    (error) => {
      if (error.response?.status === 401) {
        // Token expirado o inválido
        tokenCookie.value = null
        navigateTo('/login')
      }
      return Promise.reject(error)
    }
  )

  return api
}


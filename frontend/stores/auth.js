import { defineStore } from 'pinia'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: null,
    isAuthenticated: false,
  }),

  getters: {
    isArtist: (state) => state.user?.role === 'artist',
    isClient: (state) => state.user?.role === 'client',
    isAdmin: (state) => state.user?.role === 'admin',
  },

  actions: {
    async login(email, password) {
      try {
        const api = useApi()
        const { data } = await api.post('/auth/login', { email, password })
        
        this.setAuth(data.user, data.token)
        return data
      } catch (error) {
        throw error
      }
    },

    async register(userData) {
      try {
        const api = useApi()
        const { data } = await api.post('/auth/register', userData)
        
        this.setAuth(data.user, data.token)
        return data
      } catch (error) {
        throw error
      }
    },

    async logout() {
      try {
        const api = useApi()
        await api.post('/auth/logout')
      } catch (error) {
        console.error('Error al cerrar sesión:', error)
      } finally {
        this.clearAuth()
      }
    },

    async fetchUser() {
      try {
        const api = useApi()
        const { data } = await api.get('/auth/user')
        this.user = data.user
        return data.user
      } catch (error) {
        this.clearAuth()
        throw error
      }
    },

    setAuth(user, token) {
      this.user = user
      this.token = token
      this.isAuthenticated = true
      
      const tokenCookie = useCookie('auth_token', {
        maxAge: 60 * 60 * 24 * 7, // 7 días
      })
      tokenCookie.value = token
    },

    clearAuth() {
      this.user = null
      this.token = null
      this.isAuthenticated = false
      
      const tokenCookie = useCookie('auth_token')
      tokenCookie.value = null
    },

    init() {
      const tokenCookie = useCookie('auth_token')
      if (tokenCookie.value) {
        this.token = tokenCookie.value
        this.fetchUser().catch(() => {
          this.clearAuth()
        })
      }
    },
  },
})


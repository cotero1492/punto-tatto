export default defineNuxtRouteMiddleware((to, from) => {
  const authStore = useAuthStore()
  const requiredRole = to.meta.role

  if (!authStore.isAuthenticated) {
    return navigateTo('/login')
  }

  if (requiredRole && authStore.user?.role !== requiredRole) {
    return navigateTo('/')
  }
})


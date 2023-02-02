import { useAuthStore } from '~/store/auth'
import { defineNuxtRouteMiddleware, navigateTo } from '#imports'

export default defineNuxtRouteMiddleware((to) => {
  const store = useAuthStore()

  if (to.path !== '/login' && !store.token) {
    return navigateTo('/login')
  }
})
import type { AuthState } from '~/types/state'
// @ts-ignore
import { defineStore } from 'pinia'
import { LoginData } from "~/types/auth"
import { navigateTo } from "#imports"
import axios from 'axios'

export const useAuthStore = defineStore('auth', {
  persist: true,

  state: (): AuthState => ({
    token: null
  }),

  actions: {
    async login(data: LoginData) {
      return await axios.post('/login', data)
    },

    async logout() {
      // @ts-ignore
      this.token = null

      navigateTo('/login')
    },

    async refreshToken(): Promise<string> {
      const response = await axios.get('/auth/refresh')

      const token: string = response.headers.authorization!.replace('Bearer ', '')

      // @ts-ignore
      this.token = token

      return token
    }
  }
})
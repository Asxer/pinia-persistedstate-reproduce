// @ts-ignore
import { defineStore } from 'pinia'
import type { CitiesState } from '~/types/state'
import axios from 'axios'

const initState = (): CitiesState => ({
  items: {
    data: [],
    total: 0,
    current_page: 1
  },
  item: {
    name: ''
  },
  filters: {
    query: '',
    order_by: null,
    desc: null,
  }
})

export const useCitiesStore = defineStore({
  id: 'cities',

  state: initState,

  actions: {
    async fetchCities() {
      // @ts-ignore
      const response = await axios.get('/cities', { params: this.filters})

      // @ts-ignore
      this.items = response.data
    },

    async fetch(id: number) {
      const response = await axios.get(`/cities/${ id }`)

      // @ts-ignore
      this.item = response.data
    },

    async clearItems() {
      // @ts-ignore
      this.items = initState().items
    },
  }
})
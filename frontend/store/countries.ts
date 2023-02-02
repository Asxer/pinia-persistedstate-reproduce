// @ts-ignore
import { defineStore } from 'pinia'
import type { CountriesState } from '~/types/state'
import axios from 'axios'

const initState = (): CountriesState => ({
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

export const useCountriesStore = defineStore({
  id: 'countries',

  state: initState,

  actions: {
    async fetchCountries() {
      // @ts-ignore
      const response = await axios.get('/countries', { params: this.filters})

      // @ts-ignore
      this.items = response.data
    },

    async fetch(id: number) {
      const response = await axios.get(`/countries/${ id }`)

      // @ts-ignore
      this.item = response.data
    },

    async clearItems() {
      // @ts-ignore
      this.items = initState().items
    },
  }
})
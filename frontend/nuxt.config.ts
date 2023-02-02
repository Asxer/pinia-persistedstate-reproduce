import svgLoader from 'vite-svg-loader'

// https://v3.nuxtjs.org/api/configuration/nuxt.config
export default defineNuxtConfig({
  runtimeConfig: {
    public: {
      API_BASE_URL: process.env.API_BASE_URL
    }
  },

  app: {
    head: {
      link: [
        { rel: "stylesheet", href: "https://use.fontawesome.com/releases/v6.2.0/css/all.css" }
      ]
    }
  },

  typescript: {
    strict: true
  },

  css: [
    '@/assets/scss/index.scss'
  ],

  modules: [
    '@pinia/nuxt'
  ],

  alias: {
    pinia: '/node_modules/@pinia/nuxt/node_modules/pinia/dist/pinia.mjs',
  },

  vite: {
    plugins: [
      svgLoader({})
    ],
    server: {
      hmr: {
        clientPort: 24600,
        port: 24600
      }
    }
  }
})

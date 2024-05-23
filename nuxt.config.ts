// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  devtools: {
    enabled: true
  },
  srcDir: 'src/',
  modules: ['@nuxt/image', '@nuxtjs/tailwindcss', 'shadcn-nuxt'],
  shadcn: {
    prefix: '',
    componentDir: './src/components/ui'
  },
  css: ['~/styles/index.sass'],
  runtimeConfig: {
    apiSecret: '', // can be overridden by NUXT_API_SECRET environment variable
    public: {
      apiURL: process.env.NUXT_PUBLIC_API_URL, // can be overridden by NUXT_PUBLIC_API_BASE environment variable
      isPreviewMode: process.env.NUXT_PUBLIC_IS_PRE_MODE,
    }
  },
})

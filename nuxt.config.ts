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
      appBase: process.env.NUXT_APP_BASE_URL || '/',
      apiURL: process.env.NUXT_PUBLIC_API_URL, // can be overridden by NUXT_PUBLIC_API_BASE environment variable
      appURL: process.env.NUXT_PUBLIC_APP_URL,
      loginURL: process.env.NUXT_PUBLIC_LOGIN_URL,
      isStage: process.env.NUXT_PUBLIC_IS_STAGE,
      preModeEndAt: process.env.NUXT_PUBLIC_PRE_MODE_END_AT,
    }
  },
})

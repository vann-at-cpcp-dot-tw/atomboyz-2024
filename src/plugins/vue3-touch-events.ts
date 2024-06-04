import Vue3TouchEvents from 'vue3-touch-events'

export default defineNuxtPlugin((nuxtApp:any)=>{
  nuxtApp.vueApp.use(Vue3TouchEvents, {
    disableClick: false
    // any other global options...
  })
})

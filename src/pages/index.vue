<script lang="tsx" setup>
import { useIntervalFn } from '@vueuse/core'
import Home from '~/components/templates/home/Home.vue'
import PreHome from '~/components/templates/home/PreHome.vue'
import Header from '~/components/Header.vue'
import DownloadSticker from '~/components/DownloadSticker.vue'
import CookieSticker from '~/components/CookieSticker.vue'
import GlobalAlert from '~/components/GlobalAlert.vue'
import Footer from '~/components/Footer.vue'
import { useStore } from '~/store'
import { calculateRemainingTime } from '~/lib/helpers'
definePageMeta({
  layout: 'home'
})
const config = useRuntimeConfig()
const PRE_MODE_END_AT = config.public.preModeEndAt as string
const store = useStore()
const state = reactive({
  preModeCountdown: {
    days: '--',
    hours: '--',
    minutes: '--',
    seconds: '--',
  },
})
const { pause, resume, isActive } = useIntervalFn(()=>{
  const [year, month, date, hour, minute] = PRE_MODE_END_AT.split('-')
  state.preModeCountdown = calculateRemainingTime({
    year,
    month,
    date,
    hour,
    minute,
  })
}, 1000)

watch(()=>state.preModeCountdown, (newVal)=>{
  const preModeCountdownTotal = Number(state.preModeCountdown.days) + Number(state.preModeCountdown.hours) + Number(state.preModeCountdown.minutes) + Number(state.preModeCountdown.seconds)

  if (preModeCountdownTotal >= 0){
    store.isPreMode = true
  }

  if (preModeCountdownTotal <= 0){
    store.isPreMode = false
  }
}, {
  immediate: true
})
</script>
<template>
  <div v-if="store.isPreMode === true" class="relative size-full bg-black">
    <PreHome :countdown="state.preModeCountdown" />
  </div>
  <div v-else-if="store.isPreMode === false">
    <Header />
    <div class="relative bg-black">
      <Home />
      <CookieSticker />
      <!-- <DownloadSticker /> -->
      <GlobalAlert />
    </div>
    <Footer />
  </div>
  <div v-else></div>
</template>

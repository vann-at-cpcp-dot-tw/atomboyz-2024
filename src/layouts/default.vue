<script lang="tsx" setup>
import Header from '~/components/Header.vue'
import DownloadSticker from '~/components/DownloadSticker.vue'
import CookieSticker from '~/components/CookieSticker.vue'
import GlobalAlert from '~/components/GlobalAlert.vue'
import Footer from '~/components/Footer.vue'
const config = useRuntimeConfig()
const APP_BASE = config.public.appBase
</script>
<template>
  <Html>
    <Header />
    <div class="relative bg-black">
      <div
      class="mb-5 h-[405px] w-full bg-no-repeat"
      :style="{
        backgroundImage: `url(${APP_BASE}assets/img/page_head.jpg)`,
        backgroundPosition: 'center top',
        backgroundSize: '1920px auto',
      }">
      </div>
      <slot></slot>
      <CookieSticker />
      <!-- <DownloadSticker /> -->
      <GlobalAlert />
    </div>
    <Footer />
  </Html>
</template>

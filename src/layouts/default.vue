<script lang="tsx" setup>
import Header from '~/components/Header.vue'
import DownloadSticker from '~/components/DownloadSticker.vue'
import CookieSticker from '~/components/CookieSticker.vue'
import GlobalAlert from '~/components/GlobalAlert.vue'
import Footer from '~/components/Footer.vue'
</script>
<template>
  <Html>
    <Header />
    <div class="relative bg-black">
      <div class="mb-5 h-[405px] w-full bg-no-repeat" style="background-image: url(/assets/img/page_head.jpg); background-position: center top; background-size: 1920px auto;">
      </div>
      <slot></slot>
      <CookieSticker />
      <DownloadSticker />
      <GlobalAlert />
    </div>
    <Footer />
  </Html>
</template>

<script lang="tsx" setup>
import DownloadSticker from '~/components/DownloadSticker.vue'
import CookieSticker from '~/components/CookieSticker.vue'
import GlobalAlert from '~/components/GlobalAlert.vue'
</script>
<template>
  <Html>
    <Header />
    <div class="relative bg-black">
      <slot></slot>
      <CookieSticker />
      <DownloadSticker />
      <GlobalAlert />
    </div>
    <Footer />
  </Html>
</template>

<script lang="tsx" setup>
import Header from '~/components/Header.vue'
import DownloadSticker from '~/components/DownloadSticker.vue'
import CookieSticker from '~/components/CookieSticker.vue'
import GlobalAlert from '~/components/GlobalAlert.vue'
import Footer from '~/components/Footer.vue'
</script>
<template>
  <!-- <Html>
    <Header />
    <div class="relative bg-black">
      <slot></slot>
      <CookieSticker />
      <DownloadSticker />
      <GlobalAlert />
    </div>
    <Footer />
  </Html> -->

  <!-- <Html>
    <div class="relative size-full bg-black">
      <slot></slot>
    </div>
  </Html> -->

  <Html>
    <slot></slot>
  </Html>
</template>

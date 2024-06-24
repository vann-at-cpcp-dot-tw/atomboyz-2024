<script lang="tsx" setup>
import Home from '~/components/templates/home/Home.vue'
import Header from '~/components/Header.vue'
import BottomStickySticker from '~/components/BottomStickySticker.vue'
import CookieSticker from '~/components/CookieSticker.vue'
import GlobalAlert from '~/components/GlobalAlert.vue'
import Footer from '~/components/Footer.vue'

definePageMeta({
  layout: 'home'
})
</script>
<template>
  <div>
    <Header />
    <div class="relative bg-black">
      <ClientOnly>
        <Home />
      </ClientOnly>
      <CookieSticker />
      <BottomStickySticker />
      <GlobalAlert />
    </div>
    <Footer />
  </div>
</template>

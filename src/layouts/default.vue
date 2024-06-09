<script lang="tsx" setup>
import RatioArea from 'vanns-common-modules/dist/components/vue/RatioArea'
import { useWindowSize } from '@vueuse/core'
import Header from '~/components/Header.vue'
import BottomStickySticker from '~/components/BottomStickySticker.vue'
import CookieSticker from '~/components/CookieSticker.vue'
import GlobalAlert from '~/components/GlobalAlert.vue'
import Footer from '~/components/Footer.vue'

const config = useRuntimeConfig()
const APP_BASE = config.public.appBase
const viewport = useWindowSize()
</script>
<template>
  <Html>
    <Header />
    <div class="relative bg-black">
      <div
      class="mb-5 hidden h-[405px] w-full bg-no-repeat lg:block"
      :style="{
        backgroundImage: `url(${APP_BASE}assets/img/page_head.jpg)`,
        backgroundPosition: 'center top',
        backgroundSize: '1920px auto',
      }">
      </div>
      <div
      class="mb-5 flex h-[205px] w-full items-center justify-center bg-no-repeat lg:hidden"
      :style="{
        backgroundImage: `url(${APP_BASE}assets/img/page_head_no_logo.jpg)`,
        backgroundPosition: 'center bottom',
        backgroundSize: '992px auto',
      }">
        <img src="/assets/img/title_home_1_m.png" style="max-width:140px; margin-top:40px;">
      </div>
      <!-- <div
      class="mb-[-170px] block h-[474px] w-full bg-no-repeat lg:hidden"
      :style="{
        backgroundImage: `url(${APP_BASE}assets/img/bg_home_1_m.jpg)`,
        backgroundPosition: 'center 90%',
        backgroundSize: '100% auto',
      }">
      </div> -->
      <!-- <div class="relative mb-[-40%] block lg:hidden">
        <RatioArea ratio="126">
          <div
          class="absolute left-0 top-0 size-full bg-no-repeat lg:hidden"
          :style="{
            backgroundImage: `url(${APP_BASE}assets/img/bg_home_1_m.jpg)`,
            backgroundPosition: 'center bottom',
            backgroundSize: '100% auto',
          }">
          </div>
        </RatioArea>
      </div> -->

      <slot></slot>
      <CookieSticker />
      <BottomStickySticker />
      <GlobalAlert />
    </div>
    <Footer />
  </Html>
</template>

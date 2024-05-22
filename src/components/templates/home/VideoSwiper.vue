<script lang="tsx" setup>
import { twMerge } from 'tailwind-merge'
import { Swiper, SwiperSlide } from 'swiper/vue'
import type { SwiperOptions } from 'swiper/types'
import { EffectCoverflow } from 'swiper/modules'
import RatioArea from 'vanns-common-modules/dist/components/vue/RatioArea'
import { useWindowSize } from '@vueuse/core'
import { convertYoutubeUrlToEmbed } from '~/lib/utils'
import EmbedPlayer from '~/components/EmbedPlayer.vue'

const window = process.client ? globalThis : null

interface IProps {
  class?: string
  className?: string
  list: {
    yt_url: string
    title: string
  }[]
}
const viewport = useWindowSize()
const props = defineProps<IProps>()
const state = reactive({
  open: '',
})
const swiperRef = ref<any>(null)
const swiperConfig = computed<SwiperOptions & {class:string}>(()=>{
  if (viewport.width.value && viewport.width.value <= 991){
    return {
      class: '',
      modules: [],
      spaceBetween: 0,
      pagination: { clickable: true },
      grabCursor: true,
      centeredSlides: false,
      slidesPerView: 1,
      loop: true,
    }
  } else if (props?.list?.length < 6){
    return {
      class: '',
      modules: [],
      spaceBetween: 12,
      pagination: { clickable: true },
      grabCursor: true,
      centeredSlides: false,
      slidesPerView: 2,
      loop: true,
    }
  } else {
    return {
      class: 'coverflow-swiper video-swiper !overflow-visible',
      modules: [EffectCoverflow],
      spaceBetween: 12,
      pagination: { clickable: true },
      grabCursor: true,
      centeredSlides: true,
      slidesPerView: 'auto',
      loop: true,
    }
  }
})
const listWithCoverImage = computed(()=>{
  return props?.list?.map((node)=>{
    const { cover, embedURL } = convertYoutubeUrlToEmbed(node?.yt_url) ?? {}
    return {
      ...node,
      cover,
      embedURL,
    }
  })
})
</script>
<template>
  <div :class="twMerge('', props.class)">
    <ClientOnly>
      <EmbedPlayer
      v-if="state.open"
      :embed-u-r-l="state.open"
      :on-close="()=>{
        state.open = ''
      }" />
      <div class="container-fluid mb-4">
        <div class="relative mx-auto flex w-full max-w-[1188px] !flex-nowrap items-center justify-between">
          <div
          v-if="swiperRef?.isLocked === false"
          :class="`btn btnScale-up`"
          @click="()=>{
            swiperRef.slidePrev()
          }">
            <img src="/assets/img/icon_arrow.svg" alt="" style="transform: rotateY(180deg);">
          </div>
          <div class="relative mx-auto w-full max-w-[1070px] overflow-hidden px-5">
            <Swiper
            id="video-swiper"
            :class="`${swiperRef?.isLocked ?'is-locked' :''} ${swiperConfig.class}`"
            :modules="swiperConfig.modules"
            :space-between="swiperConfig.spaceBetween"
            :pagination="swiperConfig.pagination"
            :grab-cursor="swiperConfig.grabCursor"
            :centered-slides="swiperConfig.centeredSlides"
            :slides-per-view="swiperConfig.slidesPerView"
            :loop="swiperConfig.loop"
            @swiper="(swiper)=>{
              swiperRef = swiper
            }"
            @slide-change="(swiper)=>{
              // if( swiper.realIndex === 0){

              // }
              // console.log(swiper)
              // if(window?.document?.?.getElementById?.('video-swiper')?.style){
              //   window.document.getElementById?.('video-swiper').style.left = '22px'
              // }
              // console.log()
              // window.document.getElementById('video-swiper').style.left = '22px'
            }">
              <SwiperSlide v-for="(node, index) in listWithCoverImage" :key="index">
                <div
                class="btn p-1"
                style="background: linear-gradient(#0c1074 0%, #5d00ff 46.03%, #0c1074 100%);"
                @click="()=>{
                  state.open = node?.embedURL || ''
                }">
                  <RatioArea ratio="56.25">
                    <div class="absolute left-0 top-0 size-full bg-cover bg-center" :style="{ backgroundImage: `url(${node?.cover})` }"></div>
                  </RatioArea>
                </div>
                <div class="line-clamp-1 bg-[#0E1077] p-1 text-[15px] leading-loose text-white">{{ node?.title }}</div>
              </SwiperSlide>
            </swiper>
          </div>
          <div
          v-if="swiperRef?.isLocked === false"
          :class="`btn btnScale-up`"
          @click="()=>{
            swiperRef.slideNext()
          }">
            <img src="/assets/img/icon_arrow.svg" alt="">
          </div>
        </div>
      </div>
    </ClientOnly>
  </div>
</template>

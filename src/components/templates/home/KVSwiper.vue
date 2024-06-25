<script lang="tsx" setup>
import { twMerge } from 'tailwind-merge'
import { Swiper, SwiperSlide } from 'swiper/vue'
import type { SwiperOptions } from 'swiper/types'
import { Pagination, EffectCoverflow } from 'swiper/modules'
import RatioArea from 'vanns-common-modules/dist/components/vue/RatioArea'
import { useWindowSize } from '@vueuse/core'
import { useStore } from '~/store'

const window = process.client ? globalThis : null
interface IProps {
  class?: string
  className?: string
  list: any[]
}
const store = useStore()
const props = defineProps<IProps>()
const viewport = useWindowSize()
const swiperRef = ref<any>(null)
const swiperConfig = computed<any>(()=>{
  if (viewport.width.value && viewport.width.value <= 991){
    return {
      class: '',
      modules: [Pagination],
      pagination: { clickable: true },
      effect: '',
      grabCursor: true,
      centeredSlides: false,
      slidesPerView: 1,
      coverflowEffect: null,
      loop: true,
    }
  }

  return {
    class: 'coverflow-swiper',
    modules: [Pagination, EffectCoverflow],
    pagination: { clickable: true },
    effect: 'coverflow',
    grabCursor: true,
    centeredSlides: true,
    slidesPerView: 'auto',
    loopAdditionalSlides: 100,
    coverflowEffect: {
      rotate: 0,
      scale: 1,
      slideShadows: false,
    },
    loop: true,
  }
})
const myList = computed(()=>{
  if (props?.list?.length < 6){
    return [
      ...(props?.list || []),
      ...(props?.list || []),
    ]
  }
  return props.list
})
</script>
<template>
  <div :class="twMerge('', props.class)">
    <ClientOnly>
      <div class="container mb-4">
        <div class="relative mx-auto flex w-full max-w-[1145px] !flex-nowrap items-center justify-between">
          <div
          v-show="swiperRef?.isLocked === false"
          :class="`btn btnScale-up`"
          @click="()=>{
            swiperRef.slidePrev()
            store.do.tracking('ClickEvent', '55003', 'hidol_campaign_function_click', {
              page_info: {
                sec: 'atomboyz_banner'
              },
              click_info: {
                type: 'switch_function',
                name: 'left'
              }
            })
          }">
            <img src="/assets/img/icon_arrow.svg" alt="" style="transform: rotateY(180deg);">
          </div>
          <div class="relative mx-auto w-full max-w-[1072px] px-5">
            <Swiper
            :class="swiperConfig.class"
            :modules="swiperConfig.modules"
            :pagination="swiperConfig.pagination"
            :effect="swiperConfig.effect"
            :grab-cursor="swiperConfig.grabCursor"
            :centered-slides="swiperConfig.centeredSlides"
            :slides-per-view="swiperConfig.slidesPerView"
            :coverflow-effect="swiperConfig.coverflowEffect"
            :loop="swiperConfig.loop"
            @swiper="(swiper)=>{
              swiperRef = swiper
            }"
            @slide-change="()=>{}">
              <SwiperSlide v-for="(node, index) in myList" :key="index">
                <NuxtLink
                :href="node?.href"
                target="_blank"
                @click="()=>{
                  store.do.click('bn')
                  store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
                    page_info: {
                      sec: 'atomboyz_banner'
                    },
                    click_info: {
                      type: 'banner_info',
                      name: node?.name,
                      url: node?.href
                    }
                  })
                }">
                  <RatioArea ratio="83.41">
                    <img class="item absolute left-0 top-0 size-full" :src="node?.img" style="box-shadow: 0px 0px 10px rgba(255, 255, 255, 0.2);">
                  </RatioArea>
                </NuxtLink>
              </SwiperSlide>
            </swiper>
          </div>
          <div
          v-show="swiperRef?.isLocked === false"
          :class="`btn btnScale-up`"
          @click="()=>{
            swiperRef.slideNext()
            store.do.tracking('ClickEvent', '55003', 'hidol_campaign_function_click', {
              page_info: {
                sec: 'atomboyz_banner'
              },
              click_info: {
                type: 'switch_function',
                name: 'right'
              }
            })
          }">
            <img src="/assets/img/icon_arrow.svg" alt="">
          </div>
        </div>
      </div>
    </ClientOnly>
  </div>
</template>

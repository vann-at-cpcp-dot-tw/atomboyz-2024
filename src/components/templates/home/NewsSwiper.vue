<script lang="tsx" setup>
import { twMerge } from 'tailwind-merge'
import { Swiper, SwiperSlide } from 'swiper/vue'
import type { SwiperOptions } from 'swiper/types'
import { EffectCoverflow } from 'swiper/modules'
import RatioArea from 'vanns-common-modules/dist/components/vue/RatioArea'
import { useWindowSize } from '@vueuse/core'
import MajorButton from '~/components/MajorButton.vue'
const window = process.client ? globalThis : null

interface IProps {
  class?: string
  className?: string
  list: any[]
}
const viewport = useWindowSize()
const props = defineProps<IProps>()
const swiperRef = ref<any>(null)
const swiperConfig = computed<SwiperOptions & {class:string}>(()=>{
  if ((viewport.width.value && viewport.width.value <= 991) || props?.list?.length < 4){
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
  } else {
    return {
      class: 'coverflow-swiper news-swiper !overflow-visible',
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
</script>
<template>
  <div :class="twMerge('', props.class)">
    <ClientOnly>
      <div class="container-fluid">
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
            :class="swiperConfig.class"
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
            @slide-change="()=>{}">
              <SwiperSlide v-for="(node, index) in props?.list" :key="index">
                <div class="item" style="border-image: linear-gradient(#0c1074 0%, #5d00ff 46.03%, #0c1074 100%) 1; border-width: 7px; border-style: solid;">
                  <div class="p-2.5">
                    <div class="row">
                      <div class="col-12 shrink lg:max-w-[51%]">
                        <NuxtLink :to="`/post/${node.id}`">
                          <RatioArea ratio="66.54">
                            <div class="absolute left-0 top-0 size-full bg-cover bg-center" :style="{ backgroundImage: `url(${node?.img})` }"></div>
                          </RatioArea>
                        </NuxtLink>
                      </div>
                      <div class="col-12 shrink text-white lg:max-w-[49%]">
                        <NuxtLink :to="`/post/${node.id}`">
                          <div class="mb-2 text-[18px]">{{ node.title }}</div>
                          <div class="mb-4 flex">
                            <div class="rounded-lg border px-2 py-1 text-[12px]">{{ node.date }}</div>
                          </div>
                          <div class="mb-2 line-clamp-2 text-[15px]">{{ node.excerpts }}</div>
                          <div class="flex justify-end">
                            <MajorButton style="max-width:134px; height: 43px;">看更多 <i class="bi bi-chevron-double-right text-[13px]"></i></MajorButton>
                          </div>
                        </NuxtLink>
                      </div>
                    </div>
                  </div>
                </div>
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

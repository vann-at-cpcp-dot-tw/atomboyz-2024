<script lang="tsx" setup>
import { twMerge } from 'tailwind-merge'
import { Swiper, SwiperSlide } from 'swiper/vue'
import type { SwiperOptions } from 'swiper/types'
import RatioArea from 'vanns-common-modules/dist/components/vue/RatioArea'
import { useWindowSize } from '@vueuse/core'
import MajorButton from '~/components/MajorButton.vue'
import HashJump from '~/components/HashJump.vue'
import { useStore } from '~/store'

const window = process.client ? globalThis : null

interface IProps {
  class?: string
  className?: string
  list: any[]
}
const store = useStore()
const viewport = useWindowSize()
const props = defineProps<IProps>()
const swiperRef = ref<any>(null)

const swiperConfig = computed<SwiperOptions & {class:string}>(()=>{
  if ((viewport.width.value && viewport.width.value <= 991)){
    return {
      class: 'sale-swiper',
      modules: [],
      spaceBetween: 8,
      // pagination: { clickable: true },
      grabCursor: true,
      centeredSlides: false,
      slidesPerView: 2,
      loop: true,
    }
  } else {
    return {
      class: 'sale-swiper',
      modules: [],
      spaceBetween: 20,
      // pagination: { clickable: true },
      grabCursor: true,
      centeredSlides: false,
      slidesPerView: 5,
      // slidesPerGroup: 5,
      loop: true,
    }
  }
})
</script>
<template>
  <div id="SALE" :class="twMerge('', props.class)">
    <ClientOnly>
      <div v-if="viewport.width.value >= 992 && props?.list?.length <= 5" class="container">
        <div class="row justify-center">
          <div v-for="(node, index) in props?.list" :key="index" class="col-auto w-1/5">
            <div class="mb-2 text-center text-white">{{ node?.name }}</div>
            <div class="mb-5">
              <RatioArea ratio="100">
                <div class="absolute left-0 top-0 size-full overflow-hidden rounded">
                  <div
                  class="absolute left-0 top-0 z-0 size-full bg-cover bg-center"
                  :style="{backgroundImage:`url(${node?.img})`}"></div>
                  <div class="absolute bottom-0 left-0 z-10 w-full bg-white px-2 py-1 text-center">{{ node?.price_string }}</div>
                </div>
              </RatioArea>
            </div>
            <a
            :href="node?.href"
            target="_blank"
            @click="()=>{
              store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
                page_info: {
                  sec: 'atomboyz_goods'
                },
                click_info: {
                  type: 'direct_goods',
                  url: node.href,
                  pos: index+1,
                  name: node.name
                }
              })
            }">
              <MajorButton class="btn-light mb-2 h-10">限時搶購</MajorButton>
            </a>
            <div class="text-[13px] text-white" v-html="node?.description"></div>
          </div>
        </div>
      </div>
      <div v-else class="container-fluid">
        <div class="relative mx-auto flex w-full max-w-[1188px] !flex-nowrap items-center justify-between">
          <div
          v-if="swiperRef?.isLocked === false"
          :class="`btn btnScale-up`"
          @click="()=>{
            swiperRef.slidePrev()
            store.do.tracking('ClickEvent', '55003', 'hidol_campaign_function_click', {
              page_info: {
                sec: 'atomboyz_goods'
              },
              click_info: {
                type: 'switch_function',
                name: 'left'
              }
            })
          }">
            <img class="_lg:w-[12px]" src="/assets/img/icon_arrow.svg" alt="" style="transform: rotateY(180deg);">
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
                <div class="mb-2 text-center text-white">{{ node?.name }}</div>
                <div class="mb-5">
                  <RatioArea ratio="100">
                    <div class="absolute left-0 top-0 size-full overflow-hidden rounded">
                      <div
                      class="absolute left-0 top-0 z-0 size-full bg-cover bg-center"
                      :style="{backgroundImage:`url(${node?.img})`}"></div>
                      <div class="absolute bottom-0 left-0 z-10 w-full bg-white px-2 py-1 text-center">{{ node?.price_string }}</div>
                    </div>
                  </RatioArea>
                </div>
                <a
                :href="node?.href"
                target="_blank"
                @click="()=>{
                  store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
                    page_info: {
                      sec: 'atomboyz_goods'
                    },
                    click_info: {
                      type: 'direct_goods',
                      url: node.href,
                      pos: index+1,
                      name: node.name
                    }
                  })
                }">
                  <MajorButton class="btn-light mb-2 h-10">限時搶購</MajorButton>
                </a>
                <div class="text-[13px] text-white" v-html="node?.description"></div>
              </SwiperSlide>
            </swiper>
          </div>
          <div
          v-if="swiperRef?.isLocked === false"
          :class="`btn btnScale-up`"
          @click="()=>{
            swiperRef.slideNext()
            store.do.tracking('ClickEvent', '55003', 'hidol_campaign_function_click', {
              page_info: {
                sec: 'atomboyz_goods'
              },
              click_info: {
                type: 'switch_function',
                name: 'right'
              }
            })
          }">
            <img class="_lg:w-[12px]" src="/assets/img/icon_arrow.svg" alt="">
          </div>
        </div>
      </div>
    </ClientOnly>
  </div>
</template>

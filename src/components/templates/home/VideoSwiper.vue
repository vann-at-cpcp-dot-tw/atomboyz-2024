<script lang="tsx" setup>
import { twMerge } from 'tailwind-merge'
import { Swiper, SwiperSlide } from 'swiper/vue'
import type { SwiperOptions } from 'swiper/types'
import { EffectCoverflow } from 'swiper/modules'
import RatioArea from 'vanns-common-modules/dist/components/vue/RatioArea'
import { useWindowSize } from '@vueuse/core'
import { convertYoutubeUrlToEmbed } from '~/lib/utils'
import EmbedPlayer from '~/components/EmbedPlayer.vue'
import { useStore } from '~/store'

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
const store = useStore()
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
      grabCursor: true,
      centeredSlides: false,
      slidesPerView: 1,
      loop: true,
    }
  }

  return {
    class: '',
    modules: [],
    spaceBetween: 12,
    grabCursor: true,
    centeredSlides: false,
    slidesPerView: props?.list?.length < 3 ? 2 : 3,
    loop: false,
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
          :class="`btn btnScale-up ${swiperRef?.isBeginning ?'lg:opacity-50 lg:pointer-events-none' :''}`"
          @click="()=>{
            swiperRef.slidePrev()
            store.do.tracking('ClickEvent', '55003', 'hidol_campaign_function_click', {
              page_info: {
                sec: 'atomboyz_videos',
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
            }">
              <SwiperSlide v-for="(node, index) in listWithCoverImage" :key="index">
                <div
                class="btn p-1"
                style="background: linear-gradient(#0c1074 0%, #5d00ff 46.03%, #0c1074 100%);"
                @click="()=>{
                  state.open = node?.embedURL || ''
                  store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
                    page_info: {
                      sec: 'atomboyz_videos',
                    },
                    click_info: {
                      type: 'direct_videos',
                      name: node.title
                    }
                  })
                }">
                  <RatioArea ratio="56">
                    <div class="absolute left-0 top-0 size-full bg-cover bg-center" :style="{ backgroundImage: `url(${node?.cover})` }"></div>
                  </RatioArea>
                </div>
                <div class="line-clamp-1 bg-[#0E1077] p-1 text-[15px] leading-loose text-white">{{ node?.title }}</div>
              </SwiperSlide>
            </swiper>
          </div>
          <div class="hidden lg:block">
            <div
            v-if="swiperRef?.isLocked === false && !swiperRef?.isEnd"
            :class="`btn btn-scaleUp`"
            @click="()=>{
              swiperRef.slideNext()
              store.do.tracking('ClickEvent', '55003', 'hidol_campaign_function_click', {
                page_info: {
                  sec: 'atomboyz_videos',
                },
                click_info: {
                  type: 'switch_function',
                  name: 'left'
                }
              })
            }">
              <img class="_lg:w-[12px]" src="/assets/img/icon_arrow.svg" alt="">
            </div>
            <NuxtLink
            v-if="swiperRef?.isLocked === false && swiperRef?.isEnd"
            to="/news/video"
            class="btn btn-scaleUp flex !flex-nowrap items-center _lg:hidden"
            @click="()=>{
              store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
                page_info: {
                  sec: 'atomboyz_videos',
                },
                click_info: {
                  type: 'direct_videos',
                  name: 'see_more'
                }
              })
            }">
              <span class="whitespace-nowrap pr-2 text-[20px] text-white underline">更多內容</span>
              <i class="bi bi-chevron-right text-[18px] text-white"></i>
            </NuxtLink>
          </div>
          <div class="block lg:hidden">
            <div
            :class="`btn btn-scaleUp ${swiperRef?.isLocked === false && !swiperRef?.isEnd ?'' :'opacity-0 pointer-events-none'}`"
            @click="()=>{
              swiperRef.slideNext()
            }">
              <img class="_lg:w-[12px]" src="/assets/img/icon_arrow.svg" alt="">
            </div>
          </div>
        </div>
      </div>

      <div class="container-fluid mt-5 flex justify-center lg:hidden">
        <NuxtLink
        v-if="swiperRef?.isLocked === false && swiperRef?.isEnd"
        class="btn btn-scaleUp flex !flex-nowrap items-center"
        to="/news/video"
        @click="()=>{
          store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
            page_info: {
              sec: 'atomboyz_videos',
            },
            click_info: {
              type: 'direct_videos',
              name: 'see_more'
            }
          })
        }">
          <span class="whitespace-nowrap pr-2 text-[12px] text-white underline">更多內容</span>
          <i class="bi bi-chevron-right text-[12px] text-white"></i>
        </NuxtLink>
      </div>
    </ClientOnly>
  </div>
</template>

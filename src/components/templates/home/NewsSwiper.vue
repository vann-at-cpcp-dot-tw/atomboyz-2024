<script lang="tsx" setup>
import { twMerge } from 'tailwind-merge'
import { Swiper, SwiperSlide } from 'swiper/vue'
import type { SwiperOptions } from 'swiper/types'
import { EffectCoverflow } from 'swiper/modules'
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
const viewport = useWindowSize()
const props = defineProps<IProps>()
const store = useStore()
const swiperRef = ref<any>(null)
const swiperConfig = computed<SwiperOptions & {class:string}>(()=>{
  if (viewport.width.value && viewport.width.value <= 991){
    return {
      class: 'swiper-news',
      modules: [],
      spaceBetween: 0,
      grabCursor: true,
      centeredSlides: false,
      slidesPerView: 1,
      loop: true,
    }
  }

  return {
    class: 'swiper-news',
    modules: [],
    spaceBetween: 12,
    grabCursor: true,
    centeredSlides: false,
    // slidesPerView: props?.list?.length < 3 ? 2 : 3,
    slidesPerView: 2,
    loop: false,
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
          :class="`btn btnScale-up ${swiperRef?.isBeginning ?'lg:opacity-50 lg:pointer-events-none' :''}`"
          @click="()=>{
            swiperRef.slidePrev()
            store.do.tracking('ClickEvent', '55003', 'hidol_campaign_function_click', {
              page_info: {
                sec: 'atomboyz_news',
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
                <div class="item flex flex-col" style="border-image: linear-gradient(#0c1074 0%, #5d00ff 46.03%, #0c1074 100%) 1; border-width: 7px; border-style: solid;">
                  <div class="flex grow flex-col p-2.5">
                    <div class="row grow">
                      <div class="col-12 shrink lg:max-w-[51%]">
                        <NuxtLink
                        :to="node?.url ?node.url :`/article/${node.id}`"
                        :target="node?.url ?'_blank' :'_self'"
                        @click="()=>{
                          store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
                            page_info: {
                              sec: 'atomboyz_news',
                            },
                            click_info: {
                              type: 'direct_news',
                              name: node?.title
                            }
                          })
                        }">
                          <RatioArea ratio="66.54">
                            <div class="absolute left-0 top-0 size-full bg-cover bg-center" :style="{ backgroundImage: `url(${node?.img})` }"></div>
                          </RatioArea>
                        </NuxtLink>
                      </div>
                      <div class="col-12 shrink text-white lg:max-w-[49%]">
                        <NuxtLink
                        :to="node?.url ?node.url :`/article/${node.id}`"
                        :target="node?.url ?'_blank' :'_self'"
                        @click="()=>{
                          store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
                            page_info: {
                              sec: 'atomboyz_news',
                            },
                            click_info: {
                              type: 'direct_news',
                              name: node?.title
                            }
                          })
                        }">
                          <div class="mb-2 line-clamp-3 text-[18px]">{{ node.title }}</div>
                          <div class="mb-4 flex">
                            <div class="rounded-lg border px-2 py-1 text-[12px]">{{ node.date }}</div>
                          </div>
                          <div class="mb-3 line-clamp-2 text-[15px]" v-html="node.excerpts"></div>
                        </NuxtLink>
                      </div>
                      <div class="col-12 mt-auto">
                        <div class="flex justify-center lg:justify-end">
                          <MajorButton
                          style="max-width:134px; height: 43px;"
                          @click="()=>{
                            store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
                              page_info: {
                                sec: 'atomboyz_news',
                              },
                              click_info: {
                                type: 'direct_news',
                                name: 'see_more'
                              }
                            })
                          }">
                            看更多 <i class="bi bi-chevron-double-right text-[13px]"></i>
                          </MajorButton>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
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
                  sec: 'atomboyz_news',
                },
                click_info: {
                  type: 'switch_function',
                  name: 'right'
                }
              })
            }">
              <img class="_lg:w-[12px]" src="/assets/img/icon_arrow.svg" alt="">
            </div>
            <NuxtLink
            v-if="swiperRef?.isLocked === false && swiperRef?.isEnd"
            to="/news/article"
            class="btn btn-scaleUp flex !flex-nowrap items-center _lg:hidden"
            @click="()=>{
              store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
                page_info: {
                  sec: 'atomboyz_news',
                },
                click_info: {
                  type: 'direct_news',
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
        to="/news/video">
          <span class="whitespace-nowrap pr-2 text-[12px] text-white underline">更多內容</span>
          <i class="bi bi-chevron-right text-[12px] text-white"></i>
        </NuxtLink>
      </div>
    </ClientOnly>
  </div>
</template>

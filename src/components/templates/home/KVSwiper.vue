<script lang="tsx" setup>
import { twMerge } from 'tailwind-merge'
import { Swiper, SwiperSlide } from 'swiper/vue'
import { Pagination, EffectCoverflow } from 'swiper/modules'
import RatioArea from 'vanns-common-modules/dist/components/vue/RatioArea'
const window = process.client ? globalThis : null
interface IProps {
  class?: string
  className?: string
  list: any[]
}
const props = defineProps<IProps>()
const swiperRef = ref<any>(null)
</script>
<template>
  <div :class="twMerge('', props.class)">
    <ClientOnly>
      <div class="container mb-4">
        <div class="relative mx-auto flex w-full max-w-[1145px] !flex-nowrap items-center justify-between">
          <div
          :class="`btn btnScale-up`"
          @click="()=>{
            swiperRef.slidePrev()
          }">
            <img src="/assets/img/icon_arrow.svg" alt="" style="transform: rotateY(180deg);">
          </div>
          <div class="relative mx-auto w-full max-w-[1072px] px-5">
            <Swiper
            class="coverflow-swiper"
            :modules="[Pagination, EffectCoverflow]"
            :pagination="{ clickable: true }"
            :effect="'coverflow'"
            :grab-cursor="true"
            :centered-slides="true"
            :slides-per-view="'auto'"
            :coverflow-effect="{
              rotate: 50,
              stretch: 0,
              depth: 100,
              modifier: 1,
              slideShadows: true,
            }"
            :loop="true"
            @swiper="(swiper)=>{
              swiperRef = swiper
            }"
            @slide-change="()=>{}">
              <SwiperSlide v-for="(node, index) in props?.list" :key="index">
                <RatioArea ratio="83.41">
                  <img class="item absolute left-0 top-0 size-full" :src="node?.img" style="box-shadow: 0px 0px 10px rgba(255, 255, 255, 0.2);">
                </RatioArea>
              </SwiperSlide>
            </swiper>
          </div>
          <div
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

<script lang="tsx" setup>
import { twMerge } from 'tailwind-merge'
import { teams } from '~/lib/utils'
const window = process.client ? globalThis : null
interface IProps {
  class?: string
  className?: string
}
interface IState {
  active: null | number
  clickTimes: number,
}
const props = defineProps<IProps>()
const router = useRouter()
const state = reactive<IState>({
  active: null,
  clickTimes: 0,
})
function handleClick(teamIndex:number){
  if (state.active === teamIndex){
    router.push({
      path: '/vote',
      hash: `#${teams[teamIndex].tagId}`
    })
    return
  }
  state.active = teamIndex
}
</script>
<template>
  <div :class="twMerge('overflow-hidden bg-[#120C60]', props.class)">
    <div class="container relative">
      <img class="mx-auto max-w-[254px] lg:-mb-8 lg:max-w-[267px]" src="/assets/img/section_title_home_6.png">
      <!-- <img class="absolute right-0 top-[22%] min-w-[721px] lg:top-[7%] lg:min-w-[1879px]" src="/assets/img/home_stars_circle.svg"> -->
      <div class="mx-auto hidden w-full max-w-[988px] lg:block">
        <div class="mb-6 pr-[168px]">
          <div class="flex">
            <div v-for="(teamIndex) in [0,1,2]" :key="teamIndex" class="flex w-1/3 justify-center">
              <NuxtLink
              :to="`/vote#${teams[teamIndex].tagId}`"
              class="btn relative"
              @mouseenter="()=>{
                state.active = teamIndex
              }"
              @mouseleave="()=>{
                state.active = null
              }">
                <img
                class="mx-auto mb-3"
                :src="teams[teamIndex].getImg()"
                :style="{
                  maxWidth: '283px',
                  filter: `drop-shadow(0px 0px 20px rgba(255, 255, 255, 0.5)) ${state.active !== null && state.active !== teamIndex ?'brightness(0.2) grayscale(1)' :''}`
                }">
                <div :class="`text-center text-[25px] text-white -mt-10 ${state.active !== null && state.active !== teamIndex ?'opacity-10' :''}`">{{ teams[teamIndex].name }}</div>
                <div
                v-if="state.active === teamIndex"
                :class="`absolute w-[226px] p-5 rounded-lg text-white z-10 top-1/2 -translate-y-1/2 left-[100%] -ml-8`"
                style="background: linear-gradient(rgba(218, 217, 246, 0.4)  0%, rgba(218, 217, 246, 0.4) 100%);">
                  {{ teams[teamIndex].description }}
                </div>
              </NuxtLink>
            </div>
          </div>
        </div>
        <div class="pl-[168px]">
          <div class="flex">
            <div v-for="(teamIndex) in [3,4,5]" :key="teamIndex" class="flex w-1/3 justify-center">
              <NuxtLink
              :to="`/vote#${teams[teamIndex].tagId}`"
              class="btn relative"
              @mouseenter="()=>{
                state.active = teamIndex
              }"
              @mouseleave="()=>{
                state.active = null
              }">
                <img
                class="mx-auto mb-3"
                :src="teams[teamIndex].getImg()"
                :style="{
                  maxWidth: '283px',
                  filter: `drop-shadow(0px 0px 20px rgba(255, 255, 255, 0.5)) ${state.active !== null && state.active !== teamIndex ?'brightness(0.2) grayscale(1)' :''}`
                }">
                <div :class="`text-center text-[25px] text-white -mt-10 ${state.active !== null && state.active !== teamIndex ?'opacity-10' :''}`">{{ teams[teamIndex].name }}</div>
                <div
                v-if="state.active === teamIndex"
                :class="`absolute w-[226px] p-5 rounded-lg text-white z-10 top-1/2 -translate-y-1/2 right-[100%] -mr-12`"
                style="background: linear-gradient(rgba(218, 217, 246, 0.4)  0%, rgba(218, 217, 246, 0.4) 100%);">
                  {{ teams[teamIndex].description }}
                </div>
              </NuxtLink>
            </div>
          </div>
        </div>
      </div>
      <div class="row row-gap-8 lg:hidden">
        <div
        v-for="(teamIndex) in [0,1,2,3,4,5]"
        :key="teamIndex"
        :class="`mb-4 col-6 relative flex ${teamIndex%2 === 0 ?'justify-end' :''}`">
          <div
          class="btn relative"
          @click="handleClick(teamIndex)">
            <img
            class="mx-auto mb-3"
            :src="teams[teamIndex].getImg()"
            :style="{
              maxWidth: '127px',
              filter: `drop-shadow(0px 0px 10px rgba(255, 255, 255, 0.5)) ${state.active !== null && state.active !== teamIndex ?'brightness(0.2) grayscale(1)' :''}`,
            }">
            <div :class="`text-center text-[12px] text-white -mt-6 ${state.active !== null && state.active !== teamIndex ?'opacity-10' :''}`">{{ teams[teamIndex].name }}</div>
            <div
            v-if="state.active === teamIndex"
            :class="`absolute w-[160px] py-2.5 px-4 rounded-lg text-[12px] text-white z-10 ${teamIndex%2 === 0 ?'left-[100%] -ml-4': 'right-[100%] -mr-4'} top-1/2 -translate-y-1/2`"
            style="background: linear-gradient(rgba(218, 217, 246, 0.4)  0%, rgba(218, 217, 246, 0.4) 100%);">
              {{ teams[teamIndex].description }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

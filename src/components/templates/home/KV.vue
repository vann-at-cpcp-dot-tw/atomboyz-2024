<script lang="tsx" setup>
import { twMerge } from 'tailwind-merge'
import { useIntervalFn } from '@vueuse/core'
import { calculateRemainingTime } from '~/lib/helpers'
import { useStore } from '~/store'

const window = process.client ? globalThis : null
interface IProps {
  class?: string
  className?: string
}
const props = defineProps<IProps>()
const store = useStore()
const state = reactive({
  countdown: {
    days: '--',
    hours: '--',
    minutes: '--',
    seconds: '--',
  },
})
const { pause, resume, isActive } = useIntervalFn(()=>{
  if (!store.general.countdown_end_time){
    return
  }
  const [year, month, date, hour, minute] = store.general.countdown_end_time.split('-')
  state.countdown = calculateRemainingTime({
    year,
    month,
    date,
    hour,
    minute,
  })
}, 1000)
</script>
<template>
  <div :class="twMerge('', props.class)">
    <div class="container flex justify-center">
      <img src="/assets/img/title_home_1.png" style="max-width:929px;">
    </div>
    <div class="container mb-6 flex justify-center">
      <img src="/assets/img/title_home_2.png" style="max-width:500px;">
    </div>
    <div class="container relative z-10 mb-6 flex justify-center">
      <div class="flex w-auto flex-none flex-nowrap items-center rounded-l-lg px-5 py-2.5 text-white" style="background: rgba(53, 69, 241, 0.73); box-shadow: 0px 4px 9px inset rgba(255,255,255,0.75);">
        <img src="/assets/img/icon_timer.svg">
        <div class="pl-2 text-[18px]">投 票 倒 數</div>
      </div>
      <div class="rounded-r-lg px-5 py-2.5 text-[#F7EEA7]" style="background: rgba(16, 25, 122, 0.57); box-shadow: 0px 4px 9px inset rgba(255,255,255,0.75);">
        <div class="pl-2 text-[18px]">
          <i class="text-[24px] font-900">{{ state.countdown.days }}</i>&nbsp;<span class="text-[13px]">天</span>&nbsp;
          <i class="text-[24px] font-900">{{ state.countdown.hours }}</i>&nbsp;<span class="text-[13px]">時</span>&nbsp;
          <i class="text-[24px] font-900">{{ state.countdown.minutes }}</i>&nbsp;<span class="text-[13px]">分</span>&nbsp;
          <i class="text-[24px] font-900">{{ state.countdown.seconds }}</i>&nbsp;<span class="text-[13px]">秒</span>&nbsp;
        </div>
      </div>
    </div>
    <div class="container mb-[75px] flex justify-center">
      <NuxtLink
      to="/vote"
      class="btn btn-scaleUp flex items-center rounded-full px-8 py-3.5"
      style="background: linear-gradient(#fcf4b6 0%, #e6d651 100%); filter: drop-shadow(0px 0px 25px #fff);">
        <img src="/assets/img/icon_rocket.svg">
        <div class="pl-2 text-black">投 票 應 援</div>
      </NuxtLink>
    </div>
  </div>
</template>

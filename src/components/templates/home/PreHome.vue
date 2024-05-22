<script lang="tsx" setup>
import { useWindowSize, useIntervalFn } from '@vueuse/core'
import { useStore } from '~/store'
import MajorButton from '~/components/MajorButton.vue'
import Footer from '~/components/Footer.vue'
import { calculateRemainingTime } from '~/lib/helpers'
import Lightbox from '~/components/Lightbox.vue'
const viewport = useWindowSize()
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
  const [year, month, date, hour, minute] = store.general.coming_soon_end_time.split('-')
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
  <div class="flex size-full flex-col">
    <main
    class="size-full bg-black bg-no-repeat text-white"
    :style="{
      backgroundImage: 'url(/assets/img/bg_pre_home.jpg)',
      backgroundSize: '1893px',
      backgroundPosition: 'center bottom'
    }">
      <Lightbox id="PreHomeReminder" icon="person-fill" title="Game Pass 註冊">
        <div class="mb-6 text-black">本次「hidol X 原子少年 2 線上投票」限定使用 Gama Pass 帳號登入，請於 06/11 前點擊註冊或完成 beanfun! 帳號升級，為您心愛的少年投票。</div>
        <div class="row">
          <div class="col-6">
            <MajorButton class="h-[40px]">
              beanfun! 升級
            </MajorButton>
          </div>
          <div class="col-6">
            <MajorButton class="h-[40px]">
              全新註冊
            </MajorButton>
          </div>
        </div>
      </Lightbox>

      <div class="container mb-4 flex justify-center pt-1 lg:pt-[68px]">
        <img class="hidden lg:block" src="/assets/img/title_home_1.png" style="max-width: 498px;">
        <img class="block lg:hidden" src="/assets/img/title_home_1_m.png" style="max-width: 192px;">
      </div>
      <div class="container text-center">
        <div class="mb-4 text-[20px] lg:text-[30px]">
          獨家線上投票 <b>Coming Soon</b>
        </div>
      </div>
      <div class="container-fluid mb-8 px-4">
        <div class="mx-auto w-full max-w-[375px] lg:max-w-[697px]">
          <div class="row lg:row-gap-5 row-gap-2 flex-nowrap items-center justify-center">
            <div class="col-auto w-1/4 shrink text-center">
              <div class="whitespace-nowrap text-[56px] font-600 leading-none sm:text-[60px] lg:text-[98px]">
                {{ state.countdown.days }}
              </div>
              <div class="-mb-2 text-center text-[12px] font-300 lg:-mb-4 lg:text-[19px]">DAYS</div>
            </div>
            <div class="col-auto">
              <div class="text-[22px] lg:text-[52px]">:</div>
            </div>
            <div class="col-auto w-1/4 shrink text-center">
              <div class="whitespace-nowrap text-[56px] font-600 leading-none sm:text-[60px] lg:text-[98px]">
                {{ state.countdown.hours }}
              </div>
              <div class="-mb-2 text-center text-[12px] font-300 lg:-mb-4 lg:text-[19px]">HOURS</div>
            </div>
            <div class="col-auto">
              <div class="text-[22px] lg:text-[52px]">:</div>
            </div>
            <div class="col-auto w-1/4 shrink text-center">
              <div class="whitespace-nowrap text-[56px] font-600 leading-none sm:text-[60px] lg:text-[98px]">
                {{ state.countdown.minutes }}
              </div>
              <div class="-mb-2 text-center text-[12px] font-300 lg:-mb-4 lg:text-[19px]">MINUTES</div>
            </div>
            <div class="col-auto">
              <div class="text-[22px] lg:text-[52px]">:</div>
            </div>
            <div class="col-auto w-1/4 shrink text-center">
              <div class="whitespace-nowrap text-[56px] font-600 leading-none sm:text-[60px] lg:text-[98px]">
                {{ state.countdown.seconds }}
              </div>
              <div class="-mb-2 text-center text-[12px] font-300 lg:-mb-4 lg:text-[19px]">SECONDS</div>
            </div>
          </div>
        </div>
      </div>
      <div class="container flex justify-center">
        <MajorButton
        class="btn btn-light h-[42px] w-[150px] lg:h-[60px] lg:w-[215px] lg:text-[20px]"
        @click="()=>{
          store.do.lightboxOpen('PreHomeReminder')
        }">
          搶先註冊
        </MajorButton>
      </div>
    </main>
    <Footer />
  </div>
</template>

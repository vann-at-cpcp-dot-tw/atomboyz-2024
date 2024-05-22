<script lang="tsx" setup>
import { twMerge } from 'tailwind-merge'
import Lightbox from './Lightbox.vue'
import { useStore } from '~/store'

const window = process.client ? globalThis : null
const config = useRuntimeConfig()
const API_URL = config.public.apiURL
interface IProps {
  class?: string
  className?: string
  close: Function
}
const props = defineProps<IProps>()
const router = useRouter()
const store = useStore()
const gameFetcher = await useAsyncData<any>('game', ()=>{
  return $fetch(`${API_URL}/game.php`, {
    params: {
    }
  })
}, {
  immediate: false
})

const rewardAngles:{[key:number]: string | number} = {
  1: '6.8turn',
  2: '6.6turn',
  3: '6.4turn',
  4: '6.2turn',
  5: '7turn',
}
const state = reactive<any>({
  animationDuration: 6000,
  rewardAngle: 0,
  isAnimationCompleted: false,
  hasResult: computed(()=>{
    return gameFetcher.data.value !== null
  }),
})
const isShowWinScreen = computed(()=>{
  return String(gameFetcher.data.value?.data?.result?.code) === '1' && gameFetcher.data.value?.data?.result?.reward && state.isAnimationCompleted
})

const handleResult = function(code:string | number){
  switch (String(code)){
    case '2':
      store.do.lightboxOpen('IsGamePlayed')
      break

    case '3':
      store.do.lightboxOpen('IsGameNotOpen')
      break
  }
}
watch(()=>gameFetcher.data.value?.data, (newVal, oldVal)=>{
  const { result } = newVal ?? {}
  const { code, reward } = result ?? {}
  switch (String(code)){
    case '1':
      state.rewardAngle = rewardAngles?.[reward]
      setTimeout(()=>{
        state.isAnimationCompleted = true
      }, state.animationDuration + 500)
      break

    default:
      handleResult(code)
      break
  }
})
</script>
<template>
  <Lightbox
  id="IsGamePlayed"
  icon="bell-fill"
  title="轉盤遊戲一天只能玩一次唷"
  :on-close="()=>{
    props.close()
  }">
    <div class="mb-6">快快解鎖其他任務換取加票機會！</div>
    <div class="flex justify-end">
      <MajorButton class="h-[40px] max-w-[154px]">
        <div class="flex items-center">
          每日任務 <i class="bi bi-chevron-double-right block text-[14px] leading-none"></i>
        </div>
      </MajorButton>
    </div>
  </Lightbox>

  <Lightbox
  id="IsGameNotOpen"
  icon="calendar-x"
  title="目前非開放期間"
  :on-close="()=>{
    props.close()
  }">
    <div class="mb-6">
      轉盤小遊戲的開放時間為每天 00:00 至 23:55，記得明天要再回來玩喔！
    </div>
  </Lightbox>

  <div :class="twMerge('fixed size-full z-[1000] left-0 top-0', props.class)" style="background: rgba(0,0,0,0.8);">
    <div class="absolute left-0 top-0 z-0 size-full bg-cover" style="background-image: url(/assets/img/game_bg.png);"></div>
    <div v-show="isShowWinScreen">
      <img class="pointer-events-none absolute left-1/2 top-[66px] hidden w-[1110px] min-w-[1110px] -translate-x-1/2 lg:block" src="/assets/img/game_success_deco.png">
      <img class="pointer-events-none absolute left-1/2 top-8 block  w-[375px] min-w-[375px] -translate-x-1/2 lg:hidden" src="/assets/img/game_success_deco_m.png">
    </div>
    <div class="absolute left-0 top-0 z-10 size-full overflow-auto p-4 lg:p-10">
      <div class="flex w-full justify-end">
        <div
        class="btn btn-light flex size-[45px] items-center justify-center rounded-full bg-major text-white"
        @click="props.close()">
          <i class="bi bi-x text-[32px]"></i>
        </div>
      </div>
      <div class="relative z-10 -mb-4 flex w-full justify-center lg:-mb-8">
        <img class="max-w-[256px] lg:max-w-[390px]" src="/assets/img/game_title.png" alt="">
      </div>

      <div class="relative z-0 mb-2 flex w-full flex-col flex-nowrap items-center overflow-hidden lg:flex-row lg:justify-center">
        <div class="relative size-[326px] flex-none lg:size-[482px]">
          <img class="animate__lightup animate__infinite animate__animated pointer-events-none absolute left-0 top-0 z-10 size-full" src="/assets/img/game_frame.png" alt="">
          <img
          class="pointer-events-none absolute z-0"
          src="/assets/img/game_board.png"
          :style="{
            width: '86.92%',
            left: '4%',
            top: '3%',
            transition: `all ${state.animationDuration}ms cubic-bezier(0.000, 1.230, 0.78, 0.990)`,
            transform: `rotate(${state.rewardAngle})`,
          }">
          <img
          src="/assets/img/game_center.png"
          :class="`btn btn-dark absolute ${state.hasResult ?'pointer-events-none' :'animate__animated animate__pulse animate__infinite'}`"
          :style="{
            width: '34.23%',
            left: '33%',
            top: '33%',
            filter: state.hasResult ?'brightness(0.8)' :'brightness(1)',
          }"
          @click="()=>{
            if( !state.hasResult ){
              gameFetcher.execute()
            }else{
              handleResult(gameFetcher.data.value?.data?.result?.code)
            }
          }">
        </div>
        <div
        v-if="isShowWinScreen"
        class="mb-4 w-auto shrink text-center text-[#dfdcec] lg:mb-0 lg:text-left">
          <img class="mb-2.5 w-[207px] lg:w-[290px]" src="/assets/img/game_congrats_title.svg" style="filter: drop-shadow(0px 3px 48px rgba(0, 0, 0, 0.97));">
          <div class="text-[20px] lg:text-[28px]">恭喜您獲得 {{ gameFetcher.data.value?.data?.result?.reward }} 票，</div>
          <div class="mb-4 text-[14px] lg:text-[20px]">立即為你喜歡的選手投票吧！</div>
          <MajorButton
          class="h-[43px] w-full max-w-[259px]"
          @click="()=>{
            props.close()
            router.push({
              path: '/voting'
            })
          }">
            <div class="flex items-center">
              前往投票 <i class="bi bi-chevron-double-right block text-[14px] leading-none"></i>
            </div>
          </MajorButton>
        </div>
      </div>

      <div class="text-center text-[12px] text-white">
        轉盤小遊戲每天僅能玩一次，次數與獲得之票數無法跨日累計。<br>
        轉盤小遊戲的開放時間為每天 00:00 至 23:55。
      </div>
    </div>
  </div>
</template>

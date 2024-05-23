<script lang="tsx" setup>
import { twMerge } from 'tailwind-merge'
import { useWindowScroll } from '@vueuse/core'
import Game from './Game.vue'
import { useStore } from '~/store'

function getScrollPosition(): number{
  const window = process.client ? globalThis : null
  if (!window){
    return 0
  }
  return (window.pageYOffset !== undefined)
    ? window.pageYOffset
    : (document.documentElement || document.body.parentNode || document.body).scrollTop
}

function getDocumentHeight(){
  const body = document.body
  const html = document.documentElement

  return Math.max(
    body.scrollHeight, body.offsetHeight,
    html.clientHeight, html.scrollHeight, html.offsetHeight
  )
}

function isScrolledPastHalfway(): boolean{
  const window = process.client ? globalThis : null
  if (!window){
    return false
  }
  const scrollPosition = getScrollPosition()
  const documentHeight = getDocumentHeight()
  const windowHeight = window.innerHeight

  return scrollPosition >= (documentHeight - windowHeight) / 2
}

const window = process.client ? globalThis : null

const props = defineProps({
  class: {
    type: String,
    default: '',
  },
})
const store = useStore()
// const state = reactive({
//   show: true
// })
const state = reactive({
  show: false,
  showGame: false,
})

onMounted(()=>{
  if (!window){
    return
  }
  window.addEventListener('scroll', function(){
    // if (isScrolledPastHalfway()){
    //   state.show = true
    // } else {
    //   state.show = false
    // }
    if (window.scrollY > 700){
      state.show = true
    } else {
      state.show = false
    }
  })
})

watch(()=>state.showGame, (newVal, oldVal)=>{
  if (!window){
    return
  }

  if (newVal){
    document.body.classList.add('show-game-page')
  } else {
    document.body.classList.remove('show-game-page')
  }
}, {
  immediate: true
})
</script>
<template>
  <ClientOnly>
    <Game
    v-if="state.showGame"
    :close="()=>{
      state.showGame = false
    }" />

    <div
    :class="twMerge(`z-[100] fixed right-5 top-1/2 -translate-y-1/2 mt-[80px] ${state.show ?'opacity-100' :'opacity-0 pointer-events-none'}`, props.class)"
    :style="{
      transition: 'all .4s',
      // marginBottom: store.isDownloadStickerShow ?'170px' :'0px'
    }">
      <div
      class="btn btn-scaleUp mb-3 flex size-[59px] flex-col items-center justify-center rounded-full lg:size-[72px]"
      style="background: linear-gradient(#5d00ff 0%, #2f0080 100%); box-shadow: 0px 0px 5px rgba(255, 255, 255, 0.5);"
      @click="()=>{
        state.showGame = true
      }">
        <img class="mx-auto mb-1 lg:mb-1.5 _lg:max-w-[22px]" src="/assets/img/icon_game.svg" alt="">
        <div class="text-center text-[11px] leading-[1.2] text-white lg:text-[14px]">小遊戲</div>
      </div>
      <div
      class="btn btn-scaleUp mb-3 flex size-[59px] flex-col items-center justify-center rounded-full lg:size-[72px]"
      style="background: linear-gradient(#fff 0%, #808080 100%); box-shadow: 0px 0px 5px rgba(255, 255, 255, 0.5);"
      @click="()=>{
        if( !window ){ return }
        window.scrollTo({
          top: 0,
          behavior: 'smooth'
        })
      }">
        <img class="mx-auto mb-1" src="/assets/img/icon_circle_top.svg" alt="">
        <div class="text-center text-[12px] leading-[1.2] lg:text-[14px]">TOP</div>
      </div>
      <div
      class="btn btn-scaleUp mb-3 flex size-[59px] flex-col items-center justify-center rounded-full lg:size-[72px]"
      style="background: linear-gradient(#fff 0%, #808080 100%); box-shadow: 0px 0px 5px rgba(255, 255, 255, 0.5);"
      @click="()=>{
        if( !window ){ return }
        window.scrollTo({
          top: 0,
          behavior: 'smooth'
        })
      }">
        <img class="mx-auto _lg:max-w-[26px]" src="/assets/img/icon_headphone.svg" alt="">
      </div>
    </div>
  </ClientOnly>
</template>

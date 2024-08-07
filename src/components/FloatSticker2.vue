<script lang="tsx" setup>
import { twMerge } from 'tailwind-merge'
import { useWindowScroll, useWindowSize } from '@vueuse/core'
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
const viewport = useWindowSize()

const props = defineProps({
  class: {
    type: String,
    default: '',
  },
})
const route = useRoute()
const store = useStore()
const state = reactive({
  show: false,
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

watch(()=>route.hash, (newVal, oldVal)=>{
  if (!window){
    return
  }

  if (['#game'].includes(route.hash)){
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
    v-if="store.general?.can_play_game === true && ['#game'].includes(route.hash)"
    :close="()=>{
      $router.push({
        hash: ''
      })
    }" />

    <div
    :class="twMerge(`z-[100] fixed lg:right-5 right-2 ${state.show ?'opacity-100' :'opacity-0 pointer-events-none'}`, props.class)"
    :style="{
      bottom: viewport.width.value<= 991 ?'130px' :'95px', // 沒有話 AI 的話 0px，有 AI 的話 130/95px
      transition: 'all .4s',
    }">
      <a
      v-for="(node, index) in store.general?.extra_float_btn || []"
      :key="index"
      class="btn btn-scaleUp mb-2 flex size-[60px] items-center justify-center overflow-hidden rounded-full bg-cover p-1.5"
      :href="node.href"
      :target="node?.href_target || '_self'"
      :style="{
        backgroundImage: `url(${node?.bg})`
      }"
      @click="()=>{
        store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click',{
          click_info: {
            type: 'must_do',
            name: node.text,
            url: node.href,
            sec: 'float'
          }
        })
      }">
        <div class="text-center text-[11px] leading-[1.2] text-white">{{ node.text }}</div>
      </a>

      <div
      v-if="store.general?.can_play_game === true"
      class="btn btn-scaleUp mb-2 flex size-[60px] flex-col items-center justify-center rounded-full"
      style="background: linear-gradient(#5d00ff 0%, #2f0080 100%); box-shadow: 0px 0px 5px rgba(255, 255, 255, 0.5);"
      @click="()=>{

        if( !store.user?.name ){
          store.do.lightboxOpen('NeedLogin')
        }else{
          $router.push({
            hash: '#game'
          })
        }

        store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
          click_info: {
            type: 'game'
          }
        })
      }">
        <img class="mx-auto mb-1 max-w-[22px]" src="/assets/img/icon_game.svg" alt="">
        <div class="text-center text-[11px] leading-[1.2] text-white">小遊戲</div>
      </div>
      <div
      class="btn btn-scaleUp mb-2 flex size-[60px] flex-col items-center justify-center rounded-full"
      style="background: linear-gradient(#fff 0%, #808080 100%); box-shadow: 0px 0px 5px rgba(255, 255, 255, 0.5);"
      @click="()=>{
        if( !window ){ return }
        window.scrollTo({
          top: 0,
          behavior: 'smooth'
        })
      }">
        <img class="mx-auto mb-1" src="/assets/img/icon_circle_top.svg" alt="">
        <div class="text-center text-[12px] leading-[1.2]">TOP</div>
      </div>
    </div>
  </ClientOnly>
</template>

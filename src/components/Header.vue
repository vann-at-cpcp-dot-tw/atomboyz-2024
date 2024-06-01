<script lang="tsx" setup>
import { useWindowSize } from '@vueuse/core'
import FloatSticker1 from './FloatSticker1.vue'
import FloatSticker2 from './FloatSticker2.vue'
import { copyUrlToClipboard } from '~/lib/helpers'
import LightboxList from '~/components/LightboxList.vue'
import { useStore } from '~/store'
const window = process.client ? globalThis : null
const config = useRuntimeConfig()
const LOGIN_URL = config.public.loginURL
const route = useRoute()
const store = useStore()
const viewport = useWindowSize()
const state = reactive({
  isShareNavOpen: false,
  isMobileMenuOpen: false,
})

const nav:{
  label: string
  names: string[]
  to?: string
  onClick?: Function
}[] = [
  {
    label: '首頁',
    names: ['index'],
    to: '/'
  },
  // {
  //   label: 'NEWS',
  //   names: ['posts-tab', 'post-id'],
  //   to: '/posts/video',
  // },
  {
    label: '我要投票',
    names: ['vote'],
    to: '/vote'
  },
  // {
  //   label: '排行榜',
  //   names: ['rank'],
  //   to: '/#RANK'
  // },
  // {
  //   label: '周邊商品',
  //   names: ['shop'],
  //   to: '/#SALE'
  // },
  // {
  //   label: '會員中心',
  //   names: ['member'],
  //   onClick: ()=>{

  //   }
  // }
]
watch(()=>state.isMobileMenuOpen, (newVal)=>{
  if (!window){
    return
  }
  if (newVal === true){
    document.body.classList.add('menu-open')
  } else {
    document.body.classList.remove('menu-open')
  }
}, {
  immediate: true
})
</script>
<template>
  <LightboxList />
  <FloatSticker1 />
  <FloatSticker2 />
  <header
  class="fixed left-0 top-0 flex w-full justify-end pb-5 lg:justify-center lg:pt-5"
  :style="{
    zIndex: viewport.width.value >= 992 ?'100' :state.isMobileMenuOpen ?'1000' :'100'
  }">
    <div class="container hidden justify-center lg:flex">
      <div class="mx-auto flex w-auto max-w-full items-center rounded-full px-5 py-1" style="background: rgba(255,255,255, 0.66); box-shadow: 13px 6px 10px rgba(0,0,0,0.44); height: 50px;">
        <div class="row">
          <div
          v-for="(node, index) in nav"
          :key="index"
          class="col-auto">
            <NuxtLink :to="node?.to">
              <div
              class="btn rounded-full py-1 text-center"
              :class="`${node.names.includes(route.name) ?'bg-major text-white min-w-[95px]' :'text-major btn-scaleUp'}`"
              @click="()=>{
                node?.onClick?.()
              }">
                {{ node.label }}
              </div>
            </NuxtLink>
          </div>
        </div>
      </div>
      <div class="flex">
        <div
        class="relative mr-4"
        @mouseenter="()=>{
          if( !window?.navigator?.canShare?.() ){
            state.isShareNavOpen = true
          }
        }"
        @mouseleave="()=>{
          state.isShareNavOpen = false
        }"
        @click="()=>{
          if( window?.navigator?.canShare?.() ){
            store.do.share()
          }
        }">
          <div class="py-1">
            <div
            class="btn btn-scaleUp flex size-[37px] items-center justify-center rounded-full bg-[#D3D5F6]"
            style="box-shadow: -2px 5px 8px #fff inset;"
            @click="()=>{
              state.isShareNavOpen = true
            }">
              <i class="bi bi-share-fill ml-[-2px] mt-px text-[18px] text-major-700"></i>
            </div>
          </div>
          <div v-show="state.isShareNavOpen" class="absolute left-0 top-full w-full rounded-full bg-[#D3D5F6] py-2" style="box-shadow: -2px 5px 8px #fff inset;">
            <div
            class="btn btn-scaleUp mx-auto mb-1.5 flex size-7 items-center justify-center rounded-full  bg-major-700 text-white"
            @click="()=>{
              copyUrlToClipboard()
            }">
              <i class="bi bi-link-45deg text-[21px]"></i>
            </div>
            <div
            class="btn btn-scaleUp mx-auto mb-1.5 size-7 rounded-full bg-white"
            @click="()=>{
              store.do.share(null, 'fb')
            }">
              <i class="bi bi-facebook block text-[28px] leading-none text-major-700"></i>
            </div>
            <div
            class="btn btn-scaleUp mx-auto flex size-7 items-center justify-center rounded-full bg-major-700 text-white"
            @click="()=>{
              store.do.share(null, 'line')
            }">
              <i class="bi bi-line relative mt-[3px] block text-[19px] leading-none text-white"></i>
            </div>
          </div>
        </div>
        <div class="flex flex-col items-center">
          <div
          class="btn flex flex-col"
          @click="()=>{
            if( !window ){ return }
            if( !store.user?.name ){
              window.location.href = LOGIN_URL
            }
          }">
            <div
            v-if="!store?.user?.avatar"
            class="btn btn-scaleUp mx-auto flex size-[37px] items-center justify-center rounded-full bg-major-700 py-2"
            style="box-shadow: -1px 1px 8px #fff inset;">
              <i class="bi bi-person-fill block text-[21px] leading-none text-white"></i>
            </div>
            <div
            v-else
            class="btn btn-scaleUp mx-auto flex size-[37px] rounded-full bg-cover"
            :style="{
              boxShadow: '-1px 1px 8px #fff inset',
              backgroundImage: `url(${store.user.avatar})`
            }">
              <i class="bi bi-person-fill block text-[21px] leading-none text-white"></i>
            </div>
            <div v-if="store.user?.name" class="-mb-4 mt-1 text-center text-[10px] text-white">
              <div class="text-center">{{ store.user.name }}</div>
              <div>擁有票數：{{ store.user.votes }}</div>
            </div>
            <div
            v-else
            class="-mb-4 mt-1 text-center text-[10px] text-white">
              登入 ｜ 註冊
            </div>
          </div>
        </div>
      </div>
    </div>

    <div
    v-show="!state.isMobileMenuOpen"
    class="btn flex size-[68px] items-center justify-center lg:hidden"
    style="border-radius: 0px 0px 0px 9px; background: linear-gradient(#0c1074 0%, #5d00ff 50%, #0c1074 100%);"
    @click="()=>{
      state.isMobileMenuOpen = true
    }">
      <img src="/assets/img/icon_menu.svg" alt="">
    </div>
    <div
    v-show="state.isMobileMenuOpen"
    class="fixed left-0 top-0 z-[1000] size-full overflow-hidden"
    :style="{
      height: '100%',
      maxHeight: `calc(100% - ${16+(store.bottomStickyHeight||0)}px)`
    }">
      <div
      v-show="state.isMobileMenuOpen"
      class="fixed left-0 top-0 z-10 flex h-[67px] w-full items-center justify-between px-4"
      style="background:#3A1DAC;">
        <img src="/assets/img/menu_logo_m.png" style="width:117px;">
      </div>
      <div
      class="absolute rounded-lg p-2.5"
      :style="{
        width: 'calc(100% - 32px)',
        left: '16px',
        top: 'calc(67px + 16px)',
        height: `calc(100% - 67px - 16px)`,
        background: `rgba(58,29,172,0.44)`,
        backdropFilter: 'blur(4px)',
      }">
        <div class="mb-2.5 flex justify-end">
          <div
          class="btn flex size-8 items-center justify-center rounded-full bg-[#3A1DAC]"
          @click="()=>{
            state.isMobileMenuOpen = false
          }">
            <i class="bi bi-x text-[32px] leading-none text-white"></i>
          </div>
        </div>
        <div class="flex size-full flex-col overflow-auto">
          <div class="px-5">
            <div
            v-for="(node, index) in nav"
            :key="index"
            class="w-full pb-3">
              <NuxtLink :to="node?.to">
                <div
                class="btn rounded-full py-3 text-center text-[20px]"
                :class="`${node.names.includes(route.name) ?'bg-major text-white min-w-[95px]' :'text-major bg-white'}`"
                @click="()=>{
                  node?.onClick?.()
                  state.isMobileMenuOpen = false
                }">
                  {{ node.label }}
                </div>
              </NuxtLink>
            </div>
          </div>
          <div class="mt-auto flex justify-center pb-12">
            <div class="px-1.5">
              <div
              class="flex size-[49px] items-center justify-center rounded-full"
              style="background: linear-gradient(#0c1074 0%, #5d00ff 100%);"
              @click="()=>{
                copyUrlToClipboard()
              }">
                <i class="bi bi-link-45deg pointer-events-none relative top-0.5 text-[36px] leading-none text-white"></i>
              </div>
            </div>
            <div class="px-1.5">
              <div
              class="flex size-[49px] items-center justify-center rounded-full"
              style="background: linear-gradient(#0c1074 0%, #5d00ff 100%);"
              @click="()=>{
                store.do.share()
              }">
                <i class="bi bi-share-fill pointer-events-none relative -left-0.5 text-[26px] leading-none text-white"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
</template>

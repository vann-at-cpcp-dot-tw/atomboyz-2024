<script lang="tsx" setup>
import FloatSticker1 from './FloatSticker1.vue'
import FloatSticker2 from './FloatSticker2.vue'
import { copyUrlToClipboard } from '~/lib/helpers'
import LightboxList from '~/components/LightboxList.vue'
import { useStore } from '~/store'

const nav = [
  {
    label: '首頁',
    names: ['index'],
    to: '/'
  },
  {
    label: 'NEWS',
    names: ['posts-tab', 'post-id'],
    to: '/posts/video',
  },
  {
    label: '我要投票',
    names: ['voting'],
    to: '/voting'
  },
  {
    label: '排行榜',
    names: ['rank'],
    to: '/#RANK'
  },
  {
    label: '周邊商品',
    names: ['shop'],
    to: '/#SALE'
  },
  {
    label: '會員中心',
    names: ['member'],
    onClick: ()=>{
      alert(1)
    }
  }
]

const route = useRoute()
const store = useStore()
const state = reactive({
  isShareNavOpen: false,
})
</script>
<template>
  <LightboxList />
  <FloatSticker1 />
  <FloatSticker2 />
  <header class="fixed left-0 top-0 z-[100] flex w-full justify-center pt-6">
    <div class="container flex justify-center">
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
      <div class="flex items-center">
        <div
        class="relative mr-4"
        @mouseenter="()=>{
          state.isShareNavOpen = true
        }"
        @mouseleave="()=>{
          state.isShareNavOpen = false
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
            <div class="btn btn-scaleUp mx-auto mb-1.5 size-7 rounded-full bg-white">
              <i class="bi bi-facebook block text-[28px] leading-none text-major-700"></i>
            </div>
            <div class="btn btn-scaleUp mx-auto flex size-7 items-center justify-center rounded-full bg-major-700 text-white">
              <i class="bi bi-line relative mt-[3px] block text-[19px] leading-none text-white"></i>
            </div>
          </div>
        </div>
        <div class="flex flex-col items-center">
          <div
          class="btn btn-scaleUp flex size-[37px] items-center justify-center rounded-full bg-major-700 py-2"
          style="box-shadow: -1px 1px 8px #fff inset;"
          @click="()=>{
            store.do.lightboxOpen('NeedLogin')
          }">
            <i class="bi bi-person-fill block text-[21px] leading-none text-white"></i>
          </div>
          <div v-if="store.user?.name" class="-mb-4 mt-1 text-[10px] text-white">
            <div class="text-center">{{ store.user.name }}</div>
            <div>擁有票數：{{ store.user.votes }}</div>
          </div>
          <div v-else class="-mb-4 mt-1 text-[10px] text-white">登入 ｜ 註冊</div>
        </div>
      </div>
    </div>
  </header>
</template>

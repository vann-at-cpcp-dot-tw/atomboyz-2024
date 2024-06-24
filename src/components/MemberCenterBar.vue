<script lang="tsx" setup>
import { twMerge } from 'tailwind-merge'
import { useStore } from '~/store'
const window = process.client ? globalThis : null
interface IProps {
  class?: string
  className?: string
}
const store = useStore()
const props = defineProps<IProps>()
const route = useRoute()
const pageIs = computed(()=>{
  switch (route.hash){
    case '#member':
    case '#task':
      return 'quests'
    case '#favourite':
      return 'favs'
    case '#voting_record':
      return 'logs'
  }
})

function trackingUserLogout(callback?:Function){
  if (!((window as any)?.webTrackingSDK)){
    setTimeout(()=>{
      trackingUserLogout()
    }, 1000)
    return
  }
  (window as any)?.webTrackingSDK?.status?.setLogout?.()
  callback?.()
}

</script>
<template>
  <div :class="twMerge('', props.class)">
    <div class="mb-4 flex justify-center">
      <div
      v-if="!store?.user?.avatar"
      class="flex size-[90px] items-center justify-center rounded-full bg-gray-400 lg:size-[102px]">
        <i class="bi bi-person-fill block text-[66px] leading-none text-white"></i>
      </div>
      <div
      v-else
      class="flex size-[90px] rounded-full bg-cover lg:size-[102px]"
      :style="{
        boxShadow: '-1px 1px 8px #fff inset',
        backgroundImage: `url(${store.user.avatar})`
      }">
        <i class="bi bi-person-fill block text-[21px] leading-none text-white"></i>
      </div>
    </div>
    <div class="mb-4">
      <div class="text-center text-[16px] lg:text-[18px]">用戶名：{{ store.user?.name }}</div>
      <div class="text-center text-[16px] lg:text-[18px]">擁有票數：{{ store.user?.votes }}</div>
    </div>
    <div class="row row-gap-2 justify-center">
      <div class="lg:col-12 col-auto shrink lg:mb-2">
        <div
        :class="`whitespace-nowrap lg:text-[16px] text-[13px] btn hover:bg-major-700 rounded-full bg-[#666464] px-3 py-1 lg:px-4 lg:py-2 text-center text-white ${ pageIs === 'quests' ?'bg-major' :'bg-[#666464]'}`"
        @click="()=>{
          $router.push({
            hash: '#task'
          })
        }">
          每日任務
        </div>
      </div>
      <div class="lg:col-12 col-auto shrink lg:mb-2">
        <div
        :class="`whitespace-nowrap lg:text-[16px] text-[13px] btn hover:bg-major-700 rounded-full px-3 py-1 lg:px-4 lg:py-2 text-center text-white ${ pageIs === 'favs' ?'bg-major' :'bg-[#666464]'}`"
        @click="()=>{
          $router.push({
            hash: '#favourite'
          })
        }">
          最愛少年
        </div>
      </div>
      <div class="lg:col-12 col-auto shrink lg:mb-2">
        <div
        :class="`whitespace-nowrap lg:text-[16px] text-[13px] btn hover:bg-major-700 rounded-full px-3 py-1 lg:px-4 lg:py-2 text-center text-white ${ pageIs === 'logs' ?'bg-major' :'bg-[#666464]'}`"
        @click="()=>{
          $router.push({
            hash: '#voting_record'
          })
        }">
          當日投票
        </div>
      </div>
      <div class="lg:col-12 col-auto shrink lg:mb-2">
        <div
        class="btn whitespace-nowrap rounded-full px-3 py-1 text-center text-[13px] lg:px-4 lg:py-2 lg:text-[16px]"
        style="box-shadow:inset 0px 0px 0px 2px #000;"
        @click="(e)=>{
          e.stopPropagation();
          if( !window ){
            return
          }
          window.localStorage.setItem('t', '')
          trackingUserLogout(()=>{
            (window as any).location.reload()
          })
        }">
          登出
        </div>
      </div>
    </div>
  </div>
</template>

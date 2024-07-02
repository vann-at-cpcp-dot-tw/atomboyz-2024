<script lang="tsx" setup>
import { twMerge } from 'tailwind-merge'
import { useStore } from '~/store'
const window = process.client ? globalThis : null
interface IProps {
  class?: string
  className?: string
}
const props = defineProps<IProps>()
const elRef = ref<any>(null)
const store = useStore()
const route = useRoute()
const state = reactive<any>({
  active: true,
  observer: null
})
watch(()=>elRef.value, (newVal)=>{
  if (newVal){
    state.observer = new ResizeObserver((entries)=>{
      entries.forEach((entry)=>{
        store.bottomStickyHeight = entry.contentRect.height
      })
    })
    state.observer.observe(newVal)
  }
}, {
  immediate: true
})
</script>
<template>
  <ClientOnly>
    <div
    :ref="(e)=>{
      elRef = e
    }"
    :class="twMerge('sticky z-[90] bottom-0 lg:hidden block', props.class)">
      <!-- <div
      v-show="state.active"
      class="block w-full bg-[#444444] text-white lg:hidden"
      @click="()=>{
        store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
          click_info: {
            type: 'cta',
            name: 'download',
            sec: 'bottom'
          }
        })
      }">
        <div class="container-fluid p-3 pt-4">
          <div class="row row-gap-3 flex-nowrap items-center">
            <div class="col-auto">
              <img class="rounded-lg" src="/assets/img/favicon.png" style="width:48px;">
            </div>
            <div class="col-12 shrink">
              <div class="text-[14px] text-white">下載 hidol 拉近你與idol的距離。</div>
              <div class="text-[12px] text-white opacity-80">無線樂趣，都在 hidol</div>
            </div>
            <div class="col-auto">
              <div class="rounded border border-major-100 px-2 py-1 text-major-100">下載</div>
            </div>
            <div class="relative -top-2 col-auto flex justify-center self-start">
              <div class="pl-3">
                <i
                class="btn bi bi-x-circle relative -ml-2 -mr-1 -mt-2 text-[18px] leading-none"
                @click="(e)=>{
                  e.stopPropagation()
                  state.active = false
                  // if( window ){
                  //   window.localStorage.setItem('show-download', '0')
                  // }
                }"></i>
              </div>
            </div>
          </div>
        </div>
      </div> -->

      <div
      class="flex h-[60px] w-full flex-nowrap text-white">
        <NuxtLink
        v-show="route.name !== 'vote'"
        to="/vote"
        class="flex h-full grow flex-nowrap items-center justify-center bg-[#5D00FF] px-2"
        @click="()=>{
          store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
            click_info: {
              type: 'must_do',
              name: 'direct_vote',
              sec: 'bottom'
            }
          })
        }">
          <img class="w-[30px]" src="/assets/img/icon_rocket.svg" style="filter:brightness(100);">
          <div class="pl-2 text-[20px]">我要投票</div>
        </NuxtLink>

        <div
        :class="`flex h-full grow flex-nowrap items-center justify-center ${route.name !== 'vote' ?'bg-[#1D1D1D]' :'bg-[#5D00FF]'}  px-2`"
        @click="()=>{
          store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
            click_info: {
              type: 'must_do',
              name: 'direct_mission',
              sec: 'bottom'
            }
          })

          if( !store.user?.name ){
            store.do.lightboxOpen('NeedLogin')
          }else{
            $router.push({
              hash: '#task'
            })
          }

        }">
          <img class="w-[24px]" src="/assets/img/icon_planet.svg" style="filter:brightness(100);">
          <div
          class="pl-2 text-[20px]">
            任務獎勵
          </div>
        </div>
      </div>
    </div>
  </ClientOnly>
</template>

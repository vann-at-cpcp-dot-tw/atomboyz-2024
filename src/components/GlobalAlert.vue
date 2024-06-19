<script lang="tsx" setup>
import { twMerge } from 'tailwind-merge'
import { useWindowSize } from '@vueuse/core'
import { calcSizeByRatio, isEmpty } from 'vanns-common-modules/dist/lib/helpers'
import { useStore } from '~/store'

const window = process.client ? globalThis : null
interface IProps {
  class?: string
  className?: string
}
const props = defineProps<IProps>()
const viewport = useWindowSize()
const store = useStore()
const route = useRoute()
const state = reactive({
  active: false,
  checked: false,
  contentSize: {
    w: 0,
    h: 0,
  }
})
const contentWrapper = ref<any>(null)
function getToday(){
  const date = new Date()
  const year = date.getFullYear()
  const month = String(date.getMonth() + 1).padStart(2, '0')
  const day = String(date.getDate()).padStart(2, '0')
  const today = `${year}${month}${day}`
  return today
}
watch(()=>[window, store.general?.global_alert], (newVal, oldVal)=>{
  if (!window){
    return
  }

  if (!store.general?.global_alert){
    return
  }

  const today = getToday()

  if (!localStorage.getItem('global-alert-locked-date')){
    state.active = true
    return
  }

  // 如果日期是在今天
  if (localStorage.getItem('global-alert-locked-date') && localStorage.getItem('global-alert-locked-date') === today){
    state.active = false
  } else { // 如果日期不是今天
    state.active = true
  }
}, {
  immediate: true
})

watch(()=>state.active, (newVal, oldVal)=>{
  if (!window){
    return
  }
  if (newVal){
    document.body.classList.add('show-global-alert')
  } else {
    document.body.classList.remove('show-global-alert')
  }
}, {
  immediate: true,
})

watch(()=>[state.active, store.trackingSender], (newVal)=>{
  if (newVal[0] && newVal[1]){
    store.do.tracking('PageViewEvent', '55001', 'hidol_campaign_page_view', {
      page_info: {
        type: 'ads_page'
      },
    })
  }
}, {
  immediate: true
})

watch(()=>[viewport.width.value, viewport.height.value, contentWrapper?.value], ()=>{
  if (!window || !contentWrapper?.value){
    return
  }
  let ratio = 0
  if (viewport.width.value >= 992){
    ratio = 1.53
  } else {
    ratio = 0.94
  }

  const widthBasedSize = calcSizeByRatio({ w: contentWrapper.value.clientWidth, h: null, ratio })
  const heightBasedSize = calcSizeByRatio({ w: null, h: contentWrapper.value.clientHeight, ratio })

  // 如果寬撐滿時高會超出，那就改成高撐滿模式
  if (widthBasedSize?.h && (widthBasedSize.h > contentWrapper.value.clientHeight)){
    state.contentSize = heightBasedSize || { w: 0, h: 0 }
  } else {
    state.contentSize = widthBasedSize || { w: 0, h: 0 }
  }
}, {
  immediate: true
})
</script>
<template>
  <ClientOnly>
    <div
    v-if="state.active"
    :class="twMerge('parent fixed size-full left-0 top-0 z-[2000] lg:px-8 py-8 px-3 overflow-auto', props.class)"
    style="background: rgba(0,0,0,0.8);"
    @click="(e)=>{
      if( (e?.target as HTMLDivElement)?.classList?.value?.includes?.('parent') ){
        if( !window ){
          return
        }
        state.active = false
        if( state.checked ){
          const today = getToday()
          window.localStorage.setItem('global-alert-locked-date', today)
        }
        store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
          page_info: {
            type: 'ads_page',
          },
          click_info: {
            type: 'close'
          }
        })
      }
    }">
      <div
      :ref="(e)=>{
        contentWrapper = e
      }"
      class="parent relative z-10 mx-auto flex size-full max-w-[1090px] justify-center">
        <div
        class="relative my-auto"
        :style="{
          width: `${state.contentSize.w}px`,
          height: `${state.contentSize.h}px`
        }">
          <img class="pointer-events-none absolute left-0 top-0 z-10 hidden size-full lg:block" src="/assets/img/img_frame_global_alert.svg" alt="">
          <img class="pointer-events-none absolute left-0 top-0 z-10 block size-full lg:hidden" src="/assets/img/img_frame_global_alert_m.svg" alt="">
          <div
          class="relative z-0 overflow-hidden rounded-lg bg-white pb-14 pt-10 lg:pt-16"
          :style="{
            width: '96.6%',
            height: '95%',
            left: '1.8%',
            top: '2.5%',
          }">
            <div class="absolute left-[-3%] top-[3%] z-10 flex w-full justify-end lg:left-[-2%] lg:top-[4%]">
              <i
              class="btn bi bi-x-circle text-[24px] leading-none lg:text-[38px]"
              @click="()=>{
                if( !window ){
                  return
                }
                state.active = false
                if( state.checked ){
                  const today = getToday()
                  window.localStorage.setItem('global-alert-locked-date', today)
                }
                store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
                  page_info: {
                    type: 'ads_page',
                  },
                  click_info: {
                    type: 'close'
                  }
                })
              }"></i>
            </div>
            <div class="relative size-full overflow-auto">
              <div class="relative px-4 lg:px-8">
                <div class="MCE-CONTENT relative mx-auto w-full max-w-[790px]" v-html="store.general?.global_alert"></div>
              </div>
            </div>
            <div class="absolute bottom-5 left-0 flex w-full justify-center">
              <label class="flex items-center">
                <input
                v-model="state.checked"
                type="checkbox"
                @change="{(e:any)=>{
                  if( e.target.checked ){
                    store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
                      page_info: {
                        type: 'ads_page'
                      },
                      click_info: {
                        type: 'hide_today'
                      }
                    })
                  }
                }}">
                <div class="pl-1">今日不再顯示</div>
              </label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </ClientOnly>
</template>

<script lang="tsx" setup>
import { twMerge } from 'tailwind-merge'
import { useStore } from '~/store'
const window = process.client ? globalThis : null
interface IProps {
  class?: string
  className?: string
}
const props = defineProps<IProps>()
const state = reactive({
  active: true,
})
// const state = reactive({
//   active: false,
// })
// const store = useStore()
// onMounted(()=>{
//   if (localStorage.getItem('show-download') === null || localStorage.getItem('show-download') === '1'){
//     state.active = true
//   }
// })
// watch(()=>state.active, ()=>{
//   store.isDownloadStickerShow = state.active
// }, {
//   immediate: true
// })
</script>
<template>
  <ClientOnly>
    <div
    v-if="state.active"
    :class="twMerge('relative z-[90] bottom-0 w-full bg-[#666464] text-white', props.class)">
      <div class="container-fluid py-10">
        <div class="mb-3 flex justify-center">
          <img class="mx-auto" :src="`/assets/img/btn_download.png`" style="max-width: 344px;">
          <!-- <i
          class="btn bi bi-x-circle relative left-[8px] top-[-24px] ml-auto self-end text-[38px] leading-none"
          @click="()=>{
            state.active = false
            if( window ){
              window.localStorage.setItem('show-download', '0')
            }
          }"></i> -->
        </div>
        <div class="text-center text-[18px]">
          下載 <b class="text-[#27D07D]">beanfun</b>！豐富你的內容發掘時事，最新娛樂消息不斷線
        </div>
      </div>
    </div>
  </ClientOnly>
</template>

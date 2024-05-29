<script lang="tsx" setup>
import { twMerge } from 'tailwind-merge'
import MajorButton from './MajorButton.vue'
const window = process.client ? globalThis : null
interface IProps {
  class?: string
  className?: string
}
const props = defineProps<IProps>()
const state = reactive({
  active: false,
})
onMounted(()=>{
  if (!window){
    return
  }

  if (localStorage.getItem('show-cookie') === null || localStorage.getItem('show-cookie') === '1'){
    state.active = true
  }
})

watch(()=>state.active, (newVal, oldVal)=>{
  if (!window){
    return
  }
  if (newVal){
    document.body.classList.add('show-cookie-alert')
  } else {
    document.body.classList.remove('show-cookie-alert')
  }
}, {
  immediate: true,
})
</script>
<template>
  <ClientOnly>
    <div v-if="state.active" class="fixed left-0 top-0 z-[3000] size-full" style="background:rgba(0,0,0,0.8);">
      <div
      :class="twMerge('fixed z-[1000] left-0 bottom-0 w-full p-5 lg:py-8', props.class)"
      style="background: rgba(255,255,255,0.7);">
        <div class="flex lg:flex-nowrap">
          <div class="ml-auto flex w-full max-w-[1100px] !flex-nowrap items-center">
            <div class="hidden flex-none lg:block">
              <i class="bi bi-file-earmark-text block text-[44px] leading-none"></i>
            </div>
            <div class="w-full max-w-[750px] shrink pr-4 lg:px-2">
              我們採用網站分析技術為您帶來更優質的使用體驗，若您點選<span class="text-major">「我同意」</span>或繼續瀏覽本網站，即表示您同意我們使用第三方 Cookie。
            </div>
            <div class="ml-auto flex-none">
              <MajorButton
              class="h-[43px] w-[80px] lg:w-[100px]"
              @click="()=>{
                state.active = false
                if( window ){
                  window.localStorage.setItem('show-cookie', '0')
                }
              }">
                <div style="white-space: nowrap;">我同意</div>
              </MajorButton>
            </div>
          </div>
          <i
          class="btn bi bi-x-circle relative left-[12px] order-first mb-[10px] ml-auto mt-[-10px] self-end text-[24px] leading-none lg:top-[-32px] lg:order-last lg:my-0 lg:text-[38px]"
          @click="()=>{
            state.active = false
          }"></i>
        </div>
      </div>
    </div>
  </ClientOnly>
</template>

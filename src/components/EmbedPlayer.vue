<script lang="tsx" setup>
import { twMerge } from 'tailwind-merge'
import RatioArea from 'vanns-common-modules/dist/components/vue/RatioArea'
import { convertYoutubeUrlToEmbed } from '~/lib/utils'
const window = process.client ? globalThis : null
interface IProps {
  class?: string
  className?: string
  embedURL: string
  onClose: Function,
}
const props = defineProps<IProps>()

onMounted(()=>{
  document.body.classList.add('embed-player-open')
})

onUnmounted(()=>{
  document.body.classList.remove('embed-player-open')
})
</script>
<template>
  <ClientOnly>
    <Teleport v-if="window" :to="window.document.body">
      <div :class="twMerge('fixed size-full left-0 top-0 z-[1000] p-5 flex flex-col justify-center items-center', props.class)">
        <div class="btn absolute size-full" style="background:rgba(0,0,0,0.85);" @click="()=>{ props?.onClose?.() }"></div>
        <div class="relative z-10 w-full max-w-screen-xl pb-12">
          <div class="mb-2 flex justify-end">
            <div class="btn flex size-[40px] items-center justify-center rounded-full bg-major">
              <i
              class="bi bi-x block text-[32px] leading-none text-white"
              @click="()=>{
                props?.onClose?.()
              }"></i>
            </div>
          </div>
          <RatioArea ratio="56.25">
            <iframe class="absolute left-0 top-0 size-full" :src="`${props.embedURL}?autoplay=1`" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"></iframe>
          </RatioArea>
        </div>
      </div>
    </Teleport>
  </ClientOnly>
</template>

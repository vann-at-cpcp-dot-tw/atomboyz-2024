<script lang="tsx" setup>
import { twMerge } from 'tailwind-merge'
import { useStore } from '~/store'
import { isEmpty } from '~/lib/helpers'
const window = process.client ? globalThis : null
interface IProps {
  id: string
  titleBg?: string
  title?: string
  icon?: string
  class?: string
  className?: string
  noClose?: boolean
  onClose?: Function
  onOpen?: Function
}
const props = defineProps<IProps>()
const store = useStore()
const handleClose = function(){
  if (props?.noClose){
    return
  }

  store.do.lightboxRemove(props.id)
  props?.onClose?.()
}
const myIndex = computed(()=>store.lightbox.findIndex(id=>id === props.id))

watch(()=>[window, store.lightbox], ()=>{
  if (!window){
    return
  }

  if (store.lightbox.length > 0){
    window.document.body.classList.add('lightbox-open')
  } else {
    window.document.body.classList.remove('lightbox-open')
  }
}, {
  immediate: true
})

watch(()=>[store.lightbox, props?.id, props?.onOpen], (newVal, oldVal)=>{
  const currentLightboxIds = (newVal?.[0] as string[]) || []
  const prevLightboxIds = (oldVal?.[0] as string[]) || []

  if (!prevLightboxIds?.includes?.(props?.id) && currentLightboxIds?.includes?.(props.id)){
    props?.onOpen?.()
  }
}, {
  immediate: true
})
</script>
<template>
  <Teleport to="body">
    <div
    v-if="store.lightbox.includes(props.id)"
    :class="twMerge('fixed w-full h-full left-0 top-0', props.class)"
    :style="{
      zIndex: 2000 + myIndex
    }">
      <div class="absolute left-0 top-0 flex size-full justify-center overflow-hidden p-5">
        <div
        :class="`${props?.noClose ?'' :'btn'} absolute left-0 top-0 z-0 size-full`"
        style="background:rgba(0,0,0,0.8);"
        @click="handleClose"></div>
        <div class="relative z-10 my-auto w-full max-w-[386px] overflow-hidden rounded-lg">
          <div
          class="flex !flex-nowrap items-center px-4 py-2 text-white"
          :style="{
            background: props?.titleBg || '#2B288E'
          }">
            <div class="flex shrink !flex-nowrap items-center">
              <i :class="`block text-[28px] flex-none bi bi-${props?.icon || 'exclamation-circle-fill'}`"></i>
              <div class="shrink pl-2 text-[20px]">{{ props?.title }}</div>
            </div>
            <i v-if="!props?.noClose" class="bi bi-x btn ml-auto block flex-none text-[34px] leading-none" @click="handleClose"></i>
          </div>
          <div class="bg-white p-5 lg:p-6"><slot></slot></div>
        </div>
      </div>
    </div>
  </Teleport>
</template>

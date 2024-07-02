<script lang="tsx" setup>
import { twMerge } from 'tailwind-merge'
import { scrollToSection2 } from '~/lib/helpers'
const window = process.client ? globalThis : null
interface IProps {
  id: string
  class?: string
  className?: string
  style?: Record<string, string>
}
const props = defineProps<IProps>()
const route = useRoute()
onMounted(()=>{
  if (!window){
    return
  }
  if (route.hash){
    setTimeout(()=>{
      scrollToSection2({ el: window.document.querySelector(route.hash), jump: true })
    }, 600)
  }
})
</script>
<template>
  <div :id="props.id" :class="twMerge('', props.class)" :style="props?.style"></div>
</template>

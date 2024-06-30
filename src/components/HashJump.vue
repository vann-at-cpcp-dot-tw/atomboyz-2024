<script lang="tsx" setup>
import { twMerge } from 'tailwind-merge'
import { scrollToSection2 } from '~/lib/helpers'
const window = process.client ? globalThis : null
interface IProps {
  class?: string
  className?: string
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
    }, 500)
  }
})
</script>
<template>
  <div></div>
</template>

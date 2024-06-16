<script lang="tsx" setup>
import { twMerge } from 'tailwind-merge'
import RatioArea from 'vanns-common-modules/dist/components/vue/RatioArea'
const config = useRuntimeConfig()
const APP_BASE = config.public.appBase
const props = defineProps({
  class: {
    type: String,
    default: '',
  },
  frame: {
    type: [String, Number],
    default: ''
  }
})
</script>
<template>
  <div :class="twMerge('relative', props.class)">
    <img class="pointer-events-none relative z-10 w-full" :src="`${APP_BASE}assets/img/img_frame_${props?.frame || 1}.svg`">
    <div class="absolute left-0 top-0 size-full">
      <slot></slot>
    </div>
  </div>
</template>

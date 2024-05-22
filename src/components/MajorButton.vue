<script lang="tsx" setup>
import { twMerge } from 'tailwind-merge'
const window = process.client ? globalThis : null
interface IProps {
  class?: string
  className?: string
  active?: boolean
  variant?: string
}
const props = defineProps<IProps>()
const classNames:Record<string, string> = {
  solid: 'bg-major',
  outline: 'border border-white',
}
const activeClassNames:Record<string, string> = {
  solid: '',
  outline: 'bg-major border-none'
}
</script>
<template>
  <div :class="twMerge(`btn flex py-2 px-4 w-full items-center justify-center rounded-full text-white  ${(classNames?.[props?.variant || 'solid'] as string)} ${props?.active ?activeClassNames?.[props?.variant || 'solid'] :''} ${`${props?.class} ${props?.className}`.includes('btn-') ?'' :'btn-scaleUp'}`, props?.class || props?.className)">
    <slot></slot>
  </div>
</template>

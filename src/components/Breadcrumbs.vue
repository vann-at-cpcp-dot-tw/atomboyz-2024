<script lang="tsx" setup>
import { twMerge } from 'tailwind-merge'
const window = process.client ? globalThis : null
interface IProps {
  class?: string
  className?: string
  list: {
    label: string
    href?: string
  }[]
}
const props = defineProps<IProps>()
</script>
<template>
  <div :class="twMerge('container-fluid', props.class)">
    <div class="text-white _lg:text-[12px]">
      <span
      v-for="(node, index) in props.list"
      :key="index"
      :class="`mb-2 ${node?.href ?'opacity-100' :'opacity-60'}`">
        <NuxtLink :to="node?.href">{{ node.label }}</NuxtLink>
        <i v-if="index+1 < list.length" class="bi bi-chevron-right mx-1 text-[12px] lg:text-[14px]"></i>
      </span>
    </div>
  </div>
</template>

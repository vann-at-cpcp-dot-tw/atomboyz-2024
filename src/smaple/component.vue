<script lang="tsx" setup>
import { twMerge } from 'tailwind-merge'
const window = process.client ? globalThis : null
interface IProps {
  class?: string
  className?: string
}
const props = defineProps<IProps>()
</script>
<template>
  <div :class="twMerge('', props.class)"></div>
</template>

<script lang="tsx" setup>
import { twMerge } from 'tailwind-merge'
import { useStore } from '~/store'

const window = process.client ? globalThis : null
interface IProps {
  class?: string
  className?: string
}
const props = defineProps<IProps>()
const store = useStore()
</script>
<template>
  <div :class="twMerge('', props.class)">
    <div
    v-for="(node, index) in store.user?.vote_logs"
    :key="index"
    class="mb-4">
      <div class="text-[12px]">姓名：{{ node?.name }}</div>
      <div class="text-[12px] text-[#5E5E5E]">時間：{{ node?.time }}</div>
      <div class="text-[12px] text-[#5E5E5E]">投票數：{{ node?.votes }}</div>
    </div>
  </div>
</template>

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
    <div class="mb-4 rounded bg-white p-2 text-center text-[12px] text-[#6B6B6B]">注意事項：每天00:00(GMT+8)每日任務將重新計算</div>
    <div
    v-for="(node, index) in store?.user?.daily_quests"
    :key="index"
    class="row row-gap-2 mb-2 flex-nowrap items-center">
      <div class="col-12 shrink">
        <div class="text-[14px]">{{ node.title }}</div>
        <div v-if="node?.reward" class="text-[12px] text-[#5E5E5E]">完成獎勵：+{{ node?.reward }}票</div>
        <div class="text-[12px] text-[#5E5E5E]">{{ node?.description }}</div>
      </div>
      <div class="col-auto">
        <div v-if="node?.is_done" class="pr-0.5 text-[12px]">已完成</div>
        <NuxtLink
        v-if="node?.href && !node?.is_done"
        :href="node?.href"
        class="btn btn-scaleUp block rounded-full bg-major px-3 py-2 text-[12px] text-white">
          前往破解任務
        </NuxtLink>
      </div>
    </div>
  </div>
</template>

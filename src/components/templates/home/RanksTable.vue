<script lang="tsx" setup>
import { twMerge } from 'tailwind-merge'
import { teams } from '~/lib/utils'
import { numberFormat } from '~/lib/helpers'
const window = process.client ? globalThis : null
const config = useRuntimeConfig()
const API_URL = config.public.apiURL

interface IProps {
  class?: string
  className?: string
}
const props = defineProps<IProps>()
const scopeStore:any = inject('scopeStore')

</script>
<template>
  <div :class="twMerge('relative bg-[#120c60]', props.class)">
    <div class="container mb-8">
      <div class="mb-8 flex justify-center">
        <img class="w-full" src="/assets/img/section_title_home_3.png" style="max-width:335px;">
      </div>
      <div class="row mb-10 items-center justify-center">
        <div
        v-for="(node, index) in scopeStore.rankTables"
        :key="index"
        class="col-3"
        style="max-width: 190px;">
          <MajorButton
          class="h-[50px] text-[21px]"
          variant="outline"
          :active="scopeStore.rankTableActive === node.key"
          @click="()=>{
            scopeStore.rankTableActive = node.key
          }">
            {{ node.label }}
          </MajorButton>
        </div>
      </div>
    </div>

    <div class="container text-white" style="max-width: 998px;">
      <RankStage :list="scopeStore.rankList" :type="scopeStore.rankTableActive" />
    </div>
    <div v-if="scopeStore.rankTableActive !== 'sale'" class="container pt-5 text-center text-[12px] text-white">※個人排行、團體排行與個人票數，為「即時至10分鐘內」更新</div>
  </div>
</template>

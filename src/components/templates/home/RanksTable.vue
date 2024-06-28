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
  <div id="RANK" :class="twMerge('relative bg-[#120c60]', props.class)">
    <div class="container mb-8">
      <div class="mb-8 flex justify-center">
        <img class="w-full max-w-[312px] lg:max-w-[335px]" src="/assets/img/section_title_home_3.png">
      </div>
      <div class="row lg:row-gap-5 row-gap-2 mb-10 items-center justify-center">
        <div
        v-for="(node, index) in scopeStore.rankTables"
        :key="index"
        :class="`col-3 ${node.display ?'block' :'hidden'}`"
        style="max-width: 190px;">
          <MajorButton
          class="h-[30px] p-0 text-[13px] lg:h-[50px] lg:text-[21px]"
          variant="outline"
          :active="scopeStore.rankTableActive === node.key"
          @click="()=>{
            scopeStore.rankTableActive = node.key
          }">
            <div>{{ node.label }}</div>
          </MajorButton>
        </div>
      </div>
    </div>

    <div class="container text-white" style="max-width: 998px;">
      <RankStage :list="scopeStore.rankList" :type="scopeStore.rankTableActive" />
    </div>
    <div v-if="scopeStore.rankTableActive !== 'sale'" class="container pt-2 text-center text-[12px] text-white lg:pt-5">※個人排行、團體排行與個人票數，為「即時至10分鐘內」更新</div>
  </div>
</template>

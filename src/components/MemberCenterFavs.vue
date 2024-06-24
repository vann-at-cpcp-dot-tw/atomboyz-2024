<script lang="tsx" setup>
import { twMerge } from 'tailwind-merge'
import RatioArea from 'vanns-common-modules/dist/components/vue/RatioArea'
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
    <div class="row row-gap-2">
      <div
      v-for="(node, index) in store.user?.fav_peoples"
      :key="index"
      class="lg:col-3 col-4 mb-2">
        <RatioArea ratio="100">
          <NuxtLink :href="`/vote?p=${node?.tag_id}`">
            <div
            class="absolute left-0 top-0 size-full bg-cover bg-top"
            :style="{
              backgroundImage: `url(${node?.img})`
            }">
            </div>
          </NuxtLink>
          <i
          class="bi btn btn-scaleUp bi-heart-fill absolute right-2 top-1.5 z-10 text-[19px] leading-none"
          :style="{
            color: store.user?.fav_peoples?.map((node:any)=>node.name).includes(node.name) ?'#EC4F7F' :'#555555'
          }"
          @click="(e)=>{
            e.stopPropagation()
            store.do.toggleFav(node.name)
          }"></i>
        </RatioArea>
      </div>
    </div>
  </div>
</template>

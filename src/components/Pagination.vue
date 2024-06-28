<script lang="tsx" setup>
import { twMerge } from 'tailwind-merge'
import RatioArea from 'vanns-common-modules/dist/components/vue/RatioArea'
import { isEmpty } from 'vanns-common-modules/dist/lib/helpers'

const window = process.client ? globalThis : null
interface IProps {
  class?: string
  className?: string
  total: number
  chunkSize: number
  current: number,
  perPage: number,
  onPageChange?: Function
}
const props = defineProps<IProps>()
const state = reactive({
  activeGroup: 0
})

// const chunkGroup = computed(()=>{
//   if (typeof props.total !== 'number' || typeof props.chunkSize !== 'number'){
//     return []
//   }
//   const array = [...Array(props.total)].map((node, index)=>index + 1)
//   const chunkedArray = []

//   for (let i = 0; i < array.length; i += props.chunkSize){
//     chunkedArray.push(array.slice(i, i + props.chunkSize))
//   }

//   return chunkedArray
// })
const chunkGroup = computed(()=>{
  if (typeof props.total !== 'number' || typeof props.chunkSize !== 'number' || typeof props.perPage !== 'number'){
    return []
  }

  const totalPages = Math.ceil(props.total / props.perPage)
  const array = [...Array(totalPages)].map((_, index)=>index + 1)

  const chunkedArray = []
  for (let i = 0; i < array.length; i += props.chunkSize){
    chunkedArray.push(array.slice(i, i + props.chunkSize))
  }

  return chunkedArray
})
watch(()=>[props.current, chunkGroup], (newVal)=>{
  state.activeGroup = chunkGroup.value.findIndex((groupNode)=>{
    return groupNode.findIndex(node=>node === props.current) >= 0
  })
}, {
  immediate: true
})
</script>
<template>
  <div :class="twMerge('container', props.class)">
    <div class="row lg:row-gap-5 row-gap-4 flex-nowrap items-center justify-center">
      <div v-if="chunkGroup?.[0]?.length > 1" class="col-auto">
        <div
        class="btn btn-dark flex items-center justify-center rounded-full bg-white px-2.5 py-2 text-black lg:px-5"
        @click="()=>{
          props?.onPageChange?.(1)
        }">
          最新一頁
        </div>
      </div>

      <div class="col-auto">
        <div
        :class="`btn ${isEmpty(chunkGroup[state.activeGroup-1]) ?'opacity-50 pointer-events-none' :''}`"
        @click="()=>{
          props?.onPageChange?.(chunkGroup[state.activeGroup-1][0])
        }">
          <img src="/assets/img/icon_arrow.svg" alt="" style="transform: rotateY(180deg); width:10px;">
        </div>
      </div>

      <div
      v-for="(groupNode, groupIndex) in chunkGroup"
      v-show="state.activeGroup === groupIndex"
      :key="groupIndex"
      class="col-auto shrink">
        <div class="row row-gap-3 flex-nowrap">
          <div
          v-for="(node, index) in groupNode"
          :key="`${groupIndex}-${index}`"
          class="col-auto shrink"
          :style="{
            // width: `${100/props.chunkSize}%`,
            width: '100vw',
            maxWidth: '46px'
          }">
            <RatioArea ratio="100">
              <div
              :class="`leading-none absolute left-0 top-0 flex size-full items-center btn justify-center rounded-full border border-white ${
                props.current === node ?'bg-white text-black' :'text-white bg-black'
              }`"
              @click="()=>{
                props?.onPageChange?.(node)
              }">
                {{ node }}
              </div>
            </RatioArea>
          </div>
        </div>
      </div>

      <div class="col-auto">
        <div
        :class="`btn ${isEmpty(chunkGroup[state.activeGroup+1]) ?'opacity-50 pointer-events-none' :''}`"
        @click="()=>{
          props?.onPageChange?.(chunkGroup[state.activeGroup+1][0])
        }">
          <img src="/assets/img/icon_arrow.svg" alt="" style="width:10px;">
        </div>
      </div>

      <div v-if="chunkGroup?.[0]?.length > 1" class="col-auto">
        <div
        class="btn btn-dark flex items-center justify-center rounded-full bg-white px-2.5 py-2 text-black lg:px-5"
        @click="()=>{
          props?.onPageChange?.(props.total)
        }">
          最後頁
        </div>
      </div>
    </div>
  </div>
</template>

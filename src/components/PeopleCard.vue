<script lang="tsx" setup>
import { twMerge } from 'tailwind-merge'
import { numberFormat } from 'vanns-common-modules/dist/lib/helpers'
import RatioArea from 'vanns-common-modules/dist/components/vue/RatioArea'
import EmbedPlayer from './EmbedPlayer.vue'
import { convertYoutubeUrlToEmbed } from '~/lib/utils'
import { useStore } from '~/store'
const window = process.client ? globalThis : null
interface IProps {
  class?: string
  className?: string
  img: string
  name: string
  votes: number
  team: number
  tag_id?: string,
  yt_url?: string
  hidoi_url?: string
  can_vote?: boolean
  description?: string
  onThumbClick?: Function
}
const props = defineProps<IProps>()
const store = useStore()
const state = reactive({
  open: '',
})
</script>
<template>
  <EmbedPlayer
  v-if="state.open"
  :embed-u-r-l="state.open"
  :on-close="()=>{
    state.open = ''
  }" />
  <div
  :id="`${props.tag_id}`"
  :class="twMerge('rounded-lg overflow-hidden', props.class)">
    <div
    class="btn group"
    @click="()=>{
      props?.onThumbClick?.()
    }">
      <RatioArea
      ratio="92.35">
        <div class="absolute left-0 top-0 z-0 size-full overflow-hidden">
          <div
          class="btn btn-light absolute left-1.5 top-1.5 z-10 flex size-[21px] items-center justify-center rounded-full bg-major text-white"
          @click="(e)=>{
            e.stopPropagation()
          }">
            <i class="bi bi-share-fill relative -left-0.5 text-[11px] leading-none"></i>
          </div>
          <i
          class="bi btn btn-scaleUp bi-heart-fill absolute right-2 top-1.5 z-10 text-[19px] leading-none"
          :style="{
            color: store.user?.fav_peoples?.map((node:any)=>node.name).includes(props?.name) ?'#EC4F7F' :'#555555'
          }"
          @click="(e)=>{
            e.stopPropagation()
            if( !store.user?.name ){
              return
            }
            store.do.toggleFav(props.name)
          }"></i>
          <div
          class="absolute left-0 top-0 size-full bg-cover bg-top"
          :style="{
            backgroundImage:`url(${props?.img})`,
            transition: 'all .8s'
          }"></div>
        </div>
      </RatioArea>
    </div>
    <div class="bg-[#2B288E] px-2 py-3">
      <div class="text-center">{{ name }}</div>
      <div class="mb-2 text-center text-[20px] font-bold">{{ numberFormat(props.votes) }} 票</div>
      <div class="row row-gap-2 items-center">
        <div class="col-4 flex">
          <div
          class="btn btn-light relative top-[2px]"
          @click="()=>{ state.open = convertYoutubeUrlToEmbed(props.yt_url || '')?.embedURL || '' }">
            <i class="bi bi-youtube block text-[31px] leading-none"></i>
          </div>
        </div>

        <div class="col-4 flex justify-center">
          <div class="btn btn-light relative left-1">
            <img src="/assets/img/icon_hidol.png" alt="" style="width:48px;">
          </div>
        </div>

        <div class="col-4 flex justify-end">
          <div
          class="btn btn-light flex size-6 items-center justify-center rounded-full bg-white"
          @click="()=>{
            props?.onThumbClick?.()
          }">
            <i class="bi bi-search text-[12px] leading-none text-major"></i>
          </div>
        </div>
      </div>

      <div class="mt-2">
        <div v-if="props?.can_vote === true" class="btn btn-light flex h-[29px] w-full items-center justify-center rounded-full bg-[#C3C1F9] text-[12px] text-[#0D116B]">投票</div>
        <div v-else class="pointer-events-none flex h-[29px] w-full items-center justify-center rounded-full bg-[#706E6E] text-[12px] text-white">未開放投票</div>
      </div>
    </div>
  </div>
</template>

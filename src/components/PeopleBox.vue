<script lang="tsx" setup>
import { twMerge } from 'tailwind-merge'
import RatioArea from 'vanns-common-modules/dist/components/vue/RatioArea'
import { teams, convertYoutubeUrlToEmbed } from '~/lib/utils'

const window = process.client ? globalThis : null
interface IProps {
  class?: string
  className?: string
  name: string
  yt_url: string
  votes: string
  description: string
  img: string
  team: number
}
const props = defineProps<IProps>()
const targetTeam = computed(()=>teams.find((node:any)=>node.id === props.team))
const embedURL = computed(()=>{
  const { cover, embedURL } = convertYoutubeUrlToEmbed(props?.yt_url) ?? {}
  return embedURL
})
</script>
<template>
  <div :class="twMerge('size-full fixed left-0 top-0 z-[2000] text-black', props.class)">
    <div class="btn absolute left-0 top-0 z-0 size-full" style="background: rgba(0,0,0,0.8);"></div>
    <div class="absolute left-0 top-0 flex size-full justify-center overflow-auto p-5">
      <div class="my-auto w-full max-w-[1063px] rounded-lg bg-white p-5 lg:p-8 lg:py-[64px]" style="border: solid 6px #D4D3D2;">
        <div class="relative -mb-5 flex justify-end lg:-top-8 lg:-mb-10">
          <i class="btn bi bi-x-circle text-[25px] leading-none lg:text-[45px]"></i>
        </div>
        <div class="lg:nowrap mx-auto flex w-full max-w-[926px]">
          <div class="lg:w-[37%] lg:pr-[22px]">
            <RatioArea ratio="124.78">
              <div
              class="absolute left-0 top-0 size-full rounded-lg bg-cover bg-top"
              :style="{
                backgroundImage: `url(${props.img})`
              }"></div>
            </RatioArea>
          </div>
          <div class="lg:w-[63%] lg:pl-[22px]">
            <div class="mb-2 flex flex-nowrap items-center">
              <div class="pr-2 text-[30px] font-600">{{ props?.name }}</div>
              <div v-if="targetTeam?.img" class="-mr-2">
                <img class="w-[65px]" :src="`${targetTeam?.img}`" alt="">
              </div>
              <div class="text-[20px]">{{ targetTeam?.name }}</div>
            </div>

            <div class="mb-4">
              <RatioArea ratio="56.25">
                <div class="absolute left-0 top-0 size-full overflow-hidden rounded-lg">
                  <iframe class="absolute left-0 top-0 size-full" :src="`${embedURL}`" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"></iframe>
                </div>
              </RatioArea>
            </div>

            <div class="text-[18px]" v-html="props?.description"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

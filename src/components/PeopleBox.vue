<script lang="tsx" setup>
import { twMerge } from 'tailwind-merge'
import RatioArea from 'vanns-common-modules/dist/components/vue/RatioArea'
import { numberFormat } from 'vanns-common-modules/dist/lib/helpers'
import MajorButton from './MajorButton.vue'
import { teams, convertYoutubeUrlToEmbed } from '~/lib/utils'
import { useStore } from '~/store'
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
const store = useStore()
const targetTeam = computed(()=>teams.find((node:any)=>node.id === props.team))
const embedURL = computed(()=>{
  const { cover, embedURL } = convertYoutubeUrlToEmbed(props?.yt_url) ?? {}
  return embedURL
})
const router = useRouter()
onMounted(()=>{
  if (!window){
    return
  }

  document.body.classList.add('show-peoplebox')
})
onUnmounted(()=>{
  if (!window){
    return
  }
  document.body.classList.remove('show-peoplebox')
})
</script>
<template>
  <div
  :class="twMerge('size-full fixed left-0 top-0 z-[2000] text-black parent', props.class)"
  @click="(e)=>{
    if( (e?.target as HTMLDivElement)?.classList?.value?.includes?.('parent') ){
      router.push({
        query: {}
      })
    }
  }">
    <div
    class="parent absolute left-0 top-0 flex size-full justify-center overflow-auto p-5"
    style="background: rgba(0,0,0,0.8);">
      <div class="relative z-10 my-auto w-full max-w-[1063px] rounded-lg bg-white p-5 lg:p-8 lg:py-[64px]" style="border: solid 6px #D4D3D2;">
        <div class="relative -top-2.5 left-2.5 flex justify-end lg:-top-8 lg:left-0 lg:-mb-10">
          <i
          class="btn bi bi-x-circle text-[25px] leading-none lg:text-[45px]"
          @click="()=>{
            router.push({
              query: {}
            })
          }"></i>
        </div>
        <div class="lg:nowrap mx-auto flex w-full max-w-[926px]">
          <div class="hidden w-[37.5%] pr-[22px] lg:block">
            <div class="mb-2">
              <RatioArea ratio="124.78">
                <div
                class="absolute left-0 top-0 size-full rounded-lg bg-cover bg-top"
                :style="{
                  backgroundImage: `url(${props.img})`
                }">
                  <div
                  class="btn btn-light absolute left-3 top-3 z-10 flex size-[31px] items-center justify-center rounded-full bg-major text-white"
                  @click="(e)=>{
                    e.stopPropagation()
                  }">
                    <i class="bi bi-share-fill relative text-[15px] leading-none"></i>
                  </div>
                  <i
                  class="bi btn btn-scaleUp bi-heart-fill absolute right-3 top-3 z-10 text-[31px] leading-none"
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
                </div>
              </RatioArea>
            </div>
            <div class="mb-5 text-center text-[24px]">總票數：<i class="text-[30px] font-700 text-major">{{ numberFormat(props?.votes) }}</i>&nbsp;票</div>
            <MajorButton class="h-[49px] text-[18px]">投票</MajorButton>
          </div>

          <div class="mb-5 flex w-full lg:hidden">
            <div class="w-3/5 pr-5">
              <RatioArea ratio="124.78">
                <div
                class="absolute left-0 top-0 size-full rounded-lg bg-cover bg-top"
                :style="{
                  backgroundImage: `url(${props.img})`
                }">
                  <div
                  class="btn btn-light absolute left-2 top-2 z-10 flex size-[21px] items-center justify-center rounded-full bg-major text-white"
                  @click="(e)=>{
                    e.stopPropagation()
                  }">
                    <i class="bi bi-share-fill relative -left-px text-[11px] leading-none"></i>
                  </div>
                  <i
                  class="bi btn btn-scaleUp bi-heart-fill absolute right-2 top-2 z-10 text-[21px] leading-none"
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
                </div>
              </RatioArea>
            </div>
            <div class="flex w-2/5 flex-col">
              <div class="mb-2">
                <div class="text-[24px] font-600">{{ props?.name }}</div>
              </div>
              <div class="flex !flex-nowrap items-center">
                <div v-if="targetTeam?.img" class="-ml-3">
                  <img class="w-[51px]" :src="`${targetTeam?.img}`" alt="">
                </div>
                <div class="text-[15px]">{{ targetTeam?.name }}</div>
              </div>
              <div class="mt-auto">
                <div class="text-[18px]">總票數：</div>
                <div><i class="text-right text-[22px] font-700 text-major">{{ numberFormat(props?.votes) }}</i>&nbsp;<span class="text-[18px]">票</span></div>
              </div>
            </div>

            <div class="my-5 flex w-full justify-center">
              <div class="flex flex-nowrap items-end border-b-2 border-major pb-2 text-[18px]">
                <img class="w-[29px] flex-none" src="/assets/img/icon_peoplebox_vote.svg" alt="">
                <div class="pl-2 text-[14px]">每日的首次分享可再獲得 <i class="text-[22px] font-700 text-major">1</i> 票</div>
              </div>
            </div>

            <MajorButton class="h-[41px]">投票</MajorButton>
          </div>

          <div class="flex flex-col lg:w-[62.5%] lg:pl-[22px]">
            <div class="-mt-4 mb-2 hidden !flex-nowrap items-center lg:flex">
              <div class="pr-2 text-[30px] font-600">{{ props?.name }}</div>
              <div v-if="targetTeam?.img" class="-mr-2">
                <img class="w-[65px]" :src="`${targetTeam?.img}`" alt="">
              </div>
              <div class="text-[20px]">{{ targetTeam?.name }}</div>
            </div>

            <div class="mb-2 lg:mb-4">
              <RatioArea ratio="56.25">
                <div class="absolute left-0 top-0 size-full overflow-hidden rounded-lg">
                  <iframe class="absolute left-0 top-0 size-full" :src="`${embedURL}`" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"></iframe>
                </div>
              </RatioArea>
            </div>
            <div class="text-[12px] lg:mb-4 lg:text-[18px]" v-html="props?.description"></div>

            <div class="mt-auto hidden lg:flex">
              <div class="flex flex-nowrap items-end border-b-2 border-major pb-2 text-[18px]">
                <img class="w-[40px] flex-none" src="/assets/img/icon_peoplebox_vote.svg" alt="">
                <div class="pl-2">每日的首次分享可再獲得 <i class="text-[22px] font-700 text-major">1</i> 票</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

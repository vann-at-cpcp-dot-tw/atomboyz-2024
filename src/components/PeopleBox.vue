<script lang="tsx" setup>
import { twMerge } from 'tailwind-merge'
import RatioArea from 'vanns-common-modules/dist/components/vue/RatioArea'
import { numberFormat } from 'vanns-common-modules/dist/lib/helpers'
import MajorButton from './MajorButton.vue'
import { teams, convertYoutubeUrlToEmbed } from '~/lib/utils'
import { useStore } from '~/store'
import { copyUrlToClipboard } from '~/lib/helpers'
const window = process.client ? globalThis : null
const config = useRuntimeConfig()
const APP_URL = config.public.appURL
interface IProps {
  class?: string
  className?: string
  name: string
  situation_key?: string | number
  tag_id: string
  yt_url: string
  can_vote: boolean
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
const state = reactive({
  isShareNavOpen: false
})
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
  :class="twMerge('size-full fixed left-0 top-0 z-[1000] text-black parent', props.class)"
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
                  @mouseenter="()=>{
                    state.isShareNavOpen = true
                  }"
                  @mouseleave="()=>{
                    state.isShareNavOpen = false
                  }">
                    <i class="bi bi-share-fill relative text-[15px] leading-none"></i>
                    <div v-if="state.isShareNavOpen" class="absolute left-0 top-full hidden w-full py-2 lg:block">
                      <div
                      class="btn btn-scaleUp mx-auto mb-1.5 flex size-7 items-center justify-center rounded-full  bg-major text-white"
                      @click="()=>{
                        copyUrlToClipboard(`${APP_URL}/vote?p=${props.tag_id}`)
                      }">
                        <i class="bi bi-link-45deg text-[21px]"></i>
                      </div>
                      <div
                      class="btn btn-scaleUp mx-auto mb-1.5 size-7 rounded-full bg-white"
                      @click="()=>{
                        store.do.share($route.name, {
                          url: `${APP_URL}/vote?p=${props.tag_id}`
                        }, 'fb')
                      }">
                        <i class="bi bi-facebook block text-[28px] leading-none text-major"></i>
                      </div>
                      <div
                      class="btn btn-scaleUp mx-auto flex size-7 items-center justify-center rounded-full bg-major text-white"
                      @click="()=>{
                        store.do.share($route.name, {
                          url: `${APP_URL}/vote?p=${props.tag_id}`
                        }, 'line')
                      }">
                        <i class="bi bi-line relative mt-[3px] block text-[19px] leading-none text-white"></i>
                      </div>
                    </div>
                  </div>
                  <i
                  class="bi btn btn-scaleUp bi-heart-fill absolute right-3 top-3 z-10 text-[31px] leading-none"
                  :style="{
                    color: store.user?.fav_peoples?.map((node:any)=>node.name).includes(props?.name) ?'#EC4F7F' :'#555555'
                  }"
                  @click="(e)=>{
                    e.stopPropagation()
                    store.do.toggleFav(props.name)
                  }"></i>
                </div>
              </RatioArea>
            </div>
            <div class="mb-5 text-center text-[24px]">總票數：<i class="text-[30px] font-700 text-major">{{ numberFormat(props?.votes) }}</i>&nbsp;票</div>
            <div
            v-if="store.do.isNotVoteDate()"
            class="flex h-[49px] w-full items-center justify-center rounded-full bg-[#706E6E] text-[18px] text-white">
              未開放投票
            </div>
            <MajorButton
            v-else-if="props?.can_vote === true"
            class="h-[49px] text-[18px]"
            @click="()=>{
              store.do.setUser(window?.localStorage?.getItem?.('t')).then(()=>{
                store.do.voteInput({
                  name: props.name
                })
              })

            }">
              投票
            </MajorButton>
            <div v-else class="pointer-events-none flex h-[49px] w-full items-center justify-center rounded-full bg-[#706E6E] text-[18px] text-white">未開放投票</div>
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
                    if( typeof window?.navigator?.share === 'function' ){
                      store.do.share($route.name, {
                        url: `${APP_URL}/vote?p=${props?.tag_id}`
                      })
                    }
                  }">
                    <i class="bi bi-share-fill relative text-[11px] leading-none"></i>
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
                <div v-if="targetTeam?.getImg?.()" class="-ml-3">
                  <img class="w-[51px]" :src="`${targetTeam?.getImg?.()}`" alt="">
                </div>
                <div class="text-[15px]">{{ targetTeam?.name }}</div>
              </div>
              <div class="mt-auto">
                <div class="text-[18px]">總票數：</div>
                <div><i class="text-right text-[22px] font-700 text-major">{{ numberFormat(props?.votes) }}</i>&nbsp;<span class="text-[18px]">票</span></div>
              </div>
            </div>
            <div class="mt-4 w-full">
              <div
              v-if="store.do.isNotVoteDate()"
              class="flex h-[41px] w-full items-center justify-center rounded-full bg-[#706E6E] text-[18px] text-white">
                未開放投票
              </div>
              <MajorButton
              v-else-if="props?.can_vote === true"
              class="h-[41px]"
              @click="()=>{
                store.do.setUser(window?.localStorage?.getItem?.('t')).then(()=>{
                  store.do.voteInput({
                    name: props.name
                  })
                })
              }">
                投票
              </MajorButton>
              <div v-else class="pointer-events-none flex h-[41px] w-full items-center justify-center rounded-full bg-[#706E6E] text-[18px] text-white">未開放投票</div>
            </div>
          </div>

          <div class="flex w-full flex-col lg:w-[62.5%] lg:pl-[22px]">
            <div class="-mt-4 mb-2 hidden !flex-nowrap items-center lg:flex">
              <div class="pr-2 text-[30px] font-600">{{ props?.name }}</div>
              <div v-if="targetTeam?.getImg?.()" class="-mr-2">
                <img class="w-[65px]" :src="`${targetTeam?.getImg?.()}`" alt="">
              </div>
              <div class="text-[20px]">{{ targetTeam?.name }}</div>
            </div>

            <div class="mb-2 lg:mb-4">
              <RatioArea
              v-if="embedURL"
              ratio="56.25">
                <div class="absolute left-0 top-0 size-full overflow-hidden rounded-lg">
                  <iframe class="absolute left-0 top-0 size-full" :src="`${embedURL}`" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"></iframe>
                </div>
              </RatioArea>
            </div>
            <div class="text-[12px] lg:mb-4 lg:text-[18px]" v-html="props?.description"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

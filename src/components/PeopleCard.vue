<script lang="tsx" setup>
import { twMerge } from 'tailwind-merge'
import { numberFormat } from 'vanns-common-modules/dist/lib/helpers'
import RatioArea from 'vanns-common-modules/dist/components/vue/RatioArea'
import { useWindowSize } from '@vueuse/core'
import EmbedPlayer from './EmbedPlayer.vue'
import { convertYoutubeUrlToEmbed } from '~/lib/utils'
import { useStore } from '~/store'
import { copyUrlToClipboard } from '~/lib/helpers'

const window = process.client ? globalThis : null
const config = useRuntimeConfig()
const APP_URL = config.public.appURL

interface IProps {
  class?: string
  className?: string
  img: string | null
  name: string
  votes: number
  team: number
  share_links?: {
    copy: string
    fb: string
    line: string
  }
  id?: string | number
  situation_key?: string | number
  tag_id?: string,
  yt_url?: string
  hidoi_url?: string
  can_vote?: boolean
  description?: string
  onThumbClick?: Function
}
const props = defineProps<IProps>()
const store = useStore()
const viewport = useWindowSize()
const state = reactive({
  open: '',
  isShareNavOpen: false
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
  :class="twMerge('rounded-lg overflow-hidden flex flex-col grow relative', props.class)">
    <div v-show="props.situation_key === 2" class="absolute left-0 top-0 z-10 size-full" style="background:rgba(0,0,0,0.5);"></div>
    <div
    class="btn group"
    @click="()=>{
      props?.onThumbClick?.()
      store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
        page_info: {
          type: 'voting_page',
          name: props.name,
        },
        click_info: {
          type: 'voting_function',
          name: 'intro'
        }
      })
    }">
      <RatioArea
      ratio="92.35">
        <div class="absolute left-0 top-0 z-0 size-full overflow-hidden">
          <div
          class="btn btn-light absolute left-1.5 top-1.5 z-10 flex size-[21px] items-center justify-center rounded-full bg-major text-white"
          @mouseenter="()=>{
            state.isShareNavOpen = true
            store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
              page_info: {
                type: 'voting_page',
                name: props.name,
              },
              click_info: {
                type: 'voting_function',
                name: 'share'
              }
            })
          }"
          @mouseleave="()=>{
            state.isShareNavOpen = false
          }"
          @click="(e)=>{
            e.stopPropagation()
            if( viewport.width.value <= 991){
              store.do.share($route.name, {
                url: props?.share_links?.copy
              })

              store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
                page_info: {
                  type: 'voting_page',
                  name: props.name,
                },
                click_info: {
                  type: 'voting_function',
                  name: 'share'
                }
              })
            }
          }">
            <i class="bi bi-share-fill relative text-[11px] leading-none"></i>
            <div v-if="state.isShareNavOpen" class="absolute left-0 top-full hidden w-full py-1 lg:block">
              <div
              class="btn btn-scaleUp mx-auto mb-1 flex size-[21px] items-center justify-center rounded-full  bg-major text-white"
              @click="(e)=>{
                copyUrlToClipboard(props?.share_links?.copy)
              }">
                <i class="bi bi-link-45deg text-[15px] leading-none"></i>
              </div>
              <div
              class="btn btn-scaleUp mx-auto mb-1 size-[21px] rounded-full bg-white"
              @click="()=>{
                store.do.share($route.name, {
                  url: props?.share_links?.fb
                }, 'fb')
              }">
                <i class="bi bi-facebook block text-[21px] leading-none text-major"></i>
              </div>
              <div
              class="btn btn-scaleUp mx-auto flex size-[21px] items-center justify-center rounded-full bg-major text-white"
              @click="()=>{
                store.do.share($route.name, {
                  url: props?.share_links?.line
                }, 'line')
              }">
                <i class="bi bi-line relative mt-[3px] block text-[12px] leading-none text-white"></i>
              </div>
            </div>
          </div>
          <i
          v-show="props.situation_key !== 2"
          class="bi btn btn-scaleUp bi-heart-fill absolute right-2 top-1.5 z-10 text-[19px] leading-none"
          :style="{
            color: store.user?.fav_peoples?.map((node:any)=>node.name).includes(props?.name) ?'#EC4F7F' :'#555555'
          }"
          @click="(e)=>{
            e.stopPropagation()
            store.do.toggleFav(props.name)
            if( store.user?.name ){
              store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
                page_info: {
                  type: 'voting_page',
                  name: props.name,
                },
                click_info: {
                  type: 'voting_function',
                  name: store.user?.fav_peoples?.map((node:any)=>node.name).includes(props?.name) ?'unfollow' :'follow'
                }
              })
            }
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
    <div :class="`flex grow flex-col ${props.situation_key === 2 ?'bg-[#333333]' :'bg-[#2B288E]'} px-2 py-3 relative`">
      <div class="text-center _lg:text-[12px]">{{ name }}</div>
      <div class="mb-2 text-center text-[14px] font-bold lg:text-[20px]">{{ numberFormat(props.votes) }} 票</div>
      <div class="row row-gap-0 lg:row-gap-2 mb-2 items-center justify-end">
        <div
        v-show="props?.yt_url"
        class="col-4 flex">
          <div
          class="btn btn-light relative top-[2px]"
          @click="()=>{
            state.open = convertYoutubeUrlToEmbed(props.yt_url || '')?.embedURL || ''
            store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
              page_info: {
                type: 'voting_page',
                name: props.name,
              },
              click_info: {
                type: 'voting_function',
                name: 'youtube'
              }
            })
          }">
            <i class="bi bi-youtube block text-[24px] leading-none lg:text-[31px]"></i>
          </div>
        </div>

        <div
        v-show="props?.hidoi_url"
        class="col-4 flex justify-center">
          <a
          class="btn btn-light relative left-1 w-[33px] lg:w-[48px]"
          :href="props?.hidoi_url"
          target="_blank"
          @click="()=>{
            store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
              page_info: {
                type: 'voting_page',
                name: props.name,
              },
              click_info: {
                type: 'voting_function',
                name: 'hidol'
              }
            })
          }">
            <img src="/assets/img/icon_hidol.png" alt="">
          </a>
        </div>

        <div class="col-4 flex justify-end">
          <div
          class="btn btn-light flex size-5 items-center justify-center rounded-full bg-white lg:size-6"
          @click="()=>{
            props?.onThumbClick?.()
            store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
              page_info: {
                type: 'voting_page',
                name: props.name,
              },
              click_info: {
                type: 'voting_function',
                name: 'intro'
              }
            })
          }">
            <i class="bi bi-search text-[12px] leading-none text-major"></i>
          </div>
        </div>
      </div>

      <div class="mt-auto">
        <div
        v-if="props.situation_key === 2"
        class="flex h-[29px] w-full items-center justify-center rounded-full bg-[#706E6E] text-[12px] text-white">
          已淘汰
        </div>
        <div
        v-else-if="store.do.isNotVoteDate()"
        class="flex h-[29px] w-full items-center justify-center rounded-full bg-[#706E6E] text-[12px] text-white">
          未開放投票
        </div>
        <div
        v-else-if="props?.can_vote === true"
        class="btn btn-light flex w-full items-center justify-center rounded-full bg-[#C3C1F9] py-2 text-[12px] leading-none text-[#0D116B]"
        @click="()=>{
          store.do.setUser(window?.localStorage?.getItem?.('t')).then(()=>{
            store.do.voteInput({
              name: props.name,
            })
            store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
              page_info: {
                type: 'voting_page',
                name: props.name,
              },
              click_info: {
                type: 'voting_function',
                name: 'vote'
              }
            })
          })
        }">
          投票
        </div>
        <div v-else class="pointer-events-none flex h-[29px] w-full items-center justify-center rounded-full bg-[#706E6E] text-[12px] text-white">未開放投票</div>
      </div>
    </div>
  </div>
</template>

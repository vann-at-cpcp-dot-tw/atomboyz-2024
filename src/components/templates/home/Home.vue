<script lang="tsx" setup>
import { provide } from 'vue'
import { useWindowSize } from '@vueuse/core'
import { useStore } from '~/store'
import KV from '~/components/templates/home/KV.vue'
import KVSwiper from '~/components/templates/home/KVSwiper.vue'
import VideoSwiper from '~/components/templates/home/VideoSwiper.vue'
import NewsSwiper from '~/components/templates/home/NewsSwiper.vue'
import SaleSwiper from '~/components/templates/home/SaleSwiper.vue'
import RanksTable from '~/components/templates/home/RanksTable.vue'
import Teams from '~/components/templates/home/Teams.vue'
import Terms from '~/components/templates/home/Terms.vue'
import { numberFormat } from '~/lib/helpers'
import ImgFrame from '~/components/ImgFrame.vue'
import MajorButton from '~/components/MajorButton.vue'
import { teams } from '~/lib/utils'
import 'swiper/css/effect-coverflow'

const config = useRuntimeConfig()
const APP_BASE = config.public.appBase
const API_URL = config.public.apiURL
const IS_STAGE = config.public.isStage
const store = useStore()
const viewport = useWindowSize()
const route = useRoute()
const state:any = reactive({
  rankTables: [
    { key: 'personal', label: '個人排行' },
    { key: 'team', label: '團體排行' },
    { key: 'social', label: '社團排行' },
    { key: 'sale', label: '銷售排行' },
  ],
  rankTableActive: 'personal',
  newsTableActive: 'videos',
  rankList: computed(()=>{
    switch (state.rankTableActive){
      case 'personal':
        return ranksFetcher.data.value?.data?.personal?.map((node:any)=>{
          return {
            ...node,
            href: `/vote?p=${node.tag_id}`
          }
        })
      case 'team':
        return ranksFetcher.data.value?.data?.team?.map((node:any)=>{
          const { id } = node
          const targetTeam = teams.find((teamNode:any)=>teamNode.id === id)
          return {
            img: targetTeam?.getImg?.(),
            name: targetTeam?.name,
            number: `<span><i>${numberFormat(node.votes)}</i> 票</span>`,
            href: `/vote#${targetTeam?.tagId}`,
            disabled: store?.general?.exclude_teams?.includes?.(id)
          }
        })

      case 'sale':
        return ranksFetcher.data.value?.data?.sale?.map((node:any)=>{
          return {
            ...node,
            number: node.price_string
          }
        })

      default:
        return ranksFetcher.data.value?.data?.[state.rankTableActive]?.map((node:any)=>{
          return {
            ...node,
            number: `<span><i>${numberFormat(node.votes)}</i> 票</span>`
          }
        })
    }
  }),
})
const ranksFetcher:{[key:string]:any} = await useFetch(`${API_URL}/rank`)
const videosFetcher = await useAsyncData<any>('video', ()=>{
  return $fetch(`${API_URL}/video`, {
    params: {
      page: 1,
      per_page: 9,
    }
  })
})
const newsFetcher = await useAsyncData<any>('news', ()=>{
  return $fetch(`${API_URL}/news`, {
    params: {
      page: 1,
      per_page: 9,
    }
  })
}, {
  // immediate: false,
})
const saleFetcher = await useAsyncData<any>('sale', ()=>{
  return $fetch(`${API_URL}/sale`)
})

provide('scopeStore', state)

const isTrackingInit = ref(false)
watch(()=>[isTrackingInit, store.trackingSender], (newVal)=>{
  if (!isTrackingInit.value && store.trackingSender){
    store.do.tracking('PageViewEvent', '55001', 'hidol_campaign_page_view')
  }
}, {
  immediate: true
})
</script>
<template>
  <main class="relative bg-[#0e160b]">
    <div
    class="w-full overflow-hidden bg-no-repeat pt-8 lg:pt-[176px]"
    :style="{
      backgroundImage: viewport.width.value >= 992 ?`url(${APP_BASE}assets/img/bg_home_1.jpg)` :`url(${APP_BASE}assets/img/bg_home_1_m.jpg)`,
      backgroundSize: viewport.width.value >= 992 ?'1920px auto' :'100% auto',
      backgroundPosition: 'center top',
    }">
      <KV />

      <KVSwiper class="pb-2" :list="store.general?.home_carousel" />

      <div class="divider relative z-10 mb-[-66px] h-[147px] lg:mb-[-133px] lg:h-[294px]" style="background: linear-gradient(#0e160b 0%, #000 100%);">
        <div class="container flex justify-center">
          <img class="animate__slideOutDown animate__animated animate__infinite w-[19px] lg:w-[27px]" src="/assets/img/icon_mouse_wheel.svg">
        </div>
      </div>

      <!-- <div
      class="relative bg-black pb-[130px]"
      :style="{
        backgroundImage: `url(${APP_BASE}assets/img/bg_star_1.png)`
      }">
        <div class="container-fluid relative z-10 mb-[54px]">
          <div class="mb-5 flex justify-center">
            <img class="w-full" src="/assets/img/section_title_home_1.png" style="max-width:298px;">
          </div>
          <div class="mx-auto w-full max-w-[1083px]">
            <ImgFrame>
              <img
              class="absolute size-full rounded-lg"
              :src="`${APP_BASE}assets/img/team_big_${String(store.general?.rank_summary?.team_champion)}.jpg`"
              :style="{
                left: '2%',
                top: '3.5%',
                width: '96%',
                height: '87.5%',3
              }">
            </ImgFrame>
          </div>
        </div>

        <div class="container-fluid relative z-10">
          <div class="mb-5 flex justify-center">
            <img class="w-full" src="/assets/img/section_title_home_2.png" style="max-width:274px;">
          </div>
          <div class="mx-auto w-full max-w-[1083px]">
            <ImgFrame>
              <img
              class="absolute size-full rounded-lg"
              :src="`${APP_BASE}assets/img/team_big_${String(store.general?.rank_summary?.team_popular)}.jpg`"
              :style="{
                left: '2%',
                top: '3.5%',
                width: '96%',
                height: '87.5%',
              }">
            </ImgFrame>
          </div>
        </div>
      </div> -->

      <div class="divider relative z-20 mt-[-65px] h-[65px] w-full lg:mt-[-130px] lg:h-[130px]" style="background-image:linear-gradient(rgba(0,0,0,0) 0%, #120c60 100%);"></div>

      <RanksTable class="pb-8 pt-16" />

      <!-- <div class="relative z-10 bg-black py-8" style="background: linear-gradient(#120c60 0%, #000 20%);">
        <div
        class="relative"
        :style="{
          backgroundImage: `url(${APP_BASE}assets/img/bg_star_1.png)`,
          backgroundRepeat: `repeat-x`,
          backgroundPosition: `center 200px`,
        }">
          <div class="container mb-8">
            <img class="mx-auto mb-2" src="/assets/img/section_title_home_4.png" style="max-width:337px;">
            <div class="mx-auto w-full max-w-[360px]">
              <div class="row">
                <div class="col-6">
                  <MajorButton
                  class="h-[50px] text-[21px]"
                  variant="outline"
                  :active="state.newsTableActive === 'videos'"
                  @click="()=>{ state.newsTableActive = 'videos' }">
                    最新影音
                  </MajorButton>
                </div>
                <div class="col-6">
                  <MajorButton
                  class="h-[50px] text-[21px]"
                  variant="outline"
                  :active="state.newsTableActive === 'news'"
                  @click="()=>{
                    state.newsTableActive = 'news'
                    if( !newsFetcher.data.value ){
                      newsFetcher.execute()
                    }
                  }">
                    最新娛樂
                  </MajorButton>
                </div>
              </div>
            </div>
          </div>
          <div class="mb-[50px]">
            <VideoSwiper v-if="state.newsTableActive === 'videos' && videosFetcher.data.value?.data?.list" :list="videosFetcher.data.value?.data?.list" />
            <NewsSwiper v-if="state.newsTableActive === 'news' && newsFetcher.data.value?.data?.list" :list="newsFetcher.data.value?.data?.list" />
          </div>

          <div class="pb-4">
            <img class="mx-auto mb-4" src="/assets/img/section_title_home_5.png" style="max-width:335px;">
            <SaleSwiper :list="saleFetcher.data.value?.data?.list" />
          </div>
        </div>
      </div> -->

      <!-- <div class="divider relative" style="height:120px; background: linear-gradient(black 0%, #120c60 100%);"></div> -->

      <Teams class="relative z-10 py-8 lg:pb-[336px]" />

      <Terms class="relative z-20 lg:mt-[-200px]" />

      <div class="divider relative mb-[-93px] h-[143px] lg:mb-[-187px] lg:h-[287px]" style="background: linear-gradient(#120c60 0%, black 100%);"></div>

      <!-- <div class="bg-black pb-[60px]">
        <div class="container-fluid">
          <div class="mx-auto w-full max-w-[1320px]">
            <ImgFrame frame="2">
              <a class="absolute size-full rounded-lg" :href="IS_STAGE ?'https://hidol.fan/5e7WK' :'https://hidol.fan/mcVjO'" target="_blank">
                <img
                class="absolute size-full rounded-lg"
                src="/assets/img/hidol-preheat-section.png"
                :style="{
                  left: '2%',
                  top: '3.5%',
                  width: '96%',
                  height: '87.5%',
                }">
              </a>
            </ImgFrame>
          </div>
        </div>
      </div> -->
    </div>
  </main>
</template>

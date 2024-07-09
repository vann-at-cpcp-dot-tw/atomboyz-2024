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
import HashJump from '~/components/HashJump.vue'
import { teams } from '~/lib/utils'
import 'swiper/css/effect-coverflow'

const config = useRuntimeConfig()
const APP_BASE = config.public.appBase
const API_URL = config.public.apiURL
const IS_STAGE = config.public.isStage
const store = useStore()
const viewport = useWindowSize()
const route = useRoute()

const videosFetcher = await useFetch<any>(`${API_URL}/video`, {
  query: {
    page: 1,
    per_page: 9,
  }
})

const newsFetcher = await useFetch<any>(`${API_URL}/news`, {
  query: {
    page: 1,
    per_page: 9,
  }
})

const state:any = reactive({

  rankTables: computed(()=>{
    return [
      { key: 'personal', label: '個人排行', hash: '#ranking_boyz', display: store?.rank?.personal?.length > 0 },
      { key: 'team', label: '團體排行', hash: '#ranking_group', display: store?.rank?.team?.length > 0 },
      { key: 'social', label: '社團排行', hash: '#ranking_club', display: store?.rank?.social?.length > 0 },
      { key: 'sale', label: '銷售排行', hash: '#ranking_sale', display: store?.rank?.sale?.length > 0 },
    ]
  }),
  rankTableActive: 'personal',
  newsTableActive: 'video',
  rankList: computed(()=>{
    switch (state.rankTableActive){
      case 'personal':
        return store?.rank?.personal?.map?.((node:any)=>{
          return {
            ...node,
            href: `/vote?p=${node.tag_id}`,
            number: `<span><i>${numberFormat(Number(node.votes))}</i> 票</span>`,
          }
        })
      case 'team':
        return store?.rank?.team?.map?.((node:any)=>{
          const { id } = node
          const targetTeam = teams.find((teamNode:any)=>teamNode.id === id)
          return {
            img: targetTeam?.getImg?.(),
            name: targetTeam?.name,
            number: `<span><i>${numberFormat(Number(node.votes))}</i> 票</span>`,
            href: `/vote#${targetTeam?.tagId}`,
            disabled: store?.general?.exclude_teams?.includes?.(id)
          }
        })
      case 'sale':
        return store?.rank?.sale?.map?.((node:any)=>{
          return {
            ...node,
            number: node.price_string
          }
        })

      default:
        // @ts-ignore
        return store?.rank?.[state.rankTableActive]?.map?.((node:any)=>{
          return {
            ...node,
            number: `<span><i>${numberFormat(Number(node.votes))}</i> 票</span>`
          }
        })
    }
  }),
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

watch(()=>state.rankTables, ()=>{
  const displayKey = state.rankTables?.find?.((node:any)=>node.display === true)?.key
  state.rankTableActive = displayKey || 'personal'
}, {
  immediate: true
})

watch(()=>[videosFetcher.data.value?.data?.list?.length, newsFetcher.data.value?.data?.list?.length], ()=>{
  if (videosFetcher.data.value?.data?.list?.length > 0 && route.hash !== '#article'){
    state.newsTableActive = 'video'
    return
  }

  if (newsFetcher.data.value?.data?.list?.length > 0 && route.hash !== '#video'){
    state.newsTableActive = 'article'
  }
}, {
  immediate: true
})

onMounted(()=>{
  if (!window){
    return
  }

  // if has hash
  setTimeout(()=>{
    if (route.hash){
      const rankHash = state.rankTables?.find?.((node:any)=>node.hash === route.hash)
      if (rankHash){
        state.rankTableActive = rankHash?.key
        return
      }

      if (route.hash === '#video'){
        state.newsTableActive = 'video'
        return
      }

      if (route.hash === '#article'){
        state.newsTableActive = 'article'
      }
    }
  }, 500)
})
</script>
<template>
  <main class="relative bg-[#0e160b]">
    <div
    class="w-full overflow-hidden bg-no-repeat pt-8 lg:pt-[176px]"
    :style="{
      backgroundImage: viewport.width.value >= 992 ?`url(${store?.general?.home_kv_banner || `${APP_BASE}assets/img/bg_home_1.jpg`})` :`url(${store?.general?.home_kv_banner_m || `${APP_BASE}assets/img/bg_home_1_m.jpg`})`,
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

      <div
      class="relative bg-black pb-[130px]"
      :style="{
        backgroundImage: `url(${APP_BASE}assets/img/bg_star_1.png)`
      }">
        <div
        v-if="store.general?.rank_summary?.team_champion"
        class="container-fluid relative z-10 mb-[54px]">
          <ClientOnly>
            <HashJump id="champion" class="anchor relative top-[-80px]" />
          </ClientOnly>
          <!-- <div class="mb-5 flex justify-center">
            <img class="w-full max-w-[279px] lg:max-w-[298px]" src="/assets/img/section_title_home_1.png">
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
                height: '87.5%',
              }">
            </ImgFrame>
          </div> -->
        </div>

        <div
        v-if="store.general?.rank_summary?.team_popular"
        class="container-fluid relative z-10">
          <ClientOnly>
            <HashJump id="popular" class="anchor relative top-[-80px]" />
          </ClientOnly>
          <!-- <div class="mb-5 flex justify-center">
            <img class="w-full max-w-[248px] lg:max-w-[274px]" src="/assets/img/section_title_home_2.png">
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
          </div> -->
        </div>
      </div>

      <div class="divider relative z-20 mt-[-65px] h-[65px] w-full lg:mt-[-130px] lg:h-[130px]" style="background-image:linear-gradient(rgba(0,0,0,0) 0%, #120c60 100%);"></div>

      <div
      v-if="state.rankTables?.some?.((node:any)=>node.display === true)"
      class="relative">
        <ClientOnly><HashJump id="ranking" class="anchor relative top-[-80px]" /></ClientOnly>
        <ClientOnly><HashJump id="ranking_boyz" class="anchor relative top-[-80px]" /></ClientOnly>
        <ClientOnly><HashJump id="ranking_group" class="anchor relative top-[-80px]" /></ClientOnly>
        <ClientOnly><HashJump id="ranking_club" class="anchor relative top-[-80px]" /></ClientOnly>
        <ClientOnly><HashJump id="ranking_sale" class="anchor relative top-[-80px]" /></ClientOnly>
        <RanksTable class="pb-8 pt-16" />
      </div>

      <div
      class="relative z-10 bg-black py-8"
      style="background: linear-gradient(#120c60 0%, #000 20%);">
        <div
        class="relative"
        :style="{
          backgroundImage: `url(${APP_BASE}assets/img/bg_star_1.png)`,
          backgroundRepeat: `repeat-x`,
          backgroundPosition: `center 200px`,
        }">
          <div v-if="videosFetcher.data.value?.data?.list?.length > 0 || newsFetcher.data.value?.data?.list?.length > 0">
            <div class="container mb-8">
              <ClientOnly><HashJump id="video" class="anchor relative top-[-80px]" /></ClientOnly>
              <ClientOnly><HashJump id="article" class="anchor relative top-[-80px]" /></ClientOnly>
              <img class="mx-auto mb-2 max-w-[319px] lg:max-w-[337px]" src="/assets/img/section_title_home_4.png" style="max-width:337px;">
              <div class="mx-auto w-full max-w-[360px]">
                <div class="row justify-center">
                  <div v-if="videosFetcher.data.value?.data?.list?.length > 0" class="col-6">
                    <MajorButton
                    class="h-[44px] lg:h-[50px] lg:text-[21px]"
                    variant="outline"
                    :active="state.newsTableActive === 'video'"
                    @click="()=>{
                      state.newsTableActive = 'video'
                      store.do.tracking('ClickEvent', '55003', 'hidol_campaign_function_click', {
                        page_info: {
                          sec: 'atomboyz_news',
                        },
                        click_info: {
                          type: 'page_function',
                          name: 'videos',
                        }
                      })
                    }">
                      最新影音
                    </MajorButton>
                  </div>
                  <div v-if="newsFetcher.data.value?.data?.list?.length > 0" class="col-6">
                    <MajorButton
                    class="h-[44px] lg:h-[50px] lg:text-[21px]"
                    variant="outline"
                    :active="state.newsTableActive === 'article'"
                    @click="()=>{
                      state.newsTableActive = 'article'
                      store.do.tracking('ClickEvent', '55003', 'hidol_campaign_function_click', {
                        page_info: {
                          sec: 'atomboyz_news',
                        },
                        click_info: {
                          type: 'page_function',
                          name: 'news',
                        }
                      })
                    }">
                      最新娛樂
                    </MajorButton>
                  </div>
                </div>
              </div>
            </div>
            <div class="mb-[50px]">
              <VideoSwiper v-if="state.newsTableActive === 'video' && videosFetcher.data.value?.data?.list" :list="videosFetcher.data.value?.data?.list" />
              <NewsSwiper v-if="state.newsTableActive === 'article' && newsFetcher.data.value?.data?.list" :list="newsFetcher.data.value?.data?.list" />
            </div>
          </div>

          <div v-if="store?.sale?.list?.length > 0" class="pb-4">
            <ClientOnly>
              <HashJump id="merch" class="anchor relative top-[-80px]" />
            </ClientOnly>
            <img class="mx-auto mb-4 max-w-[318px] lg:max-w-[335px]" src="/assets/img/section_title_home_5.png">
            <SaleSwiper :list="store?.sale?.list" />
          </div>
        </div>
      </div>

      <div class="divider relative h-[60px] lg:h-[120px]" style="background: linear-gradient(black 0%, #120c60 100%);"></div>

      <Teams class="relative z-10 py-8 lg:pb-[336px]" />

      <Terms class="relative z-20 lg:mt-[-200px]" />

      <div class="divider relative mb-[-93px] h-[143px] lg:mb-[-187px] lg:h-[287px]" style="background: linear-gradient(#120c60 0%, black 100%);"></div>

      <div class="bg-black pb-[60px]">
        <ClientOnly>
          <HashJump id="hidol" class="anchor relative top-[-80px]" />
        </ClientOnly>
        <div class="container-fluid">
          <div class="mx-auto w-full max-w-[1320px]">
            <ImgFrame frame="2">
              <a class="absolute size-full rounded-lg" :href="IS_STAGE ?'https://hidol.fan/mcVjO' :'https://hidol.fan/mcVjO'" target="_blank">

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
      </div>
    </div>
  </main>
</template>

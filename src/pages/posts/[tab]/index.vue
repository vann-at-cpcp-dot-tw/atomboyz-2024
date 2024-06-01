<script lang="tsx" setup>
import RatioArea from 'vanns-common-modules/dist/components/vue/RatioArea'
import { useWindowSize } from '@vueuse/core'
import Breadcrumbs from '~/components/Breadcrumbs.vue'
import MajorButton from '~/components/MajorButton.vue'
import { convertYoutubeUrlToEmbed } from '~/lib/utils'
import Pagination from '~/components/Pagination.vue'

const config = useRuntimeConfig()
const API_URL = config.public.apiURL
const viewport = useWindowSize()
const route = useRoute()
const router = useRouter()
const tab = route.params.tab
const listFetcher = await useFetch<any>(`${API_URL}/${tab}`, {
  query: {
    page: computed(()=>route.query.page || 1),
    per_page: 3,
  }
})
const state = reactive({
  open: ''
})
</script>
<template>
  <main>
    <EmbedPlayer
    v-if="state.open"
    :embed-u-r-l="state.open"
    :on-close="()=>{
      state.open = ''
    }" />

    <Breadcrumbs :list="[{label: '首頁', href: '/'}, {label: 'News'}]" />

    <div class="container mb-5 flex justify-center">
      <img class="w-[124px] lg:w-[158px]" src="/assets/img/page_title_news.png">
    </div>

    <div class="container mb-6">
      <div class="row justify-center">
        <div class="col-6" style="max-width:190px;">
          <NuxtLink to="/posts/video">
            <MajorButton class="h-[44px] lg:h-[49px] lg:text-[21px]" :variant="tab === 'video' ?'solid' :'outline'">最新影音</MajorButton>
          </NuxtLink>
        </div>
        <div class="col-6" style="max-width: 190px;">
          <NuxtLink to="/posts/news">
            <MajorButton class="h-[44px] lg:h-[49px] lg:text-[21px]" :variant="tab === 'news' ?'solid' :'outline'">最新娛樂</MajorButton>
          </NuxtLink>
        </div>
      </div>
    </div>

    <div class="container max-w-screen-xl">
      <div
      v-for="(node, index) in listFetcher.data.value?.data?.list"
      :key="index"
      class="mb-5">
        <div class="item" style="border-image: linear-gradient(#0c1074 0%, #5d00ff 46.03%, #0c1074 100%) 1; border-width: 7px; border-style: solid;">
          <div class="p-4 lg:p-2.5">
            <div class="row lg:flex-nowrap">
              <div class="col-12 mb-2.5 shrink lg:mb-0 lg:max-w-[285px]">
                <RatioArea
                v-if="tab === 'video'"
                ratio="56"
                @click="()=>{
                  state.open = convertYoutubeUrlToEmbed(node?.yt_url)?.embedURL || ''
                }">
                  <div
                  class="absolute left-0 top-0 size-full bg-cover bg-center bg-no-repeat"
                  :style="{
                    backgroundImage: `url(${convertYoutubeUrlToEmbed(node?.yt_url)?.cover})`
                  }"></div>
                </RatioArea>
                <NuxtLink
                v-else
                :to="`/post/${node.id}`">
                  <RatioArea ratio="66.54">
                    <div
                    class="absolute left-0 top-0 size-full bg-cover bg-center bg-no-repeat"
                    :style="{
                      backgroundImage: `url(${node?.img})`
                    }"></div>
                  </RatioArea>
                </NuxtLink>
              </div>
              <div class="col-12 mb-5 shrink text-white lg:mb-2">
                <NuxtLink :to="`/post/${node.id}`">
                  <div class="mb-2.5 text-[18px]">{{ node.title }}</div>
                  <div class="mb-4 flex">
                    <div class="mr-2 rounded-lg bg-major px-2 py-1 text-[14px]">{{ tab === 'video' ?'影音' :'娛樂' }}</div>
                    <div class="rounded-lg border px-2 py-1 text-[12px]">{{ node.date }}</div>
                  </div>
                  <div class="line-clamp-2 text-[15px]">{{ node.excerpts }}</div>
                </NuxtLink>
              </div>
              <div class="col-auto self-end _lg:mx-auto">
                <MajorButton
                class="w-[134px]"
                style="height: 43px;"
                @click="()=>{
                  if( tab === 'video' ){
                    state.open = convertYoutubeUrlToEmbed(node?.yt_url)?.embedURL || ''
                  }else{
                    router.push({
                      path: `/post/${node.id}`
                    })
                  }
                }">
                  看更多 <i class="bi bi-chevron-double-right text-[13px]"></i>
                </MajorButton>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <Pagination
    class="py-8"
    :current="Number(route.query.page || 1)"
    :total="listFetcher.data.value?.data?.pagination?.total"
    :chunk-size="viewport.width.value >= 992 ?4 :3"
    :on-page-change="(page:number)=>{
      router.push({
        query: {
          page
        }
      })
    }" />
  </main>
</template>

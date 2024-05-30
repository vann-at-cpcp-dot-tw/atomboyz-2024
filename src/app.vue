<script lang="tsx" setup>
import { createStore } from '~/store'
import 'swiper/css'
import 'swiper/css/autoplay'
import 'swiper/css/navigation'
import 'swiper/css/pagination'
import 'swiper/css/scrollbar'
const window = process.client ? globalThis : null
const route = useRoute()
const config = useRuntimeConfig()
const API_URL = config.public.apiURL
const APP_URL = config.public.appURL
const APP_BASE = config.public.appBase
const IS_STAGE = Number(config.public?.isStage) === 1
const { data } = await useFetch<any>(`${API_URL}/general`)
const store = createStore()
store.general = data.value?.data

async function trackingInit(){
  if (!window){
    return
  }
  const sender = await (window as any)?.webTrackingSDK?.init?.({
    BUID: 'GAMA-hidol-01',
    property: 'GAMA-hidol-01',
    sourceProperty: 'GAMA-hidol-01',
    GTMId: IS_STAGE ? 'GTM-WTMXC2TT' : 'GTM-MCJ7BK4',
  })

  return sender
}

onMounted(()=>{
  if (!window){
    return
  }
  trackingInit().then((sender)=>{
    store.trackingSender = sender
    nextTick(()=>{
      store.do.tracking('PageViewEvent', '55001', 'hidol_campaign_page_view', {
        page_info: {
          page: 'atomboyz_teaser',
        },
      })
    })
  })

  if (store.isPreMode === false){
    ;(window as any).GIMBotTool.init({
      url: 'https://helpdesk.stg.gim.beango.com/Atomboyz',
      title: '客服幫手 原子小少年',
      logoUrl: `${APP_URL}/assets/img/chat_bot_logo.png`,
      btnImgUrl: `${APP_URL}/assets/img/btn_chat_bot.png`,
    })

    ;((window as any).document.getElementById('gim-bot-tool-button') as HTMLDivElement).addEventListener('click', (e)=>{
      store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
        page_info: {
          page: 'atomboyz_teaser',
        },
        click_info: {
          type: 'ai_customer_service',
        },
      })
    })
  }
})
</script>
<template>
  <Html>
    <Head>
      <Title>hidol X 原子少年 2｜獨家線上投票</Title>
      <Meta name="description" content="「hidol X 原子少年2」獨家線上投票平台，我們一起為這些勇敢追夢的選手們投票應援吧！hidol 拉近你與idol的距離。" />
      <Meta name="keywords" content="原子少年、原子少年2、男團、Atom Boyz、Atom Boyz2、歐漢聲、健志、坤達、hidol、拉近你與 idol 的距離、台灣男團選秀" />
      <Meta name="url" :content="APP_URL" />
      <Meta property="og:url" :content="APP_URL" />
      <Meta property="og:title" content="hidol X 原子少年 2｜獨家線上投票" />
      <Meta property="og:site_name" content="hidol X 原子少年 2｜獨家線上投票" />
      <Meta property="og:image" :content="`${APP_BASE}assets/img/og.jpg`" />
      <Meta property="og:description" content="讓我們一起為勇敢追夢的選手們投票應援，你喜歡的少年就差你一票！hidol 拉近你與idol的距離。" />
      <Meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
      <Link rel="icon" type="image/x-icon" :href="`${APP_BASE}assets/img/favicon.png`" />
      <!-- tracikng -->
      <Script :src="IS_STAGE ?'https://sdk.stg.gamania.dev/webtrackingsdk.min.js.gz' :'https://sdk.stg.gamania.dev/webtrackingsdk.min.js.gz'" />
      <Script :src="IS_STAGE ?'https://botsdk.stg.gim.beango.com/index.umd.js' :'https://botsdk.gamania.chat/index.umd.js'" />
    </Head>
    <NuxtLayout>
      <NuxtPage />
    </NuxtLayout>
  </Html>
</template>

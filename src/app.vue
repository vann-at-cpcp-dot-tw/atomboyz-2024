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
const IS_STAGE = config.public.isStage
const { data } = await useFetch<any>(`${API_URL}/general.php`)
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

async function ChatBotInit(){

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

  ;(window as any).GIMBotTool.init({
    url: 'https://helpdesk.stg.gim.beango.com/Atomboyz',
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
})
</script>
<template>
  <Html>
    <Head>
      <Title>原子少年 X beanfun!｜太陽系男團人氣票選</Title>
      <Meta name="description" content="太陽系男團-原子少年 Atom Boyz人氣票選就在beanfun! ，beanfun!用戶登入beanfun! APP或活動網頁就可進行投票。現在搶先下載beanfun! APP並完成註冊，票數直接多5倍，只要輕鬆完成任務及分享還可獲得額外票數。 be here for FUN! 好玩的都在這。" />
      <Meta name="keywords" content="原子少年、bean!、男團、好玩的都在這、太陽系男團人氣票選、Atom Boyz、八大行星、周湯豪、Ella、坤達、be here for FUN!" />
      <Meta name="url" content="https://atomboyz.beanfun.com/" />
      <Meta property="og:title" content="原子少年 X beanfun!｜太陽系男團人氣票選" />
      <Meta property="og:image" content="/assets/img/og.jpg" />
      <Meta property="og:description" content="太陽系男團人氣票選，下載beanfun! APP投票票數多五倍，beanfun! 好玩的都在這！" />
      <Meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
      <Link rel="icon" type="image/x-icon" href="/assets/img/favicon.png" />
      <!-- <Meta v-if="route.name == 'vote' && (route.query.p > 0 && route.query.p <= 80)"
      property="og:title"
      :content="`原子少年 Atom Boyz ${peopleNames[route.query.p]} 就快第一名了！ 拜託幫我偶像投一票 beanfun! 好玩的都在這～`" />
      <Meta v-if="route.name == 'vote' && (route.query.p > 0 && route.query.p <= 80)"
      property="og:image"
      :content="`/_admin/upload/${route.query.p}.jpg`" /> -->
      <!-- <Meta http-equiv="Content-Security-Policy" content="default-src *" /> -->
      <!-- tracikng -->
      <Script :src="IS_STAGE ?'https://sdk.stg.gamania.dev/webtrackingsdk.min.js.gz' :'https://sdk.stg.gamania.dev/webtrackingsdk.min.js.gz'" />
      <Script :src="IS_STAGE ?'https://botsdk.stg.gim.beango.com/index.umd.js' :'https://botsdk.gamania.chat/index.umd.js'" />
    </Head>
    <NuxtLayout>
      <NuxtPage />
    </NuxtLayout>
  </Html>
</template>

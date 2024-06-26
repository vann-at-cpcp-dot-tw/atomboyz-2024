<script lang="tsx" setup>
import { defineComponent } from 'vue'
import { twMerge } from 'tailwind-merge'
import { scrollToSection2 } from '~/lib/helpers'
import { useStore } from '~/store'

const window = process.client ? globalThis : null
interface IProps {
  class?: string
  className?: string
}
interface IState {
  active: string | null
}
const props = defineProps<IProps>()
const route = useRoute()
const store = useStore()
const state = reactive<IState>({
  active: 'voteinfo'
})
const Trigger = defineComponent({
  props: ['title', 'isActive'],
  setup: (props, { slots })=>{
    return ()=><div class="btn trigger flex items-center py-4 text-major-800">
      <div class="ml-auto text-[18px]">{ props?.title }</div>
      <div class="ml-auto flex size-6 items-center justify-center rounded-full border">
        <i class={`bi bi-chevron-${props.isActive ? 'up' : 'down'} block leading-none`}></i>
      </div>
    </div>
  }
})

const BlockTitle = defineComponent({
  props: ['title'],
  setup: (props, { slots })=>{
    return ()=><div class="mb-2 flex">
      <div class="rounded bg-major-800 px-4 py-2 leading-none text-white">{props?.title}</div>
    </div>
  }
})

const ListItem = defineComponent({
  setup: (props, { slots })=>{
    return ()=><div class="mb-2 flex !flex-nowrap">
      <div class="w-auto flex-none">
        { slots?.dot?.() }
      </div>
      <div class="w-full shrink pl-1">
        { slots?.default?.() }
      </div>
    </div>
  }
})

watch(()=>route.hash, (newVal)=>{
  switch (newVal){
    case '#voteinfo':
    case '#rules':
    case '#notice':
      state.active = route.hash.split('#')[1]
      break
  }
}, {
  immediate: true
})
</script>
<template>
  <div :class="twMerge('bg-[#120C60] lg:px-0 px-5', props.class)">
    <ClientOnly>
      <HashJump />
    </ClientOnly>
    <div class="container mb-2.5 rounded bg-white">
      <div id="voteinfo" class="anchor relative top-[-80px]"></div>
      <Trigger
      title="投票說明"
      :is-active="state.active === 'voteinfo'"
      @click="()=>{
        state.active = state.active === 'voteinfo' ?null :'voteinfo'
        store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
          page_info: {
            sec: 'information'
          },
          click_info: {
            type: 'expand_info',
            name: 'vote_info'
          }
        })
      }" />
      <div v-if="state.active === 'voteinfo'" class="pb-4">
        <hr class="mb-4 border-major-800">
        <pre v-html="store.general?.terms?.voteinfo"></pre>
        <!-- 此次「hidol X 原子少年2 獨家線上投票」為 hidol 首次對外曝光的跨界合作，投票活動限定使用 Gama Pass 帳號登入，並需完成手機或 E-mail 綁定驗證即可參與投票活動。更多詳細的說明再請參閱「活動辦法」。 -->
      </div>
    </div>

    <div class="container mb-2.5 rounded bg-white">
      <div id="rules" class="anchor relative top-[-80px]"></div>
      <Trigger
      title="活動辦法"
      :is-active="state.active === 'rules'"
      @click="()=>{
        state.active = state.active === 'rules' ?null :'rules'
        store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
          page_info: {
            sec: 'information'
          },
          click_info: {
            type: 'expand_info',
            name: 'campaign_info'
          }
        })
      }" />
      <div v-if="state.active === 'rules'" class="pb-4">
        <hr class="mb-4 border-major-800">
        <pre v-html="store.general?.terms?.rules"></pre>
        <!-- <div>【投票資格】</div>
        <div>只要完成 Gama Pass 帳號註冊，且進行手機或 E-mail 的綁定驗證後，即可參與每輪投票。</div>
        <br>
        <div>【投票流程】</div>
        <ListItem>
          <template #dot>Step #1.</template>
          <template #default>登入或註冊 Gama Pass 帳號，且完成手機或 E-mail 的綁定驗證。</template>
        </ListItem>
        <ListItem>
          <template #dot>Step #2.</template>
          <template #default>透過「投票應援」按鈕前往投票頁面，選擇您想支持的少年並點擊「投票」後，選擇欲投之票數（半形數字）即可完成投票。</template>
        </ListItem>
        <br>
        <div>【線上分數計算】</div>
        <div>線上投票分數佔總分的20%，依該賽制各團體內所有成員之得票數加總計算為各團體的分數。每階段的投票成績將於該賽制的錄影現場公開，成為該賽制的線上投票分數。舉例：總分為 100 分，得票最高團體可獲得20分，其次為18分、16分、14分、12分、10分，依此類推。</div>
        <br>
        <div>【其他說明】</div>
        <ListItem>
          <template #dot><div class="text-major-800">1.</div></template>
          <template #default>此投票活動統一以 Gama Pass 帳號登入，且完成手機或 E-mail 的綁定驗證後即可參與每輪投票。</template>
        </ListItem>
        <ListItem>
          <template #dot><div class="text-major-800">2.</div></template>
          <template #default>獲得當日票數：每日系統派票時間為 00:00 ~ 23:55，每日 23:56 ~ 23:59 為系統調整時間。</template>
        </ListItem>
        <ListItem>
          <template #dot><div class="text-major-800">3.</div></template>
          <template #default>當日票數效期：每個帳號每日獲得的票數，若未於當日 23:59 前使用完畢則直接失效。</template>
        </ListItem>
        <ListItem>
          <template #dot><div class="text-major-800">4.</div></template>
          <template #default>有效投票時間：每輪賽制開始投票時間起至該賽制最後投票日當天的 23:59 皆開放投票。</template>
        </ListItem>
        <ListItem>
          <template #dot><div class="text-major-800">5.</div></template>
          <template #default>此投票活動票數顯示可能因為網路或其他因素導致無法即時更新，所有可領票數及可投票數皆以系統判讀為準。</template>
        </ListItem>
        <ListItem>
          <template #dot><div class="text-major-800">6.</div></template>
          <template #default>投票活動期間內若使用非法程式惡意灌票，經查證將把您的 Gama Pass 帳號停權，因此您將無法參與往後的《原子少年2》投票活動。</template>
        </ListItem>
        <br>
        <div>【問題回報】</div>
        <div>如果您遇到了任何問題或需要協助，您可以透過問題回報中心與我們聯繫，只需填寫問題回報單，我們將會迅速處理您的需求。</div>
        <div>✷ 問題回報單 ➜ <a class="text-major underline" href="https://service.antspw.com/hidol/APPForm" target="_blank">https://service.antspw.com/hidol/APPForm</a></div> -->
      </div>
    </div>

    <div class="container rounded bg-white">
      <div id="notice" class="anchor relative top-[-80px]"></div>
      <Trigger
      title="注意事項"
      :is-active="state.active === 'notice'"
      @click="()=>{
        state.active = state.active === 'notice' ?null :'notice'
        store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
          page_info: {
            sec: 'information'
          },
          click_info: {
            type: 'expand_info',
            name: 'notice_info'
          }
        })
      }" />
      <div v-if="state.active === 'notice'" class="pb-4">
        <hr class="mb-4 border-major-800">
        <pre v-html="store.general?.terms?.notice"></pre>
        <!-- <ListItem>
          <template #dot><div class="text-major-800">1.</div></template>
          <template #default>參加此次投票活動即代表已詳細閱讀、了解並同意遵守服務條款、所有活動內容及注意事項。</template>
        </ListItem>
        <ListItem>
          <template #dot><div class="text-major-800">2.</div></template>
          <template #default>依據個人資料保護法，參加本活動視為瞭解及同意主辦單位及協力廠商為抽獎及行銷活動之需要進行蒐集、處理及利用其個人資料（包括電話、email 等資訊）。參加者如欲閱覽、變更、刪除個資或要求主辦單位停止蒐集、處理及利用個人資料，請通知主辦單位。</template>
        </ListItem>
        <ListItem>
          <template #dot><div class="text-major-800">3.</div></template>
          <template #default>主辦單位保有最終修改、變更、活動解釋及取消本活動之權利，若有相關異動將會公告於網站，恕不另行通知。</template>
        </ListItem> -->
      </div>
    </div>
  </div>
</template>

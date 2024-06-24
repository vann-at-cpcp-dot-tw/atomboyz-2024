<script lang="tsx" setup>
import { twMerge } from 'tailwind-merge'
import MajorButton from '~/components/MajorButton.vue'
import { useStore } from '~/store'
import Lightbox from '~/components/Lightbox.vue'
const window = process.client ? globalThis : null
interface IProps {
  class?: string
  className?: string
}
const config = useRuntimeConfig()
const LOGIN_URL = config.public.loginURL
const props = defineProps<IProps>()
const store = useStore()
const route = useRoute()
</script>
<template>
  <Lightbox
  id="NeedLogin"
  icon="person-fill"
  title="尚未登入"
  :on-close="()=>{
    store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
      page_info: {
        type: 'havent_login'
      },
      click_info: {
        type: 'popup_function',
        name: 'close'
      }
    })
  }">
    <div class="mb-6">請您先登入會員再進行相關操作！</div>
    <div class="flex justify-end">
      <a
      :href="LOGIN_URL"
      @click="()=>{
        if(!window){
          return
        }
        window.localStorage.setItem('after_login_route_name', route.name)
        store.do.tracking('ClickEvent', '55001', 'hidol_campaign_item_click', {
          page_info: {
            type: 'havent_login'
          },
          click_info: {
            type: 'popup_function',
            name: 'to_login',
          }
        })
      }">
        <MajorButton class="h-[40px] max-w-[154px]">
          <div class="flex items-center">
            前往登入 <i class="bi bi-chevron-double-right block text-[14px] leading-none"></i>
          </div>
        </MajorButton>
      </a>
    </div>
  </Lightbox>

  <Lightbox
  id="IsNotInGetVotesTime"
  icon="calendar-x"
  title="目前非票券發送時間"
  :on-open="()=>{
    store.do.tracking('PageViewEvent', '55001', 'hidol_campaign_page_view', {
      page_info: {
        type: 'off_time'
      }
    })
  }">
    <div>為確保每日取得票數投票完成的合理操作時間，各種票券發送至當日 23:55 止，若超過此時間登入或完成任務將無法獲得對應的可投票票數，明天請記得於 23:55 前取得票數為少年投票喔！</div>
  </Lightbox>
</template>

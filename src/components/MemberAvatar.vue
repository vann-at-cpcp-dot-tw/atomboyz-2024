<script lang="tsx" setup>
import { twMerge } from 'tailwind-merge'
import { useStore } from '~/store'
const window = process.client ? globalThis : null
const config = useRuntimeConfig()
const LOGIN_URL = config.public.loginURL
interface IProps {
  class?: string
  className?: string
}
const props = defineProps<IProps>()
const store = useStore()
const route = useRoute()
</script>
<template>
  <div :class="twMerge('btn flex lg:flex-col', props.class)">
    <div
    class="btn flex lg:flex-col"
    @click="()=>{
      if( !window ){ return }
      store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
        click_info: {
          type: 'atomboyz_member_icon',
          name: !store.user?.name ?'login_register' :'atomboyz_member_center'
        }
      })
      if( !store.user?.name ){
        window.localStorage.setItem('after_login_route_name', route.name)
        window.location.href = LOGIN_URL
      }
    }">
      <div class="order-last ml-2 size-[37px] lg:order-first lg:mx-auto">
        <div
        v-if="!store?.user?.avatar"
        class="btn btn-scaleUp mx-auto flex size-full items-center justify-center rounded-full bg-major-700 py-2"
        style="box-shadow: -1px 1px 8px #fff inset;">
          <i class="bi bi-person-fill block text-[21px] leading-none text-white"></i>
        </div>
        <div
        v-else
        class="btn btn-scaleUp mx-auto flex size-full rounded-full bg-cover"
        :style="{
          boxShadow: '-1px 1px 8px #fff inset',
          backgroundImage: `url(${store.user.avatar})`
        }">
          <i class="bi bi-person-fill block text-[21px] leading-none text-white"></i>
        </div>
      </div>

      <div v-if="store.user?.name" class="mt-1 text-right text-[10px] text-white lg:text-center">
        <div>{{ store.user.name }}</div>
        <div>擁有票數：{{ store.user.votes }}</div>
      </div>
      <div
      v-else
      class="self-center text-center text-[10px] text-white lg:mb-0 lg:mt-1">
        登入 ｜ 註冊
      </div>
    </div>
  </div>
</template>

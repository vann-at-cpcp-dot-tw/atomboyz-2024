<script lang="tsx" setup>
import { useWindowSize } from '@vueuse/core'
import { useStore } from '~/store'
import MajorButton from '~/components/MajorButton.vue'
import Footer from '~/components/Footer.vue'
import Lightbox from '~/components/Lightbox.vue'
const config = useRuntimeConfig()
const APP_BASE = config.public.appBase
interface IProps {
  class?: string
  className?: string
  countdown: {
    days: string
    hours: string
    minutes: string
    seconds: string
  }
}
const props = defineProps<IProps>()
const store = useStore()
watch(()=>store.lightbox, (newVal)=>{
  if (newVal.includes('PreHomeReminder')){
    store.do.tracking('PageViewEvent', '55001', 'hidol_campaign_page_view', {
      page_info: {
        page: 'atomboyz_teaser',
        type: 'check_account',
      },
    })
  }
}, {
  immediate: true
})

</script>
<template>
  <div class="flex size-full flex-col">
    <main
    class="size-full bg-black bg-no-repeat text-white"
    :style="{
      backgroundImage: `url(${APP_BASE}/assets/img/bg_pre_home.jpg)`,
      backgroundSize: '2565px',
      backgroundPosition: 'center bottom'
    }">
      <Lightbox
      id="PreHomeReminder"
      icon="person-fill"
      title="搶先註冊"
      :on-close="()=>{
        store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
          page_info: {
            page: 'atomboyz_teaser',
            type: 'check_account',
          },
          click_info: {
            type: 'cta',
            name: 'close'
          },
        })
      }">
        <div class="mb-6 text-black">
          <div class="mb-2">本次「hidol X 原子少年 2 線上投票」限定使用 Gama Pass 帳號登入，為您心愛的少年投票。</div>
          <div>1. 我有 beanfun! 帳號：點擊「beanfun! 升級」</div>
          <div>2. 我沒有 beanfun! 帳號：點擊「全新註冊」</div>
        </div>
        <div class="row">
          <div class="col-6">
            <a
            href="https://hidol.fan/M6xVL"
            target="_blank"
            @click="()=>{
              store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
                page_info: {
                  page: 'atomboyz_teaser',
                  type: 'check_account',
                },
                click_info: {
                  type: 'cta',
                  name: 'upgrade'
                },
              })
            }">
              <MajorButton class="h-[40px]">
                beanfun! 升級
              </MajorButton>
            </a>
          </div>
          <div class="col-6">
            <a
            href="https://accounts.stg.gama.beango.com/oauth2/authorize?response_type=code&prompt=login&client_id=MjdiZGNhNWUtMTI2ZC00ZGZmLTkwMjctMDY5MDhmYzM2Mjlj&scope=openid,userinfo.profile&redirect_uri=http://localhost/&state=1234&nonce=5678"
            target="_blank"
            @click="()=>{
              store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
                page_info: {
                  page: 'atomboyz_teaser',
                  type: 'check_account',
                },
                click_info: {
                  type: 'cta',
                  name: 'sign_up'
                },
              })
            }">
              <MajorButton class="h-[40px]">
                全新註冊
              </MajorButton>
            </a>
          </div>
        </div>
      </Lightbox>

      <div class="container mb-4 flex justify-center pt-1 lg:pt-[68px]">
        <img class="hidden lg:block" src="/assets/img/title_home_1.png" style="max-width: 498px;">
        <img class="block lg:hidden" src="/assets/img/title_home_1_m.png" style="max-width: 192px;">
      </div>
      <div class="container text-center">
        <div class="mb-4 text-[20px] lg:text-[30px]">
          獨家線上投票 <b>Coming Soon</b>
        </div>
      </div>
      <div class="container-fluid mb-8 px-4">
        <div class="mx-auto w-full max-w-[375px] lg:max-w-[697px]">
          <div class="row lg:row-gap-5 row-gap-2 flex-nowrap items-center justify-center">
            <div class="col-auto w-1/4 shrink text-center">
              <div class="whitespace-nowrap text-[56px] font-600 leading-none sm:text-[60px] lg:text-[98px]">
                {{ props.countdown.days }}
              </div>
              <div class="-mb-2 text-center text-[12px] font-300 lg:-mb-4 lg:text-[19px]">DAYS</div>
            </div>
            <div class="col-auto">
              <div class="text-[22px] lg:text-[52px]">:</div>
            </div>
            <div class="col-auto w-1/4 shrink text-center">
              <div class="whitespace-nowrap text-[56px] font-600 leading-none sm:text-[60px] lg:text-[98px]">
                {{ props.countdown.hours }}
              </div>
              <div class="-mb-2 text-center text-[12px] font-300 lg:-mb-4 lg:text-[19px]">HOURS</div>
            </div>
            <div class="col-auto">
              <div class="text-[22px] lg:text-[52px]">:</div>
            </div>
            <div class="col-auto w-1/4 shrink text-center">
              <div class="whitespace-nowrap text-[56px] font-600 leading-none sm:text-[60px] lg:text-[98px]">
                {{ props.countdown.minutes }}
              </div>
              <div class="-mb-2 text-center text-[12px] font-300 lg:-mb-4 lg:text-[19px]">MINUTES</div>
            </div>
            <div class="col-auto">
              <div class="text-[22px] lg:text-[52px]">:</div>
            </div>
            <div class="col-auto w-1/4 shrink text-center">
              <div class="whitespace-nowrap text-[56px] font-600 leading-none sm:text-[60px] lg:text-[98px]">
                {{ props.countdown.seconds }}
              </div>
              <div class="-mb-2 text-center text-[12px] font-300 lg:-mb-4 lg:text-[19px]">SECONDS</div>
            </div>
          </div>
        </div>
      </div>
      <div class="container flex justify-center">
        <MajorButton
        class="btn btn-light h-[42px] w-[150px] lg:h-[60px] lg:w-[215px] lg:text-[20px]"
        @click="()=>{
          store.do.lightboxOpen('PreHomeReminder')
          store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
            page_info: {
              page: 'atomboyz_teaser',
            },
            click_info: {
              type: 'cta',
              name: 'sign_up_entry'
            },
          })
        }">
          搶先註冊
        </MajorButton>
      </div>
    </main>
    <Footer />
  </div>
</template>

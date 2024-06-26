<script lang="tsx" setup>
import { useWindowSize } from '@vueuse/core'
import FloatSticker1 from './FloatSticker1.vue'
import FloatSticker2 from './FloatSticker2.vue'
import MemberCenter from './MemberCenter.vue'
import { copyUrlToClipboard, scrollToSection2 } from '~/lib/helpers'
import LightboxList from '~/components/LightboxList.vue'
import { useStore } from '~/store'
const config = useRuntimeConfig()
const API_URL = config.public.apiURL
const LOGIN_URL = config.public.loginURL
const window = process.client ? globalThis : null
const route = useRoute()
const router = useRouter()
const store = useStore()
const viewport = useWindowSize()
const state = reactive({
  isShareNavOpen: false,
  isMobileMenuOpen: false,
  isMounted: false,
})
const ranksFetcher = await useFetch<{data:{[key:string]:any}}>(`${API_URL}/rank`)

const saleFetcher = await useFetch<{data:{[key:string]:any}}>(`${API_URL}/sale`)

const navFull = computed<{
  label: string
  names: string[]
  to?: string
  display?: boolean
  onClick?: Function
}[]>(()=>{
  return [
    {
      label: '首頁',
      names: ['index'],
      to: '/',
      onClick: ()=>{
        store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
          click_info: {
            type: viewport.width.value >= 992 ? 'top_navigation' : 'hamburger',
            name: 'atomboyz_homepage'
          }
        })
      },
    },
    {
      label: 'NEWS',
      names: ['news-tab', 'article-id'],
      to: '/news/video',
      onClick: ()=>{
        store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
          click_info: {
            type: viewport.width.value >= 992 ? 'top_navigation' : 'hamburger',
            name: 'atomboyz_news'
          }
        })
      }
    },
    {
      label: '我要投票',
      names: ['vote'],
      to: '/vote',
      onClick: ()=>{
        store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
          click_info: {
            type: viewport.width.value >= 992 ? 'top_navigation' : 'hamburger',
            name: 'atomboyz_vote'
          }
        })
      }
    },
    {
      label: '排行榜',
      names: ['rank'],
      to: '/#ranking',
      display: store.rank?.personal?.length > 0 || store.rank?.team?.length > 0 || store.rank?.social?.length > 0 || store.rank?.sale?.length > 0,
      onClick: ()=>{
        store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
          click_info: {
            type: viewport.width.value >= 992 ? 'top_navigation' : 'hamburger',
            name: 'atomboyz_ranking'
          }
        })
      }
    },
    {
      label: '周邊商品',
      names: ['shop'],
      to: '/#merch',
      display: store?.sale?.list?.length > 0,
      onClick: ()=>{
        store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
          click_info: {
            type: viewport.width.value >= 992 ? 'top_navigation' : 'hamburger',
            name: 'atomboyz_goods'
          }
        })
      }
    },
    {
      label: '會員中心',
      names: ['member'],
      onClick: ()=>{
        if (!window){
          return
        }

        store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
          click_info: {
            type: viewport.width.value >= 992 ? 'top_navigation' : 'hamburger',
            name: 'atomboyz_member_center'
          }
        })

        if (!store.user?.name){
          store.do.lightboxOpen('NeedLogin')
        } else {
          router.push({
            hash: '#member'
          })
        }
      }
    }
  ]
})

const nav = computed(()=>{
  return navFull.value.filter?.((node:any)=>node.display !== false)
})

watch(()=>state.isMobileMenuOpen, (newVal)=>{
  if (!window){
    return
  }
  if (newVal === true){
    document.body.classList.add('menu-open')
  } else {
    document.body.classList.remove('menu-open')
  }
}, {
  immediate: true
})

watch(()=>ranksFetcher.data.value, (newVal)=>{
  store.rank = {
    personal: newVal?.data?.personal,
    team: newVal?.data?.team,
    social: newVal?.data?.social,
    sale: newVal?.data?.sale,
  }
}, {
  immediate: true
})

watch(()=>saleFetcher.data.value, (newVal)=>{
  store.sale.list = newVal?.data?.list
}, {
  immediate: true
})

watch(()=>[window, route.hash, state.isMounted], (newVal, oldVal)=>{
  const window = newVal[0]
  const newHash = newVal?.[1]
  const oldHash = oldVal?.[1]
  const isMounted = newVal[2]
  // if (!window || !isMounted){
  //   return
  // }

  // if (newHash){
  //   setTimeout(()=>{
  //     if (route.hash){
  //       scrollToSection2({ el: window.document.querySelector(route.hash), jump: true })
  //     }
  //   }, 500)
  // }
}, {
  immediate: true
})

// onMounted(()=>{
//   state.isMounted = true
//   window?.addEventListener('load', ()=>{
//     if (route.hash){
//       scrollToSection2({ el: window.document.querySelector(route.hash), jump: true })
//     }
//   })
// })

</script>
<template>
  <MemberCenter v-if="store.user?.name && ['#member', '#task', '#favourite', '#voting_record'].includes(route.hash)" />
  <LightboxList />
  <FloatSticker1 />
  <FloatSticker2 />
  <header
  class="fixed left-0 top-0 flex w-full justify-center pb-5 lg:pt-5"
  :style="{
    zIndex: viewport.width.value >= 992 ?'400' :state.isMobileMenuOpen ?'1000' :'100'
  }">
    <div class="container hidden justify-center lg:flex">
      <div class="mx-auto flex w-auto max-w-full items-center rounded-full px-5 py-1" style="background: rgba(255,255,255, 0.66); box-shadow: 13px 6px 10px rgba(0,0,0,0.44); height: 50px;">
        <div class="row">
          <div
          v-for="(node, index) in nav"
          :key="index"
          class="col-auto">
            <div :to="node?.to">
              <div
              class="btn rounded-full py-1 text-center"
              :class="`${node.names.includes(route.name) ?'bg-major text-white min-w-[95px]' :'text-major btn-scaleUp'}`"
              @click="()=>{
                node?.onClick?.()
                if(node.to){
                  $router.push({
                    path: node.to,
                    hash: node?.to?.split('#')?.[1] ?`#${node.to.split('#')[1]}` :''
                  })
                }
              }">
                {{ node.label }}
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="flex">
        <div
        class="relative mr-4 self-start"
        @mouseenter="()=>{
          state.isShareNavOpen = true
          store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
            click_info: {
              type: 'share',
              name: 'open'
            }
          })
        }"
        @mouseleave="()=>{
          state.isShareNavOpen = false
        }"
        @click="()=>{
          if( typeof window?.navigator?.share === 'function' && viewport.width.value <= 991 ){
            store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
              click_info: {
                type: 'share',
                name: 'open'
              }
            })
            store.do.share(route.name)
          }
        }">
          <div class="py-1">
            <div
            class="btn btn-scaleUp flex size-[37px] items-center justify-center rounded-full bg-[#D3D5F6]"
            style="box-shadow: -2px 5px 8px #fff inset;"
            @click="()=>{
              state.isShareNavOpen = true
            }">
              <i class="bi bi-share-fill ml-[-2px] mt-px text-[18px] text-major-700"></i>
            </div>
          </div>
          <div v-if="state.isShareNavOpen" class="absolute left-0 top-full hidden w-full rounded-full bg-[#D3D5F6] py-2 lg:block" style="box-shadow: -2px 5px 8px #fff inset;">
            <div
            class="btn btn-scaleUp mx-auto mb-1.5 flex size-7 items-center justify-center rounded-full  bg-major-700 text-white"
            @click="()=>{
              store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
                click_info: {
                  type: 'share',
                  name: 'link'
                }
              })
              copyUrlToClipboard(store.do.genShareURL($route.name))
            }">
              <i class="bi bi-link-45deg text-[21px]"></i>
            </div>
            <div
            class="btn btn-scaleUp mx-auto mb-1.5 size-7 rounded-full bg-white"
            @click="()=>{
              store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
                click_info: {
                  type: 'share',
                  name: 'facebook'
                }
              })
              store.do.share(route.name, null, 'fb')
            }">
              <i class="bi bi-facebook block text-[28px] leading-none text-major-700"></i>
            </div>
            <div
            class="btn btn-scaleUp mx-auto flex size-7 items-center justify-center rounded-full bg-major-700 text-white"
            @click="()=>{
              store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
                click_info: {
                  type: 'share',
                  name: 'line'
                }
              })
              store.do.share(route.name, null, 'line')
            }">
              <i class="bi bi-line relative mt-[3px] block text-[19px] leading-none text-white"></i>
            </div>
          </div>
        </div>
        <div class="flex flex-col items-center">
          <MemberAvatar />
        </div>
      </div>
    </div>

    <div class="flex w-full items-center justify-end lg:hidden">
      <MemberAvatar v-show="!state.isMobileMenuOpen" class="mr-2" />
      <div
      v-show="!state.isMobileMenuOpen"
      class="btn flex size-[68px] items-center justify-center lg:hidden"
      style="border-radius: 0px 0px 0px 9px; background: linear-gradient(#0c1074 0%, #5d00ff 50%, #0c1074 100%);"
      @click="()=>{
        state.isMobileMenuOpen = true
        store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
          click_info: {
            type: 'hamburger',
            name: 'open'
          },
        })
      }">
        <img src="/assets/img/icon_menu.svg" alt="">
      </div>
      <div
      v-show="state.isMobileMenuOpen"
      class="fixed left-0 top-0 z-[1000] size-full overflow-hidden"
      :style="{
        height: '100%',
        maxHeight: `calc(100% - ${16+(store.bottomStickyHeight||0)}px)`
      }">
        <div
        v-show="state.isMobileMenuOpen"
        class="fixed left-0 top-0 z-10 flex h-[67px] w-full items-start justify-between px-4"
        style="background:#3A1DAC;">
          <img class="self-center" src="/assets/img/menu_logo_m.png" style="width:150px;">
          <MemberAvatar class="mt-4" />
        </div>
        <div
        class="absolute rounded-lg p-2.5"
        :style="{
          width: 'calc(100% - 32px)',
          left: '16px',
          top: 'calc(67px + 16px)',
          height: `calc(100% - 67px - 16px)`,
          background: `rgba(58,29,172,0.44)`,
          backdropFilter: 'blur(4px)',
        }">
          <div class="mb-2.5 flex justify-end">
            <div
            class="btn flex size-8 items-center justify-center rounded-full bg-[#3A1DAC]"
            @click="()=>{
              state.isMobileMenuOpen = false
              store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
                click_info: {
                  type: 'hamburger',
                  name: 'close'
                },
              })
            }">
              <i class="bi bi-x text-[32px] leading-none text-white"></i>
            </div>
          </div>
          <div class="flex size-full flex-col overflow-auto">
            <div class="px-5">
              <div
              v-for="(node, index) in nav"
              :key="index"
              class="w-full pb-3">
                <div :to="node?.to">
                  <div
                  class="btn rounded-full py-3 text-center text-[20px]"
                  :class="`${node.names.includes(route.name) ?'bg-major text-white min-w-[95px]' :'text-major bg-white'}`"
                  @click="()=>{
                    node?.onClick?.()
                    state.isMobileMenuOpen = false
                    if(node.to){
                      $router.push({
                        path: node.to,
                        hash: node?.to?.split('#')?.[1] ?`#${node.to.split('#')[1]}` :''
                      })
                    }
                  }">
                    {{ node.label }}
                  </div>
                </div>
              </div>
            </div>
            <div class="mt-auto flex justify-center pb-12">
              <div class="px-1.5">
                <div
                class="flex size-[49px] items-center justify-center rounded-full"
                style="background: linear-gradient(#0c1074 0%, #5d00ff 100%);"
                @click="()=>{
                  store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
                    click_info: {
                      type: 'share',
                      name: 'link'
                    }
                  })
                  copyUrlToClipboard(store.do.genShareURL($route.name))
                }">
                  <i class="bi bi-link-45deg pointer-events-none relative top-0.5 text-[36px] leading-none text-white"></i>
                </div>
              </div>
              <div class="px-1.5">
                <div
                class="flex size-[49px] items-center justify-center rounded-full"
                style="background: linear-gradient(#0c1074 0%, #5d00ff 100%);"
                @click="()=>{
                  store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
                    click_info: {
                      type: 'share',
                      name: 'open'
                    }
                  })
                  store.do.share(route.name)
                }">
                  <i class="bi bi-share-fill pointer-events-none relative -left-0.5 text-[26px] leading-none text-white"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
</template>

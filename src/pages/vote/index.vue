<script lang="tsx" setup>
import { useWindowSize } from '@vueuse/core'
import { teams } from '~/lib/utils'
import Breadcrumbs from '~/components/Breadcrumbs.vue'
import PageHead from '~/components/templates/vote/PageHead.vue'
import PeopleCard from '~/components/PeopleCard.vue'
import PeopleBox from '~/components/PeopleBox.vue'
import { useStore } from '~/store'
const config = useRuntimeConfig()
const API_URL = config.public.apiURL
const router = useRouter()
const route = useRoute()
const store = useStore()
const viewport = useWindowSize()
const peopleFetcher:{[key:string]:any} = await useFetch(`${API_URL}/people`)
const state = reactive({
  scrollIng: false,
  scrollFocus: null,
  activeTeamId: null,
  scrollDirection: '',
  windowOldScrollY: 0,
  searchNameToTagID: (name:string)=>{
    const targetPeople = peopleFetcher.data.value?.data?.list?.find((node:any)=>node.name.toLowerCase() === name.toLowerCase())
    return targetPeople?.tag_id
  },
  stickyHeight: computed(()=>{
    if (viewport.width.value >= 992){
      return 111 + 276
    } else {
      return 88 + 201
    }
  }),
  teamWithPeoples: computed(()=>{
    const originList = peopleFetcher.data.value?.data?.list
    const listWithTeam = teams?.map((teamNode, index)=>{
      return {
        ...teamNode,
        people: originList?.filter?.((peopleNode:any)=>peopleNode.team === teamNode.id && peopleNode?.situation_key == 1)
      }
    })
    return listWithTeam
  }),
  pendingList: computed(()=>{
    const originList = peopleFetcher.data.value?.data?.list
    return originList?.filter?.((node:any)=>node?.situation_key == 3)
  }),
  failedList: computed(()=>{
    const originList = peopleFetcher.data.value?.data?.list
    return originList?.filter?.((node:any)=>node.situation_key == 2)
  }),
})
const stickyHeightPx = computed(()=>{
  return `${state.stickyHeight}px`
})
provide('scopeStore', state)

const queryPeople = computed(()=>{
  const result = peopleFetcher.data.value?.data?.list?.find?.((node:any)=>node.tag_id && (node.tag_id === route.query.p))
  if (result?.team === -2){
    return null
  }
  return result
})
if (queryPeople.value){
  useHead({
    meta: [
      { name: 'title', content: '我要投票｜hidol X 原子少年 2｜獨家線上投票' },
      { name: 'description', content: '「hidol X 原子少年2」獨家線上投票平台，我們一起為這些勇敢追夢的選手們投票應援吧！hidol 拉近你與idol的距離。' },
      { name: 'keywords', content: '原子少年、原子少年2、男團、Atom Boyz、Atom Boyz2、歐漢聲、健志、坤達、hidol、拉近你與 idol 的距離、台灣男團選秀' },
      { property: 'og:site_name', content: '我要投票｜hidol X 原子少年 2｜獨家線上投票' },

      { property: 'og:title', content: queryPeople.value?.name ? `原子少年 Atom Boyz ${queryPeople.value?.name} 就快第一名了！ 拜託幫我偶像投一票 beanfun! 好玩的都在這～` : null },
      { property: 'og:image', content: queryPeople.value?.img ? queryPeople.value?.img : null },
    ],
  })
} else {
  useHead({
    meta: [
      { name: 'title', content: '我要投票｜hidol X 原子少年 2｜獨家線上投票' },
      { name: 'description', content: '「hidol X 原子少年2」獨家線上投票平台，我們一起為這些勇敢追夢的選手們投票應援吧！hidol 拉近你與idol的距離。' },
      { name: 'keywords', content: '原子少年、原子少年2、男團、Atom Boyz、Atom Boyz2、歐漢聲、健志、坤達、hidol、拉近你與 idol 的距離、台灣男團選秀' },
      { property: 'og:site_name', content: '我要投票｜hidol X 原子少年 2｜獨家線上投票' },
    ]
  })
}

const isTrackingInit = ref(false)
watch(()=>[isTrackingInit, store.trackingSender], (newVal)=>{
  if (!isTrackingInit.value && store.trackingSender){
    store.do.tracking('PageViewEvent', '55001', 'hidol_campaign_page_view')
  }
}, {
  immediate: true
})

watch(()=>store.lightbox, (newVal)=>{
  const voteAlert = {
    NeedLogin: 'havent_login',
    NeedVerify: 'unauthenticated',
    VoteConfirm: 'check',
    NoMoreVotes: 'failed',
    VoteFailed: 'failed',
    IPWarning: 'blocked'
  }[store?.lightbox?.[0]]

  if (voteAlert){
    store.do.tracking('PageViewEvent', '55001', 'hidol_campaign_page_view', {
      click_info: {
        type: voteAlert
      }
    })
  }
}, {
  immediate: true
})

watch(()=>store?.general?.countdown_end_time, (newVal)=>{
  if (store.do.isNotVoteDate()){
    store.do.lightboxOpen('VoteComing')
  }
}, {
  immediate: true
})

</script>
<template>
  <main
  v-touch:drag="(e:any)=>{
    if(e.type.includes('mouse')){
      return
    }
    state.scrollFocus = null
  }"
  class="relative text-white"
  @mousewheel="(e:any)=>{
    state.scrollFocus = null
  }">
    <Breadcrumbs :list="[{label: '首頁', href: '/'}, {label: '我要投票'}]" />

    <ClientOnly>
      <PageHead class="mb-8" />
      <PeopleBox v-if="queryPeople" v-bind="queryPeople" />
    </ClientOnly>

    <Lightbox
    id="NeedVerify"
    icon="arrow-left-right"
    title="尚未完成會員雙重驗證"
    :on-close="()=>{
      store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
        page_info: {
          type: 'unauthenticated'
        },
        click_info: {
          type: 'close'
        }
      })
    }">
      <div class="mb-6">為了增強您的帳戶安全，請您先至GAMAPASS會員中心完成Email 或 手機門號驗證再進行投票喔！</div>
      <div class="flex justify-end">
        <a
        href="###"
        @click="()=>{
          store.do.tracking('ClickEvent', '55001', 'hidol_campaign_item_click', {
            page_info: {
              type: 'unauthenticated',
            },
            click_info: {
              type: 'popup_function',
              name: 'to_2FA',
            }
          })
        }">
          <MajorButton class="h-[40px] max-w-[154px]">
            <div class="flex items-center">
              立即前往驗證 <i class="bi bi-chevron-double-right block text-[14px] leading-none"></i>
            </div>
          </MajorButton>
        </a>
      </div>
    </Lightbox>

    <Lightbox id="VoteComing" icon="calendar-x" title="尚未開放投票">
      <div>下一輪投票即將啟動，敬請期待</div>
    </Lightbox>

    <Lightbox
    id="NoMoreVotes"
    title-bg="#AF0808"
    title="投票失敗"
    :on-close="()=>{
      store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
        page_info: {
          type: 'failed'
        },
        click_info: {
          type: 'close'
        }
      })
    }">
      <div>您目前的票數不足<span v-if="typeof store?.user?.votes === 'number' && store?.user?.votes>0">，請重新輸入票數</span>。</div>
    </Lightbox>

    <Lightbox
    id="IPWarning"
    title-bg="#AF0808"
    title="無法投票"
    :on-close="()=>{
      store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
        page_info: {
          type: 'blocked'
        },
        click_info: {
          type: 'close'
        }
      })
    }">
      <div>您的 IP 位址可能存在安全風險，請您再次檢查您的網路環境。</div>
    </Lightbox>

    <Lightbox
    id="VoteFailed"
    title-bg="#AF0808"
    title="投票失敗"
    :on-close="()=>{
      store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
        page_info: {
          type: 'failed'
        },
        click_info: {
          type: 'close'
        }
      })
    }">
      <div>請檢查您的網路環境，並確認您有足夠的票數。</div>
    </Lightbox>

    <Lightbox id="VoteInput" icon="hand-thumbs-up-fill" title="原子少年2 ATOM BOYZ">
      <div class="mb-6">
        <div class="text-[18px] text-[#342F2F]">投票給 <span class="text-major">{{ store.myVoting.name || '-' }}</span> 選手</div>
        <div class="text-[15px] text-[#6B6B6B]">請選擇投票票數，點選確認後即送出投票。</div>
      </div>
      <div class="mx-auto w-full max-w-[312px]">
        <div class="mb-4 rounded-lg bg-[#C3C1F9] p-5">
          <div class="mx-auto w-full max-w-[250px]">
            <div class="flex !flex-nowrap">
              <select v-model="store.myVoting.votes" class="mr-2 h-[38px] shrink rounded px-2 text-[13px]">
                <option :value="null">請輸入投票票數</option>
                <option v-for="(node, index) in [...Array(store?.user?.votes || 0)]" :key="index" :value="index+1">{{ index+1 }}</option>
              </select>
              <div
              :class="`btn btn-scaleUp flex h-[38px] w-[95px] flex-none items-center justify-center rounded text-[15px] text-white ${typeof store.myVoting.votes === 'number' && store.myVoting.votes >= 1 ?'bg-major' :'bg-gray-400 pointer-events-none'}`"
              @click="()=>{
                store.do.voteConfirm()
                store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
                  page_info: {
                    type: 'vote_page'
                  },
                  click_info: {
                    type: 'sent_vote',
                    name: '送出投票'
                  }
                })
              }">
                送出投票
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6">
            <MajorButton
            class="h-[40px]"
            @click="()=>{
              store.do.voteConfirm({votes:1})
              store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
                page_info: {
                  type: 'vote_page'
                },
                click_info: {
                  type: 'sent_vote',
                  name: '投一票'
                }
              })
            }">
              <div class="flex items-center">
                投他 1 票 <i class="bi bi-chevron-double-right block text-[14px] leading-none"></i>
              </div>
            </MajorButton>
          </div>
          <div class="col-6">
            <MajorButton
            class="h-[40px]"
            @click="()=>{
              store.do.voteConfirm({votes:store?.user?.votes})
              store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
                page_info: {
                  type: 'vote_page'
                },
                click_info: {
                  type: 'sent_vote',
                  name: '剩下全投'
                }
              })
            }">
              <div
              class="flex items-center">
                剩下全投 <i class="bi bi-chevron-double-right block text-[14px] leading-none"></i>
              </div>
            </MajorButton>
          </div>
        </div>
      </div>
    </Lightbox>

    <Lightbox
    id="VoteConfirm"
    icon="exclamation-triangle-fill"
    title="請您再次確認投票資訊"
    :on-close="()=>{
      store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
        page_info: {
          type: 'check'
        },
        click_info: {
          type: 'close'
        }
      })
    }">
      <div class="mb-6">
        此次您將投票給 <span class="text-major">{{ store.myVoting.name }}</span>，總共 <span class="text-major">{{ store.myVoting.votes || '-' }}</span> 票，請再次確認您的投票票數，並點擊「確認」完成投票。
      </div>
      <div class="row justify-center lg:justify-end">
        <div class="col-6" style="max-width:140px;">
          <MajorButton
          class="bg-major-300"
          @click="()=>{
            store.do.lightboxClear()
            store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
              page_info: {
                type: 'check'
              },
              click_info: {
                type: 'cancel'
              }
            })
          }">
            取消
          </MajorButton>
        </div>
        <div class="col-6" style="max-width:140px;">
          <MajorButton
          class="bg-major"
          @click="()=>{
            store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
              page_info: {
                type: 'check'
              },
              click_info: {
                type: 'confirm'
              }
            })
            store.do.vote().then((result:any)=>{
              store.do.lightboxClear()

              if( result?.success === true ){
                peopleFetcher.refresh()
                router.push({
                  query: {
                    p: state.searchNameToTagID(store.myVoting?.name)
                  }
                })
              }

              if (result.success === false && result?.code){
                switch (String(result?.code)){ // 1:下輪即將啟動，2:沒雙重驗證，3:票數不足，4:IP風險，5:其他原因失敗，總之就是失敗
                case '1':
                  store.do.lightboxOpen('VoteComing')
                  break
                case '2':
                  store.do.lightboxOpen('NeedVerify')
                  break
                case '3':
                  store.do.lightboxOpen('NoMoreVotes')
                  break
                case '4':
                  store.do.lightboxOpen('IPWarning')
                  break
                case '5':
                  store.do.lightboxOpen('VoteFailed')
                  break
                }
                return
              }

            })
          }">
            確認
          </MajorButton>
        </div>
      </div>
    </Lightbox>

    <div
    v-for="(teamNode, teamIndex) in state.teamWithPeoples"
    :key="teamIndex"
    :data-id="teamNode.id"
    :class="`teamSection container-fluid relative mb-[55px] px-2 lg:px-5 ${store?.general?.exclude_teams?.includes?.(teamNode.id) ?'pointer-events-none opacity-20' :''}`"
    :style="{

    }">
      <div :id="`${teamNode.tagId}`" class="anchor relative" :style="{top: `-${stickyHeightPx}`}"></div>
      <div class="mx-auto w-full max-w-[1093px] rounded-xl border border-white p-2 lg:p-5">
        <div class="mx-auto w-full max-w-[959px]">
          <div class="mb-2 mt-1 flex justify-center lg:mb-4 lg:mt-3 lg:justify-start">
            <div class="flex items-center justify-center pl-3 pr-6 text-white">
              <img class="-ml-1 w-[54px] scale-[1.47]" :src="teamNode.getImg()" alt="">
              <div class="pl-1 text-[18px] lg:text-[20px]">{{ teamNode.name }}</div>
            </div>
          </div>
          <div class="row lg:row-gap-5 row-gap-2 justify-center lg:justify-start">
            <div
            v-for="(peopleNode, peopleIndex) in teamNode?.people || []"
            :key="`${teamIndex}-${peopleIndex}`"
            class="col-auto mb-5 flex w-[33.33%] flex-col lg:w-1/5"
            style="max-width: 190px;">
              <PeopleCard
              class="flex flex-col"
              v-bind="peopleNode"
              :on-thumb-click="()=>{
                console.log(peopleNode)
                router.push({
                  query: {
                    p: peopleNode.tag_id
                  }
                })
              }" />
            </div>
          </div>
        </div>
      </div>
    </div>

    <div v-if="state.pendingList?.length > 0" class="container-fluid mb-[55px] px-2 lg:px-5">
      <div class="mx-auto w-full max-w-[1093px] rounded-xl border border-white p-2 lg:p-5">
        <div class="mx-auto w-full max-w-[959px]">
          <div class="mb-4 mt-1 flex lg:mt-3">
            <div
            class="flex items-center justify-center rounded-lg px-4 py-1.5 text-white"
            style="background: rgba(255,255,255,0.34);">
              <img class="w-[30px]" src="/assets/img/icon_pendding.svg" alt="">
              <div class="pl-2 text-[18px] lg:text-[20px]">待定</div>
            </div>
          </div>
          <div class="lg:row-gap-5 row-gap-2 row justify-center lg:justify-start">
            <div
            v-for="(peopleNode, peopleIndex) in state.pendingList || []"
            :key="`pending-${peopleIndex}`"
            class="col-auto mb-5 flex w-[33.33%] flex-col lg:w-1/5"
            style="max-width: 190px;">
              <PeopleCard
              v-bind="peopleNode"
              :on-thumb-click="()=>{
                router.push({
                  query: {
                    p: peopleNode.tag_id
                  }
                })
              }" />
            </div>
          </div>
        </div>
      </div>
    </div>

    <div v-if="state.failedList?.length > 0" class="container-fluid mb-[55px] px-2 lg:px-5">
      <div class="mx-auto w-full max-w-[1093px] rounded-xl border border-white p-2 lg:p-5">
        <div class="mx-auto w-full max-w-[959px]">
          <div class="mb-4 mt-1 flex lg:mt-3">
            <div
            class="flex items-center justify-center rounded-lg px-4 py-1.5 text-white"
            style="background: rgba(255,255,255,0.34);">
              <img class="w-[30px]" src="/assets/img/icon_pendding.svg" alt="">
              <div class="pl-2 text-[18px] lg:text-[20px]">淘汰</div>
            </div>
          </div>
          <div class="lg:row-gap-5 row-gap-2 row justify-center lg:justify-start">
            <div
            v-for="(peopleNode, peopleIndex) in state.failedList || []"
            :key="`pending-${peopleIndex}`"
            class="col-auto mb-5 flex w-[33.33%] flex-col lg:w-1/5"
            style="max-width: 190px;">
              <PeopleCard
              v-bind="peopleNode"
              :on-thumb-click="()=>{
                router.push({
                  query: {
                    p: peopleNode.tag_id
                  }
                })
              }" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>
<style>
:target {
    scroll-margin-top: v-bind('stickyHeightPx');
}
</style>

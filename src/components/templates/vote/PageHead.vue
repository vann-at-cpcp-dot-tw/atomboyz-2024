<script lang="tsx" setup>
import { twMerge } from 'tailwind-merge'
import { scrollToSection } from 'vanns-common-modules/dist/lib/helpers'
import { teams } from '~/lib/utils'
import { useStore } from '~/store'
import { scrollToSection2 } from '~/lib/helpers'

const window = process.client ? globalThis : null

interface IProps {
  class?: string
  className?: string
}
const props = defineProps<IProps>()
const route = useRoute()
const store = useStore()
const scopeStore = inject<any>('scopeStore')
const state = reactive({
  form: {
    name: '',
    team: '',
  }
})

const setHeaderBg = function(){
  if (!window){
    return
  }
  if (window.scrollY > 400){
    document.getElementsByTagName('header')[0].style.background = 'black'
  } else {
    document.getElementsByTagName('header')[0].style.background = 'none'
  }
}

onMounted(()=>{
  if (!window){
    return
  }
  setHeaderBg()
  window.addEventListener('scroll', setHeaderBg)

  // if has hash
  setTimeout(()=>{
    if (route.hash){
      scrollToSection2({ el: window.document.querySelector(route.hash), jump: true })
    }
  }, 500)
})

onBeforeUnmount(()=>{
  document.getElementsByTagName('header')[0].style.background = 'none'
})

onUnmounted(()=>{
  window?.removeEventListener('scroll', setHeaderBg)
})

</script>
<template>
  <div :class="twMerge(`sticky left-0 pb-5 pt-0 top-[68px] bg-black z-[300] ${store?.user?.name ?'lg:top-[111px]' :'lg:top-[96px]'}`, props.class)">
    <div class="container mb-5 text-center">
      <div class="row items-center justify-center">
        <div class="col-auto mb-4 lg:mb-0 lg:ml-[40%] xl:ml-[44]">
          <i class="text-[28px] font-900 lg:text-[32px]">我要投票</i>
        </div>
        <div class="col-12 ml-auto lg:col-auto">
          <form
          class="row lg:row-gap-2 flex-nowrap"
          @submit="(e)=>{
            e.preventDefault()
            if( !window ){
              return
            }
            state.form.name = (state.form.name || '').trim()
            const searchName = state.form.name
            const tagId = scopeStore.searchNameToTagID(searchName)
            if( tagId ){
              $router.push({
                query: {
                  p:tagId
                }
              })
            }else{
              window.alert('您搜尋的少年名稱有誤，請確認名稱輸入正確！')
              state.form.name = ''
            }
          }">
            <div class="col-6 shrink lg:col-auto">
              <div class="relative h-[38px] overflow-hidden rounded">
                <select
                :value="state.form.team"
                class="btn size-full pl-2 pr-[38px] text-[13px] text-black lg:w-[176px]"
                @change="(e)=>{
                  state.form.team = (e.target as any).value
                  if( !window ){
                    return
                  }

                  $router.push({
                    hash: `#${(e.target as any).value}`
                  })
                  window.setTimeout(() => {
                    scrollToSection2({el:window?.document.querySelector(`#${(e.target as any).value}`), jump: true })
                  }, 0);
                }">
                  <option value="">請選擇團體</option>
                  <option v-for="(node) in teams" :key="node.id" :value="node.tagId">{{ node.name }}</option>
                </select>
                <div class="pointer-events-none absolute right-0 top-0 flex size-[38px] items-center justify-center bg-major text-white">
                  <i class="bi bi-caret-down-fill"></i>
                </div>
              </div>
            </div>
            <div class="col-6 shrink lg:col-auto">
              <div class="relative h-[38px] overflow-hidden rounded">
                <input v-model="state.form.name" type="text" class="size-full pl-2 pr-[69px] text-[13px] text-black lg:w-[200px]" placeholder="請輸入少年姓名">
                <button type="submit" class="btn btn-light absolute right-0 top-0 flex h-[38px] w-[65px] items-center justify-center bg-major text-white">
                  搜尋
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="row lg:row-gap-10">
        <div
        v-for="(node, index) in scopeStore.teamWithPeoples"
        :key="index"
        class="col-2">
          <div
          :class="`btn ${(scopeStore.scrollFocus !== null && scopeStore.scrollFocus !== node.id) || store?.general?.exclude_teams?.includes?.(node.id) ?'opacity-20' :''} ${store?.general?.exclude_teams?.includes?.(node.id) ?'pointer-events-none' :''}`"
          @click="()=>{
            if( !window ){
              return
            }

            scopeStore.scrollFocus = node.id
            $router.push({
              hash: `#${node.tagId}`
            })
            window.setTimeout(()=>{
              scrollToSection2({el:window?.document.querySelector(`#${node.tagId}`), jump: true })
            }, 0)

            store.do.tracking('ClickEvent', '55002', 'hidol_campaign_item_click', {
              page_info: {
                sec: 'atombyz_vote'
              },
              click_info: {
                type: 'direct_vote',
                name: node.name
              }
            })
          }">
            <img
            class="mb-2 w-full scale-[1.8] lg:scale-100"
            :src="node.getImg()"
            style="filter: drop-shadow(0px 0px 1vw rgba(255, 255, 255, 0.42));">
            <div class="mt-2.5 whitespace-nowrap text-center text-[11px] lg:-mt-5 lg:text-[18px]">{{ node.name }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

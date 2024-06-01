<script lang="tsx" setup>
import { twMerge } from 'tailwind-merge'
import { scrollToSection } from 'vanns-common-modules/dist/lib/helpers'
import { teams } from '~/lib/utils'
const window = process.client ? globalThis : null

interface IProps {
  class?: string
  className?: string
}
const props = defineProps<IProps>()
const scopeStore = inject<any>('scopeStore')
const route = useRoute()
const state = reactive({
  scrollIng: false,
  scrollFocus: null,
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
      scrollToSection({ el: window.document.querySelector(route.hash), offset: scopeStore.stickyHeight * -1 })
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
  <div :class="twMerge('sticky left-0 pb-5 pt-0 lg:top-[95px] top-[68px] bg-black z-[300]', props.class)">
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
            const searchName = state.form.name
            const tagId = scopeStore.searchNameToTagID(searchName)
            const peopleTarget = window?.document.getElementById(tagId)
            if( !window ){
              return
            }
            if( state.scrollIng ){
              return
            }
            if( !peopleTarget){
              return
            }
            state.scrollIng = true
            scrollToSection({el:peopleTarget, offset:scopeStore.stickyHeight*-1})
            window.setTimeout(() => {
              state.scrollIng = false
              state.form.name = ''
            }, 800);
          }">
            <div class="col-6 shrink lg:col-auto">
              <div class="relative h-[38px] overflow-hidden rounded">
                <select
                :value="state.form.team"
                class="btn size-full pl-2 pr-[38px] text-black lg:w-[176px]"
                @change="(e)=>{
                  state.form.team = (e.target as any).value
                  if( !window ){
                    return
                  }
                  if( state.scrollIng ){
                    return
                  }
                  state.scrollIng = true
                  scrollToSection({el:window?.document.getElementById(`${(e.target as any).value}`), offset:scopeStore.stickyHeight*-1})
                  window.setTimeout(() => {
                    state.scrollIng = false
                  }, 800);
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
                <input v-model="state.form.name" type="text" class="size-full pl-2 pr-[69px] text-black lg:w-[200px]" placeholder="請輸入少年姓名">
                <button type="submit" class="btn btn-light absolute right-0 top-0 flex h-[38px] w-[65px] items-center justify-center bg-major text-white">
                  <!-- <i class="bi bi-search"></i> -->
                  搜尋
                </button>
              </div>
            </div>
          <!-- <div class="col-auto">
              <div class="btn btn-light flex h-[38px] w-[65px] items-center justify-center rounded bg-major">搜尋</div>
            </div> -->
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
          :class="`btn`"
          :style="{
            // filter: `brightness(${scopeStore.activeTeamId !== null && String(scopeStore.activeTeamId) !== String(node.id) ?'0.2' :'1'})`
            filter: `brightness(${state.scrollFocus !== null && state.scrollFocus !== node.id ?'0.2' :'1'})`
          }"
          @click="()=>{
            if( !window ){
              return
            }
            if( state.scrollIng ){
              return
            }
            state.scrollIng = true
            scrollToSection({el:window?.document.getElementById(`${node.tagId}`), offset:scopeStore.stickyHeight*-1})
            state.scrollFocus = node.id
            window.setTimeout(() => {
              state.scrollFocus = null
              state.scrollIng = false
            }, 800);
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

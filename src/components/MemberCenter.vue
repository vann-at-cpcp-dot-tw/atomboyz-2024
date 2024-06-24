<script lang="tsx" setup>

import { twMerge } from 'tailwind-merge'
import MemberCenterBar from './MemberCenterBar.vue'
import MemberCenterQuests from './MemberCenterQuests.vue'
import MemberCenterFavs from './MemberCenterFavs.vue'
import MemberCenterLogs from './MemberCenterLogs.vue'
import { useStore } from '~/store'

const window = process.client ? globalThis : null
interface IProps {
  class?: string
  className?: string
}
const props = defineProps<IProps>()
const store = useStore()
const router = useRouter()
const route = useRoute()
function handleCLose(){
  router.push({
    hash: ''
  })
}
const pageIs = computed(()=>{
  switch (route.hash){
    case '#member':
    case '#task':
      return 'quests'
    case '#favourite':
      return 'favs'
    case '#voting_record':
      return 'logs'
  }
})

onMounted(()=>{
  if (!window){
    return
  }
  window.document.body.classList.add('mc-open')
  store.do.tracking('PageViewEvent', '55001', 'hidol_campaign_page_view', {
    page_info: {
      page: 'atomboyz_member'
    }
  })
})
onUnmounted(()=>{
  if (!window){
    return
  }
  window.document.body.classList.remove('mc-open')
})
</script>
<template>
  <div
  :class="twMerge('parent fixed size-full left-0 top-0 z-[1000] overflow-hidden', props.class)"
  @click="(e)=>{
    if( (e?.target as HTMLDivElement)?.classList?.value?.includes?.('parent') ){
      if( !window ){
        return
      }
      handleCLose()
    }
  }">
    <div class="parent absolute left-0 top-0 flex size-full justify-center overflow-auto p-5" style="background:rgba(0,0,0,0.8);">
      <div class="my-auto size-full max-w-[1000px] rounded-lg border-[6px] border-[#D4D3D2] bg-white p-5 lg:max-h-[650px] lg:min-h-[460px] lg:p-8">
        <div class="row lg:row-gap-10 hidden h-full flex-nowrap justify-center lg:flex">
          <div class="col-auto mb-4 lg:mb-0">
            <div class="w-full lg:w-[144px]">
              <MemberCenterBar />
            </div>
          </div>
          <div class="col-12 flex lg:mb-0 lg:block lg:shrink _lg:grow">
            <div class="mx-auto grow overflow-auto bg-[#EEEEEE] p-6 lg:size-full lg:w-[570px]">
              <MemberCenterQuests v-if="pageIs === 'quests'" />
              <MemberCenterFavs v-if="pageIs === 'favs'" />
              <MemberCenterLogs v-if="pageIs === 'logs'" />
            </div>
          </div>
          <div class="relative col-auto">
            <i
            class="btn bi bi-x-circle relative text-[28px] leading-none lg:my-0 lg:text-[45px]"
            @click="handleCLose"></i>
          </div>
        </div>

        <div class="flex h-full flex-col lg:hidden">
          <div class="relative mb-[-28px] flex justify-end">
            <i
            class="btn bi bi-x-circle relative text-[28px] leading-none lg:my-0 lg:text-[45px]"
            @click="handleCLose"></i>
          </div>
          <MemberCenterBar class="mb-4 w-full" />
          <div class="grow overflow-auto bg-[#EEEEEE] p-5">
            <MemberCenterQuests v-if="pageIs === 'quests'" />
            <MemberCenterFavs v-if="pageIs === 'favs'" />
            <MemberCenterLogs v-if="pageIs === 'logs'" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

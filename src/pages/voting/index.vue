<script lang="tsx" setup>
import { teams } from '~/lib/utils'
import Breadcrumbs from '~/components/Breadcrumbs.vue'
import PageHead from '~/components/templates/voting/PageHead.vue'
import PeopleCard from '~/components/PeopleCard.vue'
import PeopleBox from '~/components/PeopleBox.vue'

const config = useRuntimeConfig()
const API_URL = config.public.apiURL
const router = useRouter()
const route = useRoute()
const peopleFetcher:{[key:string]:any} = await useFetch(`${API_URL}/people`)
const state = reactive({
  activeTeamId: null,
  scrollDirection: '',
  windowOldScrollY: 0,
  searchNameToTagID: (name:string)=>{
    const targetPeople = peopleFetcher.data.value?.data?.list?.find((node:any)=>node.name === name)
    return targetPeople.tag_id
  },
  stickyHeight: computed(()=>{
    return 375
  }),
  teamWithPeoples: computed(()=>{
    const originList = peopleFetcher.data.value?.data?.list
    const listWithTeam = teams?.map((teamNode, index)=>{
      return {
        ...teamNode,
        people: originList?.filter((peopleNode:any)=>peopleNode.team === teamNode.id)
      }
    })
    return listWithTeam
  }),
  pendingList: computed(()=>{
    const originList = peopleFetcher.data.value?.data?.list
    return originList?.filter((node:any)=>node.team === -1)
  }),
  failedList: computed(()=>{
    const originList = peopleFetcher.data.value?.data?.list
    return originList?.filter((node:any)=>node.team === -2)
  }),
})
const stickyHeightPx = computed(()=>{
  return `${state.stickyHeight}px`
})
provide('scopeStore', state)

const queryPeople = computed(()=>{
  const result = peopleFetcher.data.value?.data?.list.find((node:any)=>node.name === route.query?.p)
  if (result?.team === -2){
    return null
  }
  return result
})
if (queryPeople.value){
  useSeoMeta({
    ogTitle: queryPeople.value?.name ? `原子少年 Atom Boyz ${queryPeople.value?.name} 就快第一名了！ 拜託幫我偶像投一票 beanfun! 好玩的都在這～` : null,
    ogImage: queryPeople.value?.img ? queryPeople.value?.img : null,
  })
}
</script>
<template>
  <main class="relative text-white">
    <Breadcrumbs :list="[{label: '首頁', href: '/'}, {label: '我要投票'}]" />
    <PageHead class="mb-8" />
    <ClientOnly>
      <PeopleBox v-if="queryPeople" v-bind="queryPeople" />
    </ClientOnly>
    <div
    v-for="(teamNode, teamIndex) in state.teamWithPeoples"
    :id="`${teamNode.tagId}`"
    :key="teamIndex"
    :data-id="teamNode.id"
    class="teamSection container-fluid mb-[55px]">
      <div class="mx-auto w-full max-w-[1093px] rounded-xl border border-white p-5">
        <div class="mx-auto w-full max-w-[959px]">
          <div class="mb-4 mt-3 flex justify-center lg:justify-start">
            <div class="flex items-center justify-center pl-3 pr-6 text-white">
              <img class="-ml-1 w-[54px] scale-[1.2]" :src="teamNode.img" alt="">
              <div class="pl-1 text-[20px]">{{ teamNode.name }}</div>
            </div>
          </div>
          <div class="row justify-center lg:justify-start">
            <div
            v-for="(peopleNode, peopleIndex) in teamNode?.people || []"
            :key="`${teamIndex}-${peopleIndex}`"
            class="col-auto mb-5 w-[33.33%] lg:w-1/5"
            style="max-width: 190px;">
              <PeopleCard
              v-bind="peopleNode"
              :on-thumb-click="()=>{
                router.push({
                  query: {
                    p: peopleNode.name
                  }
                })
              }" />
            </div>
          </div>
        </div>
      </div>
    </div>

    <div v-if="state.pendingList?.length > 0" class="container-fluid mb-[55px]">
      <div class="mx-auto w-full max-w-[1093px] rounded-xl border border-white p-5">
        <div class="mx-auto w-full max-w-[959px]">
          <div class="mb-4 mt-3 flex">
            <div class="flex items-center justify-center rounded-lg bg-[#333333] px-4 py-1.5 text-white">
              <img class="w-[31px]" src="/assets/img/icon_pendding.svg" alt="">
              <div class="pl-2 text-[20px]">待定</div>
            </div>
          </div>
          <div class="row justify-center lg:justify-start">
            <div
            v-for="(peopleNode, peopleIndex) in state.pendingList || []"
            :key="`pending-${peopleIndex}`"
            class="col-auto mb-5 w-[33.33%] lg:w-1/5"
            style="max-width: 190px;">
              <PeopleCard
              v-bind="peopleNode"
              :on-thumb-click="()=>{
                router.push({
                  query: {
                    p: peopleNode.name
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

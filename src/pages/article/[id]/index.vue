<script lang="tsx" setup>
const config = useRuntimeConfig()
const API_URL = config.public.apiURL
const route = useRoute()
const dataFetcher = await useFetch<any>(`${API_URL}/news`, {
  query: {
    id: route.params.id,
  }
})
useSeoMeta({
  ogTitle: dataFetcher.data.value?.data?.title || null,
  ogImage: dataFetcher.data.value?.data?.img || null,
})

</script>
<template>
  <main class="text-white">
    <Breadcrumbs :list="[{label: '首頁', href: '/'}, {label:'News', href:'/news/article'}, {label: dataFetcher.data.value?.data?.title}]" />
    <div class="container mb-5 flex justify-center">
      <img class="w-[124px] lg:w-[158px]" src="/assets/img/page_title_news.png">
    </div>
    <div class="container" style="max-width: 1110px;">
      <div class="mb-4 text-[20px] lg:text-[40px]">{{ dataFetcher.data.value?.data?.title }}</div>
      <div class="mb-4 flex">
        <div class="mr-2 rounded-lg bg-major px-3 py-2 text-[14px]">娛樂</div>
        <div class="rounded-lg border px-3 py-2 text-[14px]">{{ dataFetcher.data.value?.data?.date }}</div>
      </div>
      <div class="MCE-CONTENT mb-4" v-html="dataFetcher.data.value?.data?.content"></div>
      <div v-if="dataFetcher.data.value?.data?.tags?.length > 0" class="mb-10 flex">
        <div v-for="(tag, index) in dataFetcher.data.value?.data?.tags" :key="index" class="mr-2 w-auto flex-none text-[#6ED3FF] _lg:text-[13px]">#{{ tag }}</div>
      </div>
      <div class="row justify-center pb-10">
        <div :class="`col-auto ${dataFetcher.data.value?.data?.prev_id ?'' :'opacity-50 pointer-events-none'}`">
          <NuxtLink :to="`/article/${dataFetcher.data.value?.data?.prev_id}`">
            <div class="btn btn-dark rounded-full bg-white px-5 py-2.5 text-black">上一則</div>
          </NuxtLink>
        </div>
        <div class="col-auto">
          <NuxtLink to="/news/article">
            <div class="btn btn-dark rounded-full bg-white px-5 py-2.5 text-black">返回</div>
          </NuxtLink>
        </div>
        <div :class="`col-auto ${dataFetcher.data.value?.data?.next_id ?'' :'opacity-50 pointer-events-none'}`">
          <NuxtLink :to="`/article/${dataFetcher.data.value?.data?.next_id}`">
            <div class="btn btn-dark rounded-full bg-white px-5 py-2.5 text-black">下一則</div>
          </NuxtLink>
        </div>
      </div>
    </div>
  </main>
</template>

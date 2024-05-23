<script lang="tsx" setup>
import Home from '~/components/templates/home/Home.vue'
import PreHome from '~/components/templates/home/PreHome.vue'
const config = useRuntimeConfig()
const IS_PREVIEW_MODE = config.public.isPreviewMode
if (IS_PREVIEW_MODE){
  definePageMeta({
    layout: 'prehome'
  })
}
</script>
<template>
  <PreHome v-if="IS_PREVIEW_MODE" />
  <Home v-else />
</template>

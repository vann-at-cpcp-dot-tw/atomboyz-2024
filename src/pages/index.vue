<script lang="tsx" setup>
import Home from '~/components/templates/home/Home.vue'
import PreHome from '~/components/templates/home/PreHome.vue'
const config = useRuntimeConfig()
const IS_PRE_MODE = Number(config.public?.isPreMode) === 1
if (IS_PRE_MODE){
  definePageMeta({
    layout: 'prehome'
  })
}
definePageMeta({
  layout: 'home'
})
</script>
<template>
  <PreHome v-if="IS_PRE_MODE" />
  <Home v-else />
</template>

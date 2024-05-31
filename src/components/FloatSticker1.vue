<script lang="tsx" setup>
import { twMerge } from 'tailwind-merge'
const props = defineProps({
  class: {
    type: String,
    default: '',
  },
})

const state = reactive({
  show: false,
  showGame: false,
})

onMounted(()=>{
  if (!window){
    return
  }
  window.addEventListener('scroll', function(){
    // if (isScrolledPastHalfway()){
    //   state.show = true
    // } else {
    //   state.show = false
    // }
    if (window.scrollY > 700){
      state.show = true
    } else {
      state.show = false
    }
  })
})

</script>
<template>
  <div
  :class="twMerge(`z-[100] fixed right-0 text-[15px] text-white mt-[-170px] lg:block hidden ${state.show ?'opacity-100' :'opacity-0 pointer-events-none'}`, props.class)"
  :style="{
    padding: '18px 14px',
    borderRadius: '5px 0px 0px 5px',
    background: 'linear-gradient(#5d00ff 0%, #2f0080 100%)',
    transition: 'all .4s',
    bottom: '272px',
  }">
    <NuxtLink to="/vote">
      <div class="btn btn-scaleUp">
        <div class="mb-1"><img class="mx-auto w-[22px]" src="/assets/img/icon_rocket.svg" style="filter:brightness(100);"></div>
        <div class="leading-[1.2]">投票<br>應援</div>
      </div>
    </NuxtLink>
    <!-- <div class="btn btn-scaleUp mt-4">
      <div class="mb-1"><img class="mx-auto w-[18px]" src="/assets/img/icon_planet.svg" style="filter:brightness(100);"></div>
      <div class="leading-[1.2]">每日<br>任務</div>
    </div> -->
  </div>
</template>

<script lang="tsx" setup>
import { twMerge } from 'tailwind-merge'
import MajorButton from '~/components/MajorButton.vue'
import { useStore } from '~/store'
import Lightbox from '~/components/Lightbox.vue'
const window = process.client ? globalThis : null
interface IProps {
  class?: string
  className?: string
}
const config = useRuntimeConfig()
const LOGIN_URL = config.public.loginURL
const props = defineProps<IProps>()
const store = useStore()
</script>
<template>
  <Lightbox id="NeedLogin" icon="person-fill" title="尚未登入">
    <div class="mb-6">請您先登入會員再進行相關操作！</div>
    <div class="flex justify-end">
      <a :href="LOGIN_URL">
        <MajorButton class="h-[40px] max-w-[154px]">
          <div class="flex items-center">
            前往登入 <i class="bi bi-chevron-double-right block text-[14px] leading-none"></i>
          </div>
        </MajorButton>
      </a>
    </div>
  </Lightbox>
</template>

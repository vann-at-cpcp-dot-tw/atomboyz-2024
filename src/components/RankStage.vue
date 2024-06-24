<script lang="tsx" setup>
import { twMerge } from 'tailwind-merge'
import RatioArea from 'vanns-common-modules/dist/components/vue/RatioArea'
import { numberFormat } from 'vanns-common-modules/dist/lib/helpers'
import { useWindowSize } from '@vueuse/core'

const window = process.client ? globalThis : null

interface IProps {
  class?: string
  className?: string
  type?: string
  list?: {
    img: string
    getImg?: Function
    name: string
    number: any
    href?: string
    target?: string
    disabled?: boolean
  }[]
}

const props = defineProps<IProps>()
const viewport = useWindowSize()
</script>

<template>
  <div v-if="props?.list" :class="twMerge('lg:max-w-full max-w-[303px] mx-auto', props.class)">
    <div class="row row-gap-8 items-end lg:flex-nowrap">
      <div
      class="col-12 -mb-3 shrink lg:mb-0"
      :style="{
        maxWidth: viewport.width.value >= 992 ?props?.type === 'sale' ?'39%' :'61%' :'100%',
      }">
        <div v-if="props?.type === 'sale'" class="relative mx-auto mb-3 max-w-[225px] lg:max-w-full">
          <div class="flex items-center">
            <img class="_lg:max-w-[44px]" src="/assets/img/icon_crown2_1.svg">
            <div class="mt-4 pl-1 text-[18px] font-700 italic leading-none text-[#FFC854] lg:text-[22px]">NO.1</div>
          </div>
          <NuxtLink class="btn btn-light" :href="props?.list?.[0]?.href" :target="props?.list?.[0]?.target || '_self'">
            <RatioArea ratio="100">
              <div
              class="absolute left-0 top-0 size-full rounded-t bg-cover bg-center"
              :style="{
                backgroundImage:`url(${props?.list?.[0]?.img})`,
                filter: 'drop-shadow(0px 0px 16px rgba(255, 255, 255, 0.42))'
              }"></div>
            </RatioArea>
            <div class="w-full rounded-b p-4" style="background: linear-gradient(rgba(215, 214, 244, 0.9) 0%, rgba(218, 217, 246, 0.4) 100%);">
              <div class="text-[16px] lg:text-[18px]">{{ props?.list?.[0]?.name }}</div>
              <div class="text-[13px] lg:text-[15px]" v-html="props?.list?.[0]?.number"></div>
            </div>
          </NuxtLink>
        </div>

        <div v-else class="relative">
          <div class="row flex-nowrap items-end justify-between">
            <div class="col-auto mb-[-6%] w-[31%]">
              <NuxtLink :class="`btn btn-light ${props?.list?.[1]?.disabled ?'opacity-50 pointer-events-none' :''}`" :href="props?.list?.[1]?.href" :target="props?.list?.[1]?.target || '_self'">
                <div class="flex justify-center">
                  <div class="relative">
                    <img class="mb-[-4px] ml-[-20px]" src="/assets/img/icon_crown_2.svg" style="width:40px;">
                    <div class="text-center text-[14px] lg:text-[20px]">{{ props?.list?.[1]?.name }}</div>
                    <div class="mb-2 text-center text-[12px] lg:text-[18px]" v-html="props?.list?.[1]?.number"></div>
                  </div>
                </div>
                <RatioArea ratio="100">
                  <div
                  class="absolute left-0 top-0 size-full rounded bg-cover bg-center"
                  :style="{
                    backgroundImage:`url(${props?.list?.[1]?.img})`,
                    filter: 'drop-shadow(0px 0px 16px rgba(255, 255, 255, 0.42))'
                  }"></div>
                </RatioArea>
              </NuxtLink>
            </div>
            <div class="col-auto mb-[2%] w-[39%]">
              <NuxtLink :class="`btn btn-light ${props?.list?.[0]?.disabled ?'opacity-50 pointer-events-none' :''}`" :href="props?.list?.[0]?.href" :target="props?.list?.[0]?.target || '_self'">
                <div class="flex justify-center">
                  <div class="relative">
                    <img class="mb-[-4px] ml-[-24px]" src="/assets/img/icon_crown_1.svg" style="width:44px;">
                    <div class="text-center text-[16px] lg:text-[22px]">{{ props?.list?.[0]?.name }}</div>
                    <div class="mb-2 text-center text-[13px] lg:text-[20px]" v-html="props?.list?.[0]?.number"></div>
                  </div>
                </div>
                <RatioArea ratio="100">
                  <div
                  class="absolute left-0 top-0 size-full rounded bg-cover bg-center"
                  :style="{
                    backgroundImage:`url(${props?.list?.[0]?.img})`,
                    filter: 'drop-shadow(0px 0px 16px rgba(255, 255, 255, 0.42))'
                  }"></div>
                </RatioArea>
              </NuxtLink>
            </div>
            <div class="col-auto mb-[-10%] w-[31%]">
              <NuxtLink :class="`btn btn-light ${props?.list?.[2]?.disabled ?'opacity-50 pointer-events-none' :''}`" :href="props?.list?.[2]?.href" :target="props?.list?.[2]?.target || '_self'">
                <div class="flex justify-center">
                  <div class="relative">
                    <img class="mb-[-4px] ml-[-16px]" src="/assets/img/icon_crown_3.svg" style="width:32px;">
                    <div class="text-center text-[14px] lg:text-[18px]">{{ props?.list?.[2]?.name }}</div>
                    <div class="mb-2 text-center text-[12px] lg:text-[16px]" v-html="props?.list?.[2]?.number"></div>
                  </div>
                </div>
                <RatioArea ratio="100">
                  <div
                  class="absolute left-0 top-0 size-full rounded bg-cover bg-center"
                  :style="{
                    backgroundImage:`url(${props?.list?.[2]?.img})`,
                    filter: 'drop-shadow(0px 0px 16px rgba(255, 255, 255, 0.42))'
                  }"></div>
                </RatioArea>
              </NuxtLink>
            </div>
          </div>
          <img class="w-full" src="/assets/img/rank_stage.svg" alt="">
        </div>
      </div>

      <div
      class="col-12 mb-0 shrink lg:-mb-3"
      :style="{
        maxWidth: viewport.width.value >= 992 ?props?.type === 'sale' ?'61%' :'39%' :'100%',
      }">
        <div
        class="relative">
          <div class="absolute left-0 top-0 z-0 size-full rounded" style="background: linear-gradient(#dad9f6 0%, rgba(218, 217, 246, 0.4) 100%); opacity: 0.25;"></div>
          <div v-if="props?.type === 'sale'">
            <NuxtLink
            v-for="(node, index) in props?.list.slice(1, props?.list?.length) || []"
            :key="index"
            :href="node?.href"
            :target="props?.list?.[0]?.target || '_self'"
            class="btn btn-light relative z-10 block">
              <hr :class="`my-3 ${index === 0 ?'opacity-0': 'opacity-60'}`">
              <div class="row flex-nowrap items-center">
                <div class="col-auto">
                  <div class="pl-5">
                    <div class="w-10 text-center">
                      <div v-if="index === 0" class="font-700 italic">
                        <img class="mx-auto _lg:max-w-[27px]" src="/assets/img/icon_crown2_2.svg" alt="">
                        <div class="_lg:text-[14px]">No.2</div>
                      </div>
                      <div v-else-if="index === 1" class="font-700 italic">
                        <img class="mx-auto _lg:max-w-[27px]" src="/assets/img/icon_crown2_3.svg" alt="">
                        <div class="text-[#E5AE89] _lg:text-[14px]">No.3</div>
                      </div>
                      <div v-else>
                        <div class="_lg:text-[14px]">{{ String(index + 2).padStart(2, '0') }}</div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-auto">
                  <div class="size-[50px] rounded bg-cover bg-center" :style="{backgroundImage: `url(${node.img || node?.getImg?.()})`}"></div>
                </div>
                <div class="col-12 shrink">
                  <div class="pr-5">
                    <div class="_lg:text-[12px]">{{ node.name }}</div>
                    <div class="_lg:text-[12px]" v-html="node.number"></div>
                  </div>
                </div>
              </div>
              <hr v-if="index === props?.list?.length-2" class="my-3 opacity-0">
            </NuxtLink>
          </div>
          <div v-else>
            <NuxtLink
            v-for="(node, index) in props?.list.slice(3, props?.list?.length) || []"
            :key="index"
            :href="node?.href"
            :target="props?.list?.[0]?.target || '_self'"
            :class="`btn btn-light relative z-10 block ${node?.disabled === true ?'opacity-50 pointer-events-none' :''}`">
              <hr :class="`my-3 ${index === 0 ?'opacity-0': 'opacity-60'}`">
              <div class="row flex-nowrap items-center">
                <div class="col-auto"><div class="pl-5 _lg:text-[13px]">{{ String(index + 4).padStart(2, '0') }}</div></div>
                <div class="col-auto">
                  <div class="size-[50px] rounded bg-cover bg-center" :style="{backgroundImage: `url(${node.img || node?.getImg?.()})`}"></div>
                </div>
                <div class="col-6 shrink">
                  <div class="text-[13px] lg:text-[14px]">{{ node.name }}</div>
                </div>
                <div class="col-12 shrink">
                  <div class="pr-5 text-right text-[13px] lg:text-[14px]" v-html="node.number"></div>
                </div>
              </div>
              <hr v-if="index === props?.list?.length-4" class="my-3 opacity-0">
            </NuxtLink>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

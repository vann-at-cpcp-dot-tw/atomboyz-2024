<script lang="tsx" setup>
import { defineComponent } from 'vue'
import { twMerge } from 'tailwind-merge'
const window = process.client ? globalThis : null
interface IProps {
  class?: string
  className?: string
}
interface IState {
  active: number
}
const props = defineProps<IProps>()
const state = reactive<IState>({
  active: 0
})
const Trigger = defineComponent({
  props: ['title'],
  setup: (props, { slots })=>{
    return ()=><div class="btn trigger flex items-center py-4 text-major-800">
      <div class="ml-auto">{ props?.title }</div>
      <div class="ml-auto flex size-6 items-center justify-center rounded-full border">
        <i class="bi bi-chevron-down block leading-none"></i>
      </div>
    </div>
  }
})
const BlockTitle = defineComponent({
  props: ['title'],
  setup: (props, { slots })=>{
    return ()=><div class="mb-2 flex">
      <div class="rounded bg-major-800 px-4 py-2 leading-none text-white">{props?.title}</div>
    </div>
  }
})
const ListItem = defineComponent({
  setup: (props, { slots })=>{
    return ()=><div class="mb-2 flex !flex-nowrap">
      <div class="w-auto flex-none">
        { slots?.dot?.() }
      </div>
      <div class="w-full shrink pl-1">
        { slots?.default?.() }
      </div>
    </div>
  }
})
</script>
<template>
  <div :class="twMerge('bg-[#120C60]', props.class)">
    <div class="container mb-2 bg-white">
      <Trigger title="投票說明" @click="()=>{ state.active = 0 }" />
      <div v-if="state.active === 0" class="pb-4">
        <hr class="mb-4 border-major-800">
        <BlockTitle title="投票資格" />
        <div>只要完成beanfun!註冊就可參加投票，趕快用行動支持你的偶像吧！！</div>
        <br>
        <BlockTitle title="投票流程" />
        <ListItem>
          <template #dot><div class="text-major-800">Step 1.</div></template>
          <template #default>你可透過本網頁(Web)註冊一個beanfun!帳號或下載beanfun! APP完成註冊。</template>
        </ListItem>
        <ListItem>
          <template #dot><div class="text-major-800">Step 2.</div></template>
          <template #default>在本網頁(Web)登入 beanfun! 帳號或開啟 beanfun! APP進入投票頁 。</template>
        </ListItem>
        <ListItem>
          <template #dot><div class="text-major-800">Step 3.</div></template>
          <template #default>你可透過本網頁(Web)登入或直接開啟beanfun! APP領取每日應援票(2者擇1)，每帳號每日限領 1 次（在本網頁Web登入僅可領取 1 票每日應援票；在beanfun! APP 可領取 5 票每日應援票，橘子認同卡卡友在beanfun! APP可再多領 1 票每日應援票）。</template>
        </ListItem>
        <ListItem>
          <template #dot><div class="text-major-800">Step 4.</div></template>
          <template #default>前往＂立即投票＂選擇你想支持的偶像，並點擊＂投他一票＂即可完成投票。</template>
        </ListItem>
        <br>
        <BlockTitle title="如何獲得額外點數" />
        <ListItem>
          <template #dot><div class="flex size-5 items-center justify-center rounded-full bg-major-800 text-[10px] text-white">1</div></template>
          <template #default>你可透過本網頁(Web)註冊一個 beanfun!帳號或下載beanfun! APP完成註冊。</template>
        </ListItem>
        <ListItem>
          <template #dot><div class="flex size-5 items-center justify-center rounded-full bg-major-800 text-[10px] text-white">2</div></template>
          <template #default>你可以在指定時間(每日晚上8~11點)直接開啟beanfun! APP就可額外領取3票，每帳號每日限領一次(限beanfun APP內可領取)。</template>
        </ListItem>
        <ListItem>
          <template #dot><div class="flex size-5 items-center justify-center rounded-full bg-major-800 text-[10px] text-white">3</div></template>
          <template #default>其他可額外獲得票數的指定任務，將不定期於投票頁公告。</template>
        </ListItem>
        <br>
        <BlockTitle title="其他說明" />
        <ListItem>
          <template #dot><div class="flex size-5 items-center justify-center rounded-full bg-major-800 text-[10px] text-white">1</div></template>
          <template #default>本投票活動統一以 beanfun! 帳號登入投票。</template>
        </ListItem>
        <ListItem>
          <template #dot><div class="bg-major-80text-[10px] 0 flex size-5 items-center justify-center rounded-full text-white">2</div></template>
          <template #default>每帳號每日僅能在單一渠道領票與投票；本網頁(Web)領票→本網頁(Web)投票、beanfun! APP 領票→beanfun! APP投票。如你當日已於本網頁(Web)登入領票與投票，就不能再到beanfun! APP 領票與投票。</template>
        </ListItem>
        <ListItem>
          <template #dot><div class="flex size-5 items-center justify-center rounded-full bg-major-800 text-[10px] text-white">3</div></template>
          <template #default>在本網頁(Web)投票，不可以投給同一人，在beanfun! APP 投票，沒有此限制。</template>
        </ListItem>
        <ListItem>
          <template #dot><div class="bg-major-80text-[10px] 0 flex size-5 items-center justify-center rounded-full text-white">4</div></template>
          <template #default>每帳號每日領取的票數，若未於當日晚上11:59前投完，剩餘票數將於當日晚上12:00失效。</template>
        </ListItem>
        <ListItem>
          <template #dot><div class="flex size-5 items-center justify-center rounded-full bg-major-800 text-[10px] text-white">5</div></template>
          <template #default>每帳號每日於本網頁(Web)最多可領 2 票(含)，在beanfun! APP 最多可領 10 票(含)。若你已於本網頁(Web)領票，就無法再到beanfun! APP 領票</template>
        </ListItem>
        <ListItem>
          <template #dot><div class="flex size-5 items-center justify-center rounded-full bg-major-800 text-[10px] text-white">6</div></template>
          <template #default>本活動票數顯示可能因為網路或其他因素導致無法即時更新，所有可領票數及可投票數，皆以系統判讀為準，不得異議。</template>
        </ListItem>
        <ListItem>
          <template #dot><div class="flex size-5 items-center justify-center rounded-full bg-major-800 text-[10px] text-white">7</div></template>
          <template #default>活動期間內若使用非法程式惡意灌票，經查證將把你的beanfun!帳號停權，也會導致無法參與投票或其他活動</template>
        </ListItem>
        <ListItem>
          <template #dot><div class="bg-major-80text-[10px] 0 flex size-5 items-center justify-center rounded-full text-white">8</div></template>
          <template #default>主辦單位保有最終修改、變更、活動解釋及取消本活動之權利，若有相關異動將會公告於網站，恕不另行通知。</template>
        </ListItem>
      </div>
    </div>

    <div class="container mb-2 bg-white">
      <Trigger title="活動辦法" @click="()=>{ state.active = 1 }" />
      <div v-if="state.active === 1" class="pb-4">
        <hr class="mb-4 border-major-800">
      </div>
    </div>

    <div class="container bg-white">
      <Trigger title="注意事項" @click="()=>{ state.active = 2 }" />
      <div v-if="state.active === 2" class="pb-4">
        <hr class="mb-4 border-major-800">
      </div>
    </div>
  </div>
</template>

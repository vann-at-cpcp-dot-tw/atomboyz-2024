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
const props = defineProps<IProps>()
const store = useStore()
</script>
<template>
  <Lightbox id="NeedLogin" icon="person-fill" title="尚未登入">
    <div class="mb-6">請您先登入會員再進行投票喔！</div>
    <div class="flex justify-end">
      <MajorButton class="h-[40px] max-w-[154px]">
        <div class="flex items-center">
          前往登入 <i class="bi bi-chevron-double-right block text-[14px] leading-none"></i>
        </div>
      </MajorButton>
    </div>
  </Lightbox>

  <Lightbox id="NeedVerify" icon="arrow-left-right" title="尚未完成會員雙重驗證">
    <div class="mb-6">為了增強您的帳戶安全，請您先至GAMAPASS會員中心完成Email 或 手機門號驗證再進行投票喔！</div>
    <div class="flex justify-end">
      <MajorButton class="h-[40px] max-w-[154px]">
        <div class="flex items-center">
          立即前往驗證 <i class="bi bi-chevron-double-right block text-[14px] leading-none"></i>
        </div>
      </MajorButton>
    </div>
  </Lightbox>

  <Lightbox id="VoteInput" icon="hand-thumbs-up-fill" title="原子少年2 ATOM BOYZ">
    <div class="mb-6">
      <div class="text-[18px] text-[#342F2F]">投票給 <span class="text-major">{{ store.myVoting.name || '-' }}</span> 選手</div>
      <div class="text-[15px] text-[#6B6B6B]">請選擇投票票數，點選確認後即送出投票。</div>
    </div>
    <div class="mx-auto w-full max-w-[312px]">
      <div class="mb-4 rounded-lg bg-[#C3C1F9] p-5">
        <div class="mx-auto w-full max-w-[250px]">
          <div class="flex !flex-nowrap">
            <!-- <input
            v-model.number="store.myVoting.votes"
            class="mr-2 h-[38px] shrink rounded pl-2"
            placeholder="請輸入投票票數"
            type="tel"
            inputmode="numeric"
            pattern="[0-9]*"
            @input="(e)=>{
              const value = (e.target as HTMLInputElement).value;
              const regex = /^[0-9]*$/;
              if (!regex.test(value)) {
                store.myVoting.votes = null
              }
            }"> -->
            <select v-model="store.myVoting.votes" class="mr-2 h-[38px] shrink rounded px-2">
              <option :value="null">請輸入投票票數</option>
              <option v-for="(node, index) in [...Array(store?.user?.votes || 0)]" :key="index" :value="index+1">{{ index+1 }}</option>
            </select>
            <div
            class="btn btn-scaleUp flex h-[38px] w-[95px] flex-none items-center justify-center rounded bg-major text-[15px] text-white"
            @click="()=>{
              store.do.voteConfirm()
            }">
              送出投票
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-6">
          <MajorButton
          class="h-[40px]"
          @click="store.do.voteConfirm()">
            <div class="flex items-center">
              投他 1 票 <i class="bi bi-chevron-double-right block text-[14px] leading-none"></i>
            </div>
          </MajorButton>
        </div>
        <div class="col-6">
          <MajorButton class="h-[40px]">
            <div class="flex items-center">
              剩下全投 <i class="bi bi-chevron-double-right block text-[14px] leading-none"></i>
            </div>
          </MajorButton>
        </div>
      </div>
    </div>
  </Lightbox>

  <Lightbox id="VoteConfirm" icon="exclamation-triangle-fill" title="請您再次確認投票資訊">
    <div class="mb-6">
      此次您將投票給 <span class="text-major">選手名稱</span>，總共 <span class="text-major"></span> 票，請再次確認您的投票票數，並點擊「確認」完成投票。
    </div>
    <div class="row justify-center lg:justify-end">
      <div class="col-6" style="max-width:140px;">
        <MajorButton class="bg-major-300">取消</MajorButton>
      </div>
      <div class="col-6" style="max-width:140px;">
        <MajorButton class="bg-major">確認</MajorButton>
      </div>
    </div>
  </Lightbox>
</template>

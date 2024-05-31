import { inject, provide } from 'vue'
import { shareFb, shareLine } from 'vanns-common-modules/dist/lib/helpers'
interface ConstructorFunction extends Function {
  new(...args: any[]): any;
}

export interface IUser {
  name: string
  votes: number | null
  avatar: string
  fav_peoples: {name:string, img?:string}[]
  daily_quests: {
    title: string
    reward: number
    description: string
    is_done: boolean
  }[]
  vote_logs: {
    name: string
    time: string
    votes: number
  }[]
}

export interface IAPIResponse {
  success?: boolean
  code?: string | number
  data?: {
    [key:string]: any
  }
}
export interface IStore {
  general: any
  isDownloadStickerShow: boolean
  isPreMode: boolean | undefined
  lightbox: string[]
  user: IUser | null
  myVoting: {
    name: string
    votes: number | null
  }
  trackingSender?: any
  do: {
    [key:string]: Function
  }
}

export const createStore = function(){
  const window = process.client ? globalThis : null
  const store = reactive<IStore>({
    general: {},
    isDownloadStickerShow: false,
    isPreMode: undefined,
    lightbox: [],
    myVoting: {
      name: '',
      votes: null
    },
    user: null,
    // user: {
    //   name: '1',
    //   votes: 15,
    //   avatar: '',
    //   fav_peoples: [],
    //   daily_quests: [],
    //   vote_logs: [],
    // },
    do: {
      lightboxAdd: (id:string)=>{
        store.lightbox.push(id)
      },
      lightboxRemove: (removeID:string)=>{
        store.lightbox = store.lightbox.filter(id=>id !== removeID)
      },
      lightboxClear: ()=>{
        store.lightbox = []
      },
      lightboxOpen: (id:string)=>{
        store.do.lightboxClear()
        store.lightbox.push(id)
      },
      updateUser: (updateData:IUser)=>{
        store.user = {
          ...(store.user || {}),
          ...(updateData || {})
        }
      },
      tracking: function(eventFunctionName:string, eventId:string|number, event:string, infos?:{
        page_info?: {[key:string]:any},
        click_info?: {[key:string]:any},
        impression_info?: {[key:string]:any},
      }){
        const TrackingFunction = (window as any).webTrackingSDK.events[eventFunctionName] as ConstructorFunction
        if (typeof TrackingFunction === 'function'){
          store.trackingSender.passEvent(
            new TrackingFunction({
              eventId,
              event,
              pageInfo: infos?.page_info,
              clickInfo: infos?.click_info,
              impressionInfo: infos?.impression_info,
            })
          )
        }
      },
      voteInput: function({ name, votes = null }:{name:string, votes?:number | null}){
        if (!store?.user?.name){
          store.do.lightboxOpen('NeedLogin')
          return
        }
        if (typeof store?.user?.votes === 'number' && store?.user?.votes <= 0){
          store.do.lightboxOpen('NoMoreVotes')
          return
        }
        store.myVoting.name = name
        store.myVoting.votes = votes
        store.do.lightboxOpen('VoteInput')
      },
      voteConfirm: function(args:{ name?:string, votes?:number | null }){
        store.myVoting = {
          ...store.myVoting,
          name: args?.name || store.myVoting.name,
          votes: (args?.votes && typeof args?.votes === 'number') ? args.votes : store.myVoting.votes,
        }
        nextTick(()=>{
          if (typeof store.user?.votes !== 'number' || typeof store.myVoting.votes !== 'number'){
            store.do.lightboxOpen('VoteFailed')
            return
          }

          if (store?.user?.votes < store.myVoting.votes){
            store.do.lightboxOpen('NoMoreVotes')
          }
          store.do.lightboxOpen('VoteConfirm')
        })
      },

      // 後端互動
      handleRes: function(res:any){
        if (res === 'not login'){
          store.do.lightboxOpen('NeedLogin')
          return true
        }
        if (res?.data?.user){
          store.do.updateUser(res.data.user)
        }
        return true
      },
      setUser: async(t:string)=>{
        const config = useRuntimeConfig()
        const API_URL = config.public.apiURL
        const result = await $fetch<IAPIResponse>(`${API_URL}/user`, {
          method: 'GET',
          params: {
            t,
          }
        })
        store.do.handleRes(result)

        if (result?.data?.user){
          store.user = result.data?.user
        }
        window?.localStorage?.setItem('t', t)
        return result
      },
      toggleFav: async function(name:string){
        const API_URL = useRuntimeConfig().public.apiURL
        const action = store.user?.fav_peoples?.map((node:any)=>node.name).includes(name) ? 'removeFav' : 'addFav'
        const result = await $fetch<IAPIResponse & {data:IUser}>(`${API_URL}/user`, {
          method: 'POST',
          params: {
            action,
            name,
            t: window?.localStorage?.getItem?.('t')
          }
        })
        store.do.handleRes(result)

        if (result?.success){
          if (action === 'addFav'){
            store.do.updateUser({
              fav_peoples: [
                ...(store?.user?.fav_peoples || []),
                {
                  name
                }
              ]
            })
          } else {
            store.do.updateUser({
              fav_peoples: store?.user?.fav_peoples?.filter(listNode=>listNode.name !== name) || []
            })
          }
        }

        return result
      },
      vote: async function(){
        const API_URL = useRuntimeConfig().public.apiURL
        const result = await $fetch<IAPIResponse>(`${API_URL}/user`, {
          method: 'POST',
          params: {
            action: 'vote',
            name: store.myVoting.name,
            votes: store.myVoting.votes,
            t: window?.localStorage?.getItem?.('t')
          }
        })
        store.do.handleRes(result)

        if (result?.code){
          switch (String(result?.code)){ // 1:下輪即將啟動，2:沒雙重驗證，3:票數不足，4:IP風險，5:其他原因失敗，總之就是失敗
            case '1':
              store.do.lightboxOpen('VoteComing')
              break
            case '2':
              store.do.lightboxOpen('NeedVerify')
              break
            case '3':
              store.do.lightboxOpen('NoMoreVotes')
              break
            case '4':
              store.do.lightboxOpen('IPWarning')
              break
            case '5':
              store.do.lightboxOpen('VoteFailed')
              break
          }
        }
        return result
      },
      share: async(data:{url:string, title?:string, text?:string}, shareTarget?:string)=>{
        const API_URL = useRuntimeConfig().public.apiURL
        if (window?.navigator?.canShare?.()){
          window?.navigator?.share?.(data)
        } else {
          switch (shareTarget){
            case 'fb':
              shareFb(data.url)
              break
            case 'line':
              shareLine(data.url)
              break
          }
        }

        const result = await $fetch<IAPIResponse>(`${API_URL}/user`, {
          method: 'POST',
          params: {
            action: 'share',
            t: window?.localStorage?.getItem('t')
          }
        })
        store.do.handleRes(result)

        return result
      },
    }
  })

  provide('store', store)

  return store
}

export const useStore = function(){
  const store = inject<IStore>('store')!
  return store
}

import { inject, provide } from 'vue'
interface ConstructorFunction extends Function {
  new(...args: any[]): any;
}

export interface IStore {
  general: any
  isDownloadStickerShow: boolean
  isPreMode: boolean | undefined
  lightbox: string[]
  alert: string,
  user: {
    id: string | number
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
    alert: '',
    myVoting: {
      name: '',
      votes: null
    },
    // user: null,
    user: {
      id: '',
      name: '1',
      votes: 15,
      avatar: '',
      fav_peoples: [],
      daily_quests: [],
      vote_logs: [],
    },
    do: {
      lightboxAdd: (id:string)=>{
        store.lightbox.push(id)
      },
      lightboxRemove: (removeID:string)=>{
        store.lightbox = store.lightbox.filter(id=>id !== removeID)
      },
      lightboxOpen: (id:string)=>{
        store.do.lightboxClear()
        store.lightbox.push(id)
      },
      lightboxClear: ()=>{
        store.lightbox = []
      },
      alert: function(content = ''){
        store.alert = content
        store.do.lightboxOpen('Alert')
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
      toggleFav: async function(name:string){
        if (!store.user?.name){
          return
        }
        const config = useRuntimeConfig()
        const API_URL = config.public.apiURL
        const action = store.user?.fav_peoples?.map((node:any)=>node.name).includes(name) ? 'removeFav' : 'addFav'
        const result = await $fetch(`${API_URL}/user.php`, {
          method: 'POST',
          params: {
            action,
            name
          }
        })
        if ((result as any)?.success){
          if (action === 'addFav'){
            store.user.fav_peoples = [
              ...(store?.user?.fav_peoples || []),
              {
                name
              }
            ]
          } else {
            store.user.fav_peoples = store.user.fav_peoples?.filter(listNode=>listNode.name !== name)
          }
        }
        return result
      },
      voteInput: function({ name, votes = null }:{name:string, votes?:number | null}){
        store.myVoting.name = name
        store.myVoting.votes = votes
        store.do.lightboxOpen('VoteInput')
      },
      voteConfirm: function({ name, votes }:{ name?:string, votes?:number | null }){
        store.myVoting = {
          ...store.myVoting,
          name: name || store.myVoting.name,
          votes: votes || store.myVoting.votes,
        }
        store.do.lightboxOpen('VoteConfirm')
      },
      vote: function(number:number){

      },
      share: function(url:string){

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

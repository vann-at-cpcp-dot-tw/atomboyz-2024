import { inject, provide } from 'vue'
import { shareFb, shareLine } from 'vanns-common-modules/dist/lib/helpers'
import queryString from 'query-string'
import { calculateRemainingTime } from '~/lib/helpers'
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

type EventFunctionName = 'PageViewEvent'|'ClickEvent'|'ImpressionEvent'|'SearchEvent'
type EventId = '55001'|'55002'|'55003'|'55004'
type Event = 'hidol_campaign_page_view'|'hidol_campaign_item_click'|'hidol_campaign_item_click'|'hidol_campaign_impression'
export interface ITrackingInfos {
  page_info?: {
    page?: string
    type?: string
    sec?: string
    name?: string
  },
  click_info?: {
    name?: string
    type?: string
    sec?: string
  },
  impression_info?: {[key:string]:any},
}
export interface IStore {
  general: any
  bottomStickyHeight: number | undefined
  isPreMode: boolean | undefined
  trackingPageName: string
  lightbox: string[]
  user: IUser | null
  voteAjaxing: boolean,
  isNotInGetVotesTimeAlerted: boolean
  myVoting: {
    name: string
    votes: number | null
  }
  trackingSender?: any
  do: {
    [key:string]: Function
    tracking: (eventFunctionName:EventFunctionName, eventId:EventId, event:Event, infos?:ITrackingInfos)=>boolean
  }
}

export const createStore = function(){
  const window = process.client ? globalThis : null
  const store = reactive<IStore>({
    general: {},
    bottomStickyHeight: undefined,
    isPreMode: undefined,
    isNotInGetVotesTimeAlerted: false,
    trackingPageName: '/',
    lightbox: [],
    voteAjaxing: false,
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
      tracking: function(eventFunctionName:EventFunctionName, eventId:EventId, event:Event, infos?:ITrackingInfos){
        const TrackingFunction = (window as any).webTrackingSDK.events[eventFunctionName] as ConstructorFunction
        if (
          typeof TrackingFunction === 'function' &&
          typeof store.trackingSender?.passEvent === 'function'
        ){
          store.trackingSender.passEvent(
            new TrackingFunction({
              eventId,
              event,
              pageInfo: {
                page: store.trackingPageName,
                ...(infos?.page_info || {})
              },
              clickInfo: infos?.click_info,
              impressionInfo: infos?.impression_info,
            })
          )
        }
        return true
      },
      isNotVoteDate: function(){
        if (typeof store.general?.countdown_end_time === 'string'){
          if (store.general.countdown_end_time.length === 0){
            return true
          }

          const [year, month, date, hour, minute] = store.general.countdown_end_time.split('-')
          const countdown = calculateRemainingTime({
            year,
            month,
            date,
            hour,
            minute,
          })
          const countdownTotal = Number(countdown.days) + Number(countdown.hours) + Number(countdown.minutes) + Number(countdown.seconds)
          return countdownTotal <= 0
        }
        return false
      },
      canVote: function(){
        if (!store?.user?.name){
          store.do.lightboxOpen('NeedLogin')
          return false
        }

        if (store.do.isNotVoteDate()){
          store.do.lightboxOpen('VoteComing')
          return false
        }

        return true
      },
      voteInput: function({ name, votes = null }:{name:string, votes?:number | null}){
        if (!store.do.canVote()){
          return
        }

        if (Number((store?.user?.votes || 0) <= 0)){
          store.do.lightboxOpen('NoMoreVotes')
          return
        }

        store.myVoting.name = name
        store.myVoting.votes = votes
        store.do.lightboxOpen('VoteInput')
      },
      voteConfirm: function(args:{ name?:string, votes?:number | null }){
        if (!store.do.canVote()){
          return
        }

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
        if (res?.pop_vote_block && store.isNotInGetVotesTimeAlerted === false){
          store.isNotInGetVotesTimeAlerted = true
          store.do.lightboxOpen('IsNotInGetVotesTime')
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
        if (store.voteAjaxing){
          return
        }

        if (!store.do.canVote()){
          return
        }

        store.voteAjaxing = true
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
        store.voteAjaxing = false
        return result
      },
      genShareURL: (routeName:string, shareTarget?:string)=>{
        switch (routeName){
          case 'index':
            switch (shareTarget){
              case 'fb':
                return 'https://hidol.fan/metT7'
              case 'line':
                return 'https://hidol.fan/g0AGU'
              default:
                return 'https://hidol.fan/wSmqD'
            }
          case 'vote':
            switch (shareTarget){
              case 'fb':
                return 'https://hidol.fan/mlmjk'
              case 'line':
                return 'https://hidol.fan/O6luv'
              default:
                return 'https://hidol.fan/LNLHt'
            }
          default:
            return null
        }
      },
      share: async(routeName:string, data?:{url?:string, title?:string, text?:string}, shareTarget?:string)=>{
        const API_URL = useRuntimeConfig().public.apiURL
        if (!window){ return }

        const pureURL = data?.url?.split('?')?.[0] || store.do.genShareURL(routeName, shareTarget) || `${window.location.protocol}//${window.location.host}${window.location.pathname}${window.location.hash}`
        let queryObject = queryString.parse(location.search)
        queryObject = {
          ...queryObject,
          utm_medium: 'link',
          utm_campaign: 'atomboyz2'
        }

        let shareURL = pureURL.includes('https://hidol.fan/') ? pureURL : ''

        console.log('can share', window?.navigator?.canShare?.())
        // if (window?.navigator?.canShare?.()){
        if (!shareTarget){
          queryObject.utm_source = 'builtin'
          shareURL = shareURL || `${pureURL}?${queryString.stringify(queryObject)}`
          window?.navigator?.share?.({
            ...(data || {}),
            url: shareURL
          }).then(()=>console.log('Successful share'))
            .catch(error=>console.log('Error sharing:', error))
        } else {
          switch (shareTarget){
            case 'fb':
              queryObject.utm_source = 'facebook'
              shareURL = shareURL || `${pureURL}?${queryString.stringify(queryObject)}`
              shareFb(shareURL)
              break
            case 'line':
              queryObject.utm_source = 'line'
              shareURL = shareURL || `${pureURL}?${queryString.stringify(queryObject)}`
              shareLine(shareURL)
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

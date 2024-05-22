import { inject, provide } from 'vue'

export interface IStore {
  general: any
  isDownloadStickerShow: boolean
  lightbox: string[]
  alert: string,
  user: {
    id: string | number
    name: string
    votes: number | null
  } | null
  myVoting: {
    name: string
    votes: number | null
  }
  do: {
    [key:string]: Function
  }
}

export const createStore = function(){
  const window = process.client ? globalThis : null
  const store = reactive<IStore>({
    general: {},
    isDownloadStickerShow: false,
    lightbox: [],
    alert: '',
    myVoting: {
      name: '',
      votes: null
    },
    user: null,
    // user: {
    //   id: '',
    //   name: '',
    //   votes: 15,
    // },
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

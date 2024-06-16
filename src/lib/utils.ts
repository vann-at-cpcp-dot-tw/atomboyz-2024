import { type ClassValue, clsx } from 'clsx'
import { twMerge } from 'tailwind-merge'

export const teams = [
  {
    id: 1,
    tagId: 'light',
    name: '晨之星',
    getImg: ()=>{
      const APP_BASE = useRuntimeConfig().public.appBase
      return `${APP_BASE}assets/img/team_1.png`
    },
    description: '晨星是最遙遠的恆星，距離地球280億光年，它發出的光要花129億年才能到達地球。',
  },
  {
    id: 2,
    name: '天狼星',
    tagId: 'night',
    getImg: ()=>{
      const APP_BASE = useRuntimeConfig().public.appBase
      return `${APP_BASE}assets/img/team_2.png`
    },
    description: '當我們抬起頭看，夜空中最亮的恆星，距離地球8.6光年，比太陽還亮25倍。',
  },
  {
    id: 3,
    name: '風行者',
    tagId: 'wind',
    getImg: ()=>{
      const APP_BASE = useRuntimeConfig().public.appBase
      return `${APP_BASE}assets/img/team_3.png`
    },
    description: 'HD 189733 b，距離地球63光年的系外行星，以強烈的炫風聞名，風速達每小時8700公里。',
  },
  {
    id: 4,
    name: '克卜勒',
    tagId: 'flame',
    getImg: ()=>{
      const APP_BASE = useRuntimeConfig().public.appBase
      return `${APP_BASE}assets/img/team_4.png`
    },
    description: '克卜勒70b，距離地球4200光年的系外行星，表面溫度高達攝氏6900度，比太陽還熱。',
  },
  {
    id: 5,
    name: '鑽石星球',
    tagId: 'ice',
    getImg: ()=>{
      const APP_BASE = useRuntimeConfig().public.appBase
      return `${APP_BASE}assets/img/team_5.png`
    },
    description: 'BPM37093，距離地球52光年，是一顆冷卻後的恆星，核心存在大量碳晶體，相當於1x10 34克拉的鑽石。',
  },
  {
    id: 6,
    name: '小行星',
    tagId: 'dune',
    getImg: ()=>{
      const APP_BASE = useRuntimeConfig().public.appBase
      return `${APP_BASE}assets/img/team_6.png`
    },
    description: 'SDSS J1228+1040 b，已知最小的系外行星，距離地球413光年，周圍是由沙礫與塵埃組成的星環。',
  },
]
export function routeNameToTrackingPageName(routePath:'/'|'/vote'|'/posts/video'|'/posts/news'|string){
  if (routePath.includes('/post/')){
    return 'atomboyz_news_article'
  }
  return {
    '/': 'atomboyz_homepage',
    '/vote': 'atomboyz_vote',
    '/posts/video': 'atomboyz_videos',
    '/posts/news': 'atomboyz_news',
  }[routePath]
}
export function cn(...inputs: ClassValue[]){
  return twMerge(clsx(inputs))
}

export const convertYoutubeUrlToEmbed = function(input:string){
  let youtubeID

  if (input?.includes?.('https://youtu.be/')){
    youtubeID = input.replace('https://youtu.be/', '').split('?si')?.[0]
  } else if (input?.includes?.('https://www.youtube.com/watch?v=')){
    youtubeID = input.replace('https://www.youtube.com/watch?v=', '').split('&')[0]
  }

  if (youtubeID){
    return {
      cover: `https://img.youtube.com/vi/${youtubeID}/0.jpg`,
      embedURL: `https://www.youtube.com/embed/${youtubeID}`
    }
  }

  return null
}

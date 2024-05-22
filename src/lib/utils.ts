import { type ClassValue, clsx } from 'clsx'
import { twMerge } from 'tailwind-merge'

export const teams = [
  {
    id: 1,
    name: '晨之星',
    img: '/assets/img/team_1.png',
    description: 'SDSS J1228+1040 b，已知最小的系外行星，距離地球413光年，周圍是由沙礫與塵埃組成的星環。',
  },
  {
    id: 2,
    name: '天狼星',
    img: '/assets/img/team_2.png',
    description: 'SDSS J1228+1040 b，已知最小的系外行星，距離地球413光年，周圍是由沙礫與塵埃組成的星環。',
  },
  {
    id: 3,
    name: '風行者',
    img: '/assets/img/team_3.png',
    description: 'SDSS J1228+1040 b，已知最小的系外行星，距離地球413光年，周圍是由沙礫與塵埃組成的星環。',
  },
  {
    id: 4,
    name: '克卜勒',
    img: '/assets/img/team_4.png',
    description: 'SDSS J1228+1040 b，已知最小的系外行星，距離地球413光年，周圍是由沙礫與塵埃組成的星環。',
  },
  {
    id: 5,
    name: '鑽石星球',
    img: '/assets/img/team_5.png',
    description: 'SDSS J1228+1040 b，已知最小的系外行星，距離地球413光年，周圍是由沙礫與塵埃組成的星環。',
  },
  {
    id: 6,
    name: '小行星',
    img: '/assets/img/team_6.png',
    description: 'SDSS J1228+1040 b，已知最小的系外行星，距離地球413光年，周圍是由沙礫與塵埃組成的星環。',
  },
]

export function cn(...inputs: ClassValue[]){
  return twMerge(clsx(inputs))
}

export const convertYoutubeUrlToEmbed = function(input:string){
  let youtubeID

  if (input.includes('https://youtu.be/')){
    youtubeID = input.replace('https://youtu.be/', '').split('?si')[0]
  } else if (input.includes('https://www.youtube.com/watch?v=')){
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

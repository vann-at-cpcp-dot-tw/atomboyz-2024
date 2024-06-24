import queryString from 'query-string'
import { parse } from 'query-string/base'

export * from 'vanns-common-modules/dist/lib/helpers'

export const scrollToSection2 = function({ el, offset = 0, jump = false }:any, callback?:Function){
  if (el){
    const targetRect = el.getBoundingClientRect()
    const targetTop = targetRect.top + window.pageYOffset
    const top = (targetTop - Number((document?.body?.style?.paddingTop?.split?.('px')?.[0] || 0)) + offset).toFixed()
    const onScroll = function(){
      if (window.pageYOffset.toFixed() === top){
        window.removeEventListener('scroll', onScroll)
        callback?.()
      }
    }
    window.addEventListener('scroll', onScroll)
    onScroll()
    window.scrollTo({
      top,
      behavior: jump === true ? undefined : 'smooth'
    })
  }
}

// export function calculateRemainingTime(
//   futureTime:{
//     year: string
//     month: string
//     date: string
//     hour: string
//     minute: string
//   },
//   timezone = 'Asia/Taipei'
// ){
//   // 獲取客戶端當前時間
//   const now = new Date()

//   // 將輸入時間轉換為指定時區的日期物件
//   const future = new Date(
//     `${futureTime.month}/${futureTime.date}/${futureTime.year} ${futureTime.hour}:${futureTime.minute}`
//   )
//   const futureTimeInTimezone = new Date(
//     future.toLocaleString('en-US', { timeZone: timezone })
//   )

//   // 計算當前時間與輸入時區的時間差
//   const diff = futureTimeInTimezone.getTime() - now.getTime()
//   const days = Math.floor(diff / (1000 * 60 * 60 * 24))
//   const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))
//   const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60))
//   const seconds = Math.floor((diff % (1000 * 60)) / 1000)

//   return {
//     days: String(days).padStart(2, '0'),
//     hours: String(hours).padStart(2, '0'),
//     minutes: String(minutes).padStart(2, '0'),
//     seconds: String(seconds).padStart(2, '0'),
//   }
// }

export function calculateRemainingTime(futureTime: {
  year: string;
  month: string;
  date: string;
  hour: string;
  minute: string;
  second: string;
}, timezone = 'Asia/Taipei'){
  // 獲取客戶端當前時間
  const now = new Date()

  // 將輸入時間轉換為指定時區的日期物件
  const future = new Date(`${futureTime.month}/${futureTime.date}/${futureTime.year} ${futureTime.hour}:${futureTime.minute}:${futureTime.second}`)

  const futureTimeInTimezone = new Date(future.toLocaleString('en-US', { timeZone: timezone }))

  // 計算當前時間與輸入時區的時間差
  const diff = futureTimeInTimezone.getTime() - now.getTime()
  const days = Math.floor(diff / (1000 * 60 * 60 * 24))
  const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))
  const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60))
  const seconds = Math.floor((diff % (1000 * 60)) / 1000)

  return {
    days: String(days).padStart(2, '0'),
    hours: String(hours).padStart(2, '0'),
    minutes: String(minutes).padStart(2, '0'),
    seconds: String(seconds).padStart(2, '0'),
  }
}

export async function copyUrlToClipboard(copyString?:string){
  try {
    let queryObject = queryString.parse(location.search)
    queryObject = {
      ...queryObject,
      utm_source: 'other',
      utm_medium: 'link',
      utm_campaign: 'atomboyz2'
    }
    const url = `${window.location.protocol}//${window.location.host}${window.location.pathname}${window.location.hash}?${queryString.stringify(queryObject)}`

    if (copyString){
      await navigator.clipboard.writeText(copyString)
    } else {
      await navigator.clipboard.writeText(url)
    }

    alert('複製成功！')
  } catch (err){
    console.error('Failed to copy text: ', err)
  }
};

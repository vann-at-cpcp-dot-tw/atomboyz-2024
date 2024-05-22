export * from 'vanns-common-modules/dist/lib/helpers'

export function calculateRemainingTime(
  futureTime:{
    year: string
    month: string
    date: string
    hour: string
    minute: string
  },
  timezone = 'Asia/Taipei'
){
  // 獲取客戶端當前時間
  const now = new Date()

  // 將輸入時間轉換為指定時區的日期物件
  const future = new Date(
    `${futureTime.month}/${futureTime.date}/${futureTime.year} ${futureTime.hour}:${futureTime.minute}`
  )
  const futureTimeInTimezone = new Date(
    future.toLocaleString('en-US', { timeZone: timezone })
  )

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

export async function copyUrlToClipboard(){
  try {
    await navigator.clipboard.writeText(window.location.href)
    alert('複製成功！')
  } catch (err){
    console.error('Failed to copy text: ', err)
  }
};

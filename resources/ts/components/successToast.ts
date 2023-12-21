import { SuccessToast } from '../utils/toastUtils'

export default function (element: Element): void {
  const meta = element as HTMLMetaElement

  const successArray: string[] = JSON.parse(meta.content)
  if (successArray.length === 0) {
    return
  }
  if (successArray.length === 1) {
    void SuccessToast.fire({
      title: successArray[0],
      timer: 8000 * successArray.length
    })
  }

  if (successArray.length > 1) {
    const successInline = successArray.map((val) => '• ' + val).reduce((prev, current) => {
      return prev + '\n\n' + current
    })
    void SuccessToast.fire({
      title: successInline,
      timer: 8000 * successArray.length
    })
  }
}

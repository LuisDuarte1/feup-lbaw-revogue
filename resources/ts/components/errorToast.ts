import { ErrorToast } from '../utils/toastUtils'

export default function (element: Element): void {
  const meta = element as HTMLMetaElement

  const errorArray: string[] = JSON.parse(meta.content)
  if (errorArray.length === 0) {
    return
  }
  if (errorArray.length === 1) {
    void ErrorToast.fire({
      title: errorArray[0],
      timer: 8000 * errorArray.length
    })
  }

  if (errorArray.length > 1) {
    const errorInline = errorArray.map((val) => '• ' + val).reduce((prev, current) => {
      return prev + '\n\n' + current
    })
    void ErrorToast.fire({
      title: errorInline,
      timer: 8000 * errorArray.length
    })
  }
}

import Swal from 'sweetalert2'

export const Toast = Swal.mixin({
  toast: true,
  position: 'top-right',
  timer: 800000,
  timerProgressBar: true,
  showConfirmButton: false,
  showCloseButton: true
})

export const ErrorToast = Toast.mixin({
  icon: 'error'
})

export const SuccessToast = Toast.mixin({
  icon: 'success'
})

export async function handleRequestErrorToast (response: Response): Promise<void> {
  if (response.status >= 500 && response.status <= 599) {
    console.log(`Will not handle ${response.status} responses to error toast.. sending a generic one`)
    void ErrorToast.fire('Something wrong happened... Please try again later.')
  }

  const errorJson = await response.json()
  if ((typeof errorJson.error) === 'string') {
    void ErrorToast.fire(errorJson.error)
  } else {
    // it returns a validator object so we need to parse it
    const errorArray: string[] = Object.values(errorJson.error).flat() as string[]
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
}

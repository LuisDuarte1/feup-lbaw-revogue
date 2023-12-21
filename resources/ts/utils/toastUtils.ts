import Swal from 'sweetalert2'

export const Toast = Swal.mixin({
  toast: true,
  position: 'top-right',
  timer: 8000,
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

import Swal from 'sweetalert2'

export default async function (element: HTMLElement): Promise<void> {
  const meta = element as HTMLMetaElement
  const title = meta.title
  const content = meta.content
  const confirmButtonText = meta.getAttribute('confirm-button')
  if (confirmButtonText === null) {
    return
  }
  await Swal.fire({
    title,
    text: content,
    icon: 'error',
    confirmButtonText,
    confirmButtonColor: '#B794B8'
  })
}

import Swal from 'sweetalert2'
import { createFormData } from '../utils/csrf'

export default function sendReport (element: HTMLElement): void {
  const elem = element
  const type = elem.dataset.type
  const id = elem.dataset.id
  if (type === undefined || id === undefined) {
    throw Error("Couldn't find report button")
  }
  elem.addEventListener('click', async () => {
    const reason = await Swal.fire<string>({
      title: 'Report ' + type,
      input: 'textarea',
      confirmButtonText: 'Send',
      showCloseButton: true,
      confirmButtonColor: '#B794B8'
    })

    if (!reason.isConfirmed || reason.value === undefined) {
      console.log('User did not confirm send or input is null so we skip it')
      return
    }
    if (reason.value === '') {
      return
    }
    console.log(reason.value)
    const form = createFormData()
    form.set('reason', reason.value)

    if (type === 'product') {
      const req = await fetch(`/products/${id}/report`, { method: 'POST', body: form })
      window.location.href = req.url
      if (req.status !== 200) {
        console.error(`Report failed with status ${req.status}`)
      }
    } else if (type === 'user') {
      const req = await fetch(`/profile/${id}/report`, { method: 'POST', body: form })
      window.location.href = req.url
      if (req.status !== 200) {
        console.error(`Report failed with status ${req.status}`)
      }
    } else if (type === 'message_thread') {
      const req = await fetch('/messages/report', { method: 'POST', body: form })
      window.location.href = req.url
      if (req.status !== 200) {
        console.error(`Report failed with status ${req.status}`)
      }
    } else {
      throw Error(`Unknown type ${type}`)
    }
  })
}

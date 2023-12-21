import Swal from 'sweetalert2'
import { createFormData } from '../utils/csrf'

export default function sendReport (element: HTMLElement): void {
  const elem = element
  let type = elem.dataset.type
  const id = elem.dataset.id
  if (type === undefined || id === undefined) {
    throw Error("Couldn't find report button")
  } else if (type === 'message_thread') {
    type = 'message thread'
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
      const req = await fetch(`/api/products/${id}/report`, { method: 'POST', body: form })
      if (req.status !== 200) {
        console.error(`Report failed with status ${req.status}`)
      }
    } else if (type === 'user') {
      const req = await fetch(`/api/profile/${id}/report`, { method: 'POST', body: form })

      if (req.status !== 200) {
        console.error(`Report failed with status ${req.status}`)
      }
    } else if (type === 'message thread') {
      const req = await fetch(`/api/messages/${id}/report`, { method: 'POST', body: form })
      if (req.status !== 200) {
        console.error(`Report failed with status ${req.status}`)
      }
    } else {
      throw Error(`Unknown type ${type}`)
    }
  })
}

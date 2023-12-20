import Swal from 'sweetalert2'
import { fetchWithSocketInformation } from '../utils/fetchUtils'
import { createFormData } from '../utils/csrf'

export default function (element: Element): void {
  const orderId = element.getAttribute('data-order-id')
  if (orderId === null) {
    throw Error('Could not find orderId')
  }

  element.addEventListener('click', async () => {
    const statusRes = await fetch(`/api/orders/${orderId}/possibleStatus`)

    if (statusRes.status !== 200) {
      console.error(`Possible Order Status request failed with ${statusRes.status}`)
      return
    }

    const status = await statusRes.json()

    if (status.statusChange === null) {
      console.log('No possible status for the current order state')
      return
    }

    if (status.statusChange === 'shipped') {
      const confirmation = await Swal.fire({
        title: 'Mark order as shipped',
        text: 'Are you sure that you want to mark this order as shipped? This action cannot be undone.',
        showConfirmButton: true,
        confirmButtonText: 'Confirm',
        showDenyButton: true,
        denyButtonText: 'Deny'
      })

      if (!confirmation.isConfirmed) return
    }
    if (status.statusChange === 'received') {
      const confirmation = await Swal.fire({
        title: 'Mark order as received',
        text: 'Are you sure that you want to mark this order as received? This action cannot be undone.',
        showConfirmButton: true,
        confirmButtonText: 'Confirm',
        showDenyButton: true,
        denyButtonText: 'Deny'
      })

      if (!confirmation.isConfirmed) return
    }
    const formBody = createFormData()
    formBody.set('new_status', status.statusChange)
    const req = await fetchWithSocketInformation(`/api/orders/${orderId}/status`, { method: 'POST', body: formBody })
    if (req.status !== 200) {
      console.log(`Change order status to shipping failed with status ${req.status}`)
    }
    // TODO (luisd): make success toast
  })
}

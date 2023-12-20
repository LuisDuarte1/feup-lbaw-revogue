import Swal from 'sweetalert2'
import { fetchWithSocketInformation } from '../utils/fetchUtils'
import { componentAJAXHandler } from '../app'

export default function (element: Element): void {
  const orderId = element.getAttribute('data-order-id')
  if (orderId === null) {
    throw Error('Could not find orderId')
  }

  const messageThreadContent = document.querySelector('.message-thread-content')
  if (messageThreadContent === null) {
    throw Error("Couldn't get message thread content")
  }
  const threadId = messageThreadContent.getAttribute('data-thread-id')
  if (threadId === null) {
    throw Error("Couldn't get data-thread-id")
  }

  element.addEventListener('click', async () => {
    const orderStatusRes = await fetch(`/api/orders/${orderId}/status`)

    if (orderStatusRes.status !== 200) {
      console.error(`Order status request failed with status ${orderStatusRes.status}`)
      return
    }

    const orderStatus = await orderStatusRes.json()

    if (orderStatus.status !== 'pendingShipment') {
      // TODO (luisd): show error toast
      console.log('Order is not in pending shipment state skipping...')
      return
    }

    const confirmation = await Swal.fire({
      title: 'Request cancellation',
      text: 'Are you sure that you want to request cancellation of this order? This action cannot be undone.',
      confirmButtonText: 'Confirm',
      showConfirmButton: true,
      denyButtonText: 'Deny',
      showDenyButton: true
    })

    if (!confirmation.isConfirmed) return

    const res = await fetchWithSocketInformation(`/api/messages/${threadId}/cancellation`, { method: 'POST' })
    if (res.status !== 200) {
      console.error(`Bargain send request failed with status ${res.status}`)
      return
    }
    const html = document.createElement('html')
    html.innerHTML = await res.text()
    const element = html.querySelector('.message-bubble')
    if (element === null) {
      throw Error("Couldn't find message bubble")
    }
    messageThreadContent.append(element)
    messageThreadContent.parentElement?.scrollTo({ top: messageThreadContent.parentElement?.scrollHeight, behavior: 'instant' })
    componentAJAXHandler([element])
  })
}

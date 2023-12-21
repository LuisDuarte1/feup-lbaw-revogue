import Swal from 'sweetalert2'
import { createFormData } from '../utils/csrf'
import { fetchWithSocketInformation } from '../utils/fetchUtils'
import { componentAJAXHandler } from '../app'
import { handleRequestErrorToast } from '../utils/toastUtils'

export default function (element: Element): void {
  const messageThreadContent = document.querySelector('.message-thread-content')
  if (messageThreadContent === null) {
    throw Error("Couldn't get message thread content")
  }
  const threadId = messageThreadContent.getAttribute('data-thread-id')
  if (threadId === null) {
    throw Error("Couldn't get data-thread-id")
  }

  const productId = element.getAttribute('data-product-id')
  if (productId === null) {
    throw Error("Couldn't get data-product-id")
  }
  element.addEventListener('click', async () => {
    const productRes = await fetch(`/api/products/${productId}`)
    if (productRes.status !== 200) {
      console.error(`Product get failed with status ${productRes.status}`)
      await handleRequestErrorToast(productRes)
      return
    }
    const product = await productRes.json()
    const price = parseFloat(product.price)

    const proposedPrice = await Swal.fire<number>({
      title: 'Propose Bargain',
      showCloseButton: true,
      confirmButtonText: 'Send',
      html: `
        <div class="popup-propose-bargain column gap-3 items-center">
            <h3>Current Price: ${price}€</h3>
            <div class="row gap-2 items-center">
                <label for="bargain-price" required>
                    Price:
                </label>
                <input type="numeric" id="bargain-price" max="${price}" min="0" value="${price}">
            </div>
        </div>
      `,
      preConfirm: () => {
        const bargainPrice: HTMLInputElement | null = document.querySelector('#bargain-price')
        if (bargainPrice === null) {
          throw Error('Could not find bargain price')
        }
        if (!bargainPrice.checkValidity()) {
          Swal.showValidationMessage('Please insert a valid bargain price')
          return false
        }
        return Number.parseFloat(bargainPrice.value)
      }
    })

    if (proposedPrice.isConfirmed && proposedPrice.value !== undefined) {
      const formData = createFormData()
      formData.set('proposed_price', proposedPrice.value.toString())
      const res = await fetchWithSocketInformation(`/api/messages/${threadId}/bargain`, { method: 'POST', body: formData })
      if (res.status !== 200) {
        console.error(`Bargain send request failed with status ${res.status}`)
        await handleRequestErrorToast(res)
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
    }
  })
}

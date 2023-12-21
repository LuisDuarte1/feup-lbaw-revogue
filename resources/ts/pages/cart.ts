import { handleRequestErrorToast } from '../utils/toastUtils'

function deleteProductHandler (parent: Element): (event: Event) => Promise<void> {
  return async (event: Event) => {
    const dataId = Number.parseInt(parent.attributes.getNamedItem('data-id')?.value ?? '-1')
    if (dataId === -1) {
      return
    }
    const req = await fetch('/api/cart', {
      method: 'DELETE',
      body: JSON.stringify({ product: dataId }),
      headers: {
        'Content-Type': 'application/json'
      }
    })
    if (req.status === 404) {
      return
    }
    if (req.status !== 200) {
      console.error(`Remove from cart failed with status ${req.status}`)
      await handleRequestErrorToast(req)
    }
    parent.remove()
    // TODO(luisd): insert empty message when removing🚬
    // TODO(luisd): update count and total price🚬
  }
}

function deleteProduct (): void {
  const products = document.querySelectorAll('.product')
  products.forEach((value) => {
    const a: HTMLAnchorElement | null = value.querySelector('.product-remove')
    if (a === null) {
      return
    }
    a.onclick = deleteProductHandler(value)
  })
}

export function cart (): void {
  window.history.replaceState(null, '', window.location.pathname)
  deleteProduct()
}

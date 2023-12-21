import { handleRequestErrorToast } from '../utils/toastUtils'

function updateSum (dataPrice: number): void {
  const sumElements = document.querySelectorAll('.price-sum')
  sumElements.forEach((sumElement) => {
    const currentSum = Number.parseFloat(sumElement.textContent ?? '0')
    sumElement.textContent = ((currentSum - dataPrice)).toFixed(2).toString()
  })
}

function updateNumberOfProducts (): void {
  const numberOfProducts = document.querySelectorAll('.product').length
  const numberOfProductsElement = document.querySelector('.number-of-products')
  if (numberOfProductsElement !== null) {
    numberOfProductsElement.textContent = numberOfProductsElement.textContent?.replace(/\d+/, numberOfProducts.toString()) ?? null
  }
}

function removeProductAndSellerDiv (parent: Element): void {
  const sellerProductsDiv = parent.closest('.seller-products')
  const orders = document.querySelector('.number-of-orders')
  parent.remove()
  if (sellerProductsDiv !== null) {
    if (sellerProductsDiv.querySelector('.product') === null) {
      sellerProductsDiv.remove()
      if (orders !== null) {
        const numberOfOrders = Number.parseInt(orders.textContent ?? '0')
        orders.textContent = orders.textContent?.replace(/\d+/, (numberOfOrders - 1).toString()) ?? null
      }
    }
  }
}
function deleteProductHandler (parent: Element): (event?: Event) => Promise<void> {
  return async (event?: Event) => {
    const dataId = Number.parseInt(parent.attributes.getNamedItem('data-id')?.value ?? '-1')
    const dataPrice = Number.parseFloat(parent.attributes.getNamedItem('data-price')?.value ?? '-1')
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
    removeProductAndSellerDiv(parent)
    updateSum(dataPrice)
    updateNumberOfProducts()
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

function deleteAllProductsFromSellerButton (): void {
  const buttons = document.querySelectorAll('.remove-all-button')
  buttons.forEach((button) => {
    button.addEventListener('click', async () => {
      const sellerId = button.getAttribute('data-seller-id')
      const sellerProductsDiv = document.querySelector(`.seller-products[data-seller-id="${sellerId}"]`)
      if (sellerProductsDiv !== null) {
        const products = sellerProductsDiv.querySelectorAll('.product')
        // eslint-disable-next-line @typescript-eslint/promise-function-async
        const promises = Array.from(products).map((product) => deleteProductHandler(product)(undefined))
        await Promise.all(promises)
      }
    })
  })
}
export function cart (): void {
  window.history.replaceState(null, '', window.location.pathname)
  deleteProduct()
  deleteAllProductsFromSellerButton()
}

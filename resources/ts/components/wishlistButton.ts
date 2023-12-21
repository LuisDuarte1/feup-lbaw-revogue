import { handleRequestErrorToast } from '../utils/toastUtils'

async function removeFromWishlist (productId: Number, wishlist: HTMLDivElement): Promise<void> {
  const req = await fetch('/api/wishlist', {
    method: 'DELETE',
    body: JSON.stringify({ product: productId }),
    headers: {
      'Content-Type': 'application/json'
    }
  })
  if (req.status !== 200) {
    console.error(`Add to cart failed with status ${req.status}`)
    await handleRequestErrorToast(req)
    return
  }
  const icon = wishlist.querySelector('ion-icon')
  if (icon === null) {
    return
  }
  const name = icon.getAttribute('name')
  if (name === null) {
    return
  }
  if (name === 'heart') {
    icon.setAttribute('name', 'heart-outline')
  } else {
    icon.setAttribute('name', 'heart')
  }
  wishlist.onclick = (event) => {
    event.stopPropagation()
    event.preventDefault()
    void addToWishlist(productId, wishlist)
    return false
  }
}

async function addToWishlist (productId: Number, wishlist: HTMLDivElement): Promise<void> {
  const req = await fetch('/api/wishlist', {
    method: 'POST',
    body: JSON.stringify({ product: productId }),
    headers: {
      'Content-Type': 'application/json'
    }
  })
  if (req.status !== 200) {
    console.error(`Add to cart failed with status ${req.status}`)
    await handleRequestErrorToast(req)
    return
  }
  const icon = wishlist.querySelector('ion-icon')
  if (icon === null) {
    return
  }
  const name = icon.getAttribute('name')
  if (name === null) {
    return
  }
  if (name === 'heart') {
    icon.setAttribute('name', 'heart-outline')
  } else {
    icon.setAttribute('name', 'heart')
  }
  wishlist.onclick = (event) => {
    event.stopPropagation()
    event.preventDefault()
    void removeFromWishlist(productId, wishlist)
    return false
  }
}

export default function (wishlist: HTMLElement): void {
  if (!(wishlist instanceof HTMLDivElement)) {
    return
  }
  const inWishlist = wishlist.getAttribute('data-inWishlist')
  const productId = Number.parseInt(wishlist.getAttribute('data-productId') ?? '-1')

  if (productId === -1) {
    console.error('No productId found')
  }
  if (inWishlist == null) {
    console.error('No data-inWishlist found')
    return
  }

  if (inWishlist === 'false') {
    wishlist.onclick = (event) => {
      event.stopPropagation()
      event.preventDefault()
      void addToWishlist(productId, wishlist)
      return false
    }
  } else {
    wishlist.onclick = (event) => {
      event.stopPropagation()
      event.preventDefault()
      void removeFromWishlist(productId, wishlist)
      return false
    }
  }
}

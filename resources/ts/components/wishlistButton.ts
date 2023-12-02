async function removeFromWishlist (productId: Number, wishlist: HTMLAnchorElement): Promise<void> {
  const req = await fetch('/api/wishlist', {
    method: 'DELETE',
    body: JSON.stringify({ product: productId }),
    headers: {
      'Content-Type': 'application/json'
    }
  })
  if (req.status !== 200) {
    console.error(`Add to cart failed with status ${req.status}`)
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
  wishlist.onclick = async () => {
    await addToWishlist(productId, wishlist)
  }
}

async function addToWishlist (productId: Number, wishlist: HTMLAnchorElement): Promise<void> {
  const req = await fetch('/api/wishlist', {
    method: 'POST',
    body: JSON.stringify({ product: productId }),
    headers: {
      'Content-Type': 'application/json'
    }
  })
  if (req.status !== 200) {
    console.error(`Add to cart failed with status ${req.status}`)
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
  wishlist.onclick = async () => {
    await removeFromWishlist(productId, wishlist)
  }
}

export default function (wishlist: HTMLElement): void {
  if (!(wishlist instanceof HTMLAnchorElement)) {
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
    wishlist.onclick = async () => {
      await addToWishlist(productId, wishlist)
    }
  } else {
    wishlist.onclick = async () => {
      await removeFromWishlist(productId, wishlist)
    }
  }
}

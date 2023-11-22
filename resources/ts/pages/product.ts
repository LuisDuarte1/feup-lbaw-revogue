async function addToCartRequest (productId: Number): Promise<void> {
  const req = await fetch('/api/cart', {
    method: 'POST',
    body: JSON.stringify({ product: productId }),
    headers: {
      'Content-Type': 'application/json'
    }
  })
  if (req.status !== 200) {
    console.error(`Add to cart failed with status ${req.status}`)
  }
}

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
  }
  const icon = document.querySelector('#wishlist > ion-icon')
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
  }
  const icon = document.querySelector('#wishlist > ion-icon')
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

export function productPage (): void {
  const productId = Number.parseInt(window.location.pathname.match(/^\/products\/(.*)$/)?.at(1) ?? '-1')
  if (productId === -1) {
    console.error("Couldn't get product id")
    return
  }
  const buyNow: HTMLButtonElement | null = document.querySelector('.buy-now')
  const addToCart: HTMLButtonElement | null = document.querySelector('.add-to-cart')
  if (buyNow !== null && addToCart !== null) {
    // TODO (luisd): add error if fails
    buyNow.onclick = async () => {
      await addToCartRequest(productId)
      window.location.href = '/cart'
    }
    addToCart.onclick = async () => {
      await addToCartRequest(productId)
    }
  }
  const wishlist: HTMLAnchorElement | null = document.querySelector('#wishlist')
  if (wishlist !== null) {
    const inWishlist = wishlist.getAttribute('data-inWishlist')
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
}

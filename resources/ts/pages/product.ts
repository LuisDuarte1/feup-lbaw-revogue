import { Swiper } from 'swiper'
import { Navigation, Pagination, Thumbs } from 'swiper/modules'

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

export function productPage (): void {
  const mainHeight = document.querySelector('.gallery-main')?.clientHeight
  const thumbs = document.querySelector('.gallery-thumbs')
  if (mainHeight === undefined || thumbs === null) {
    console.error('Could not get main height')
    return
  }
  thumbs.setAttribute('style', `height: ${mainHeight}px`)
  thumbs.addEventListener('resize', () => {
    thumbs.setAttribute('style', `height: ${document.querySelector('.gallery-main')?.clientHeight}px`)
  })
  const galleryThumbs = new Swiper('.gallery-thumbs', {
    spaceBetween: 5,
    loop: true,
    freeMode: true,
    slidesPerView: 4,
    watchSlidesProgress: true,
    direction: 'vertical'
  })
  new Swiper('.gallery-main', {
    modules: [Navigation, Pagination, Thumbs],
    spaceBetween: 10,
    loop: true,
    watchOverflow: true,
    centeredSlides: true,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev'
    },
    thumbs: {
      swiper: galleryThumbs
    }
  })

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
  new Swiper('.scrollSwiper', {
    modules: [Pagination],
    pagination: {
      el: '.swiper-pagination',
      dynamicBullets: true
    }
  })
}

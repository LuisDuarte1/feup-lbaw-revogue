import Swal from 'sweetalert2'
import { Swiper } from 'swiper'
import { Navigation, Pagination, Thumbs } from 'swiper/modules'
import { createFormData } from '../utils/csrf'
import { handleRequestErrorToast } from '../utils/toastUtils'

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
    await handleRequestErrorToast(req)
    return
  }

  const cartBadge = document.querySelector('.cart-badge')
  cartBadge?.setAttribute('value', (Number.parseInt(cartBadge?.getAttribute('value') ?? '0') + 1).toString())
}

function makeSendMesssageDialog (productId: number): void {
  const button = document.querySelector('.ask-question')
  if (button === null) {
    throw Error("Couldn't find ask question button")
  }
  button.addEventListener('click', async () => {
    const text = await Swal.fire<string>({
      title: 'Ask a question',
      input: 'textarea',
      confirmButtonText: 'Send',
      showCloseButton: true,
      confirmButtonColor: '#B794B8'
    })

    if (!text.isConfirmed || text.value === undefined) {
      console.log('User did not confirm send or input is null so we skip it')
      return
    }
    if (text.value === '') {
      return
    }

    const form = createFormData()
    form.set('text', text.value)

    const req = await fetch(`/products/${productId}/messages`, { method: 'POST', body: form, redirect: 'follow' })
    if (req.status > 400) {
      console.error('Request failed')
      return
    }

    window.location.href = '/messages'
  })
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
  makeSendMesssageDialog(productId)
  const buyNow: HTMLButtonElement | null = document.querySelector('.buy-now')
  const addToCart: HTMLButtonElement | null = document.querySelector('.add-to-cart')
  if (buyNow !== null && addToCart !== null) {
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

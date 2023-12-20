import Swal from 'sweetalert2'
import { Swiper } from 'swiper'
import { Navigation, Pagination, Thumbs } from 'swiper/modules'
import { createFormData } from '../utils/csrf'

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
function sendReport (productId: number): void {
  const button = document.querySelector('.product-report')
  if (button === null) {
    throw Error("Couldn't find report button")
  }
  button.addEventListener('click', async () => {
    const text = await Swal.fire<string>({
      title: 'Report product',
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
    console.log(text.value)
    const form = createFormData()
    form.set('reason', text.value)

    const req = await fetch(`/products/${productId}/report`, { method: 'POST', body: form })
    window.location.href = req.url
  })
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
    window.location.href = req.url
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
  sendReport(productId)
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

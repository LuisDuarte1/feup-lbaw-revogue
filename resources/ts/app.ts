import imageUploader from './components/imageUploader'
import submitFormOnChange from './components/submitFormOnChange'
import wishlistButton from './components/wishlistButton'
import { cart } from './pages/cart'
import { completeProfile } from './pages/completeProfile'
import { landingPage } from './pages/landing'
import { productPage } from './pages/product'
import { productListing } from './pages/productListing'
import { searchPage } from './pages/search'
import 'swiper/css/bundle'
import { checkout } from './pages/checkout'
import errorModal from './components/errorModal'
import { expandableCard } from './components/expandableCard'

type RouteList = Record<string, () => void>
type ComponentList = Record<string, (element: HTMLElement) => void>

const routes: RouteList = {
  '/': landingPage,
  '/products/new': productListing,
  '/profile/complete': completeProfile,
  '/search': searchPage,
  '/products/{id}': productPage,
  '/cart': cart,
  '/checkout': checkout
}

const components: ComponentList = {
  '#account_status': submitFormOnChange,
  '#order_status': submitFormOnChange,
  '.upload-photos': imageUploader,
  '#wishlist_button': wishlistButton,
  'meta[name="modal-error"]': errorModal,
  'expandable-card': expandableCard
}

function pageHandler (): void {
  let hasRan = false
  Object.keys(routes).forEach((value, _) => {
    const rule = '^' + value.replaceAll(/\{(.*)\}/g, '(.*)').replaceAll('/', '\\/') + '$'
    const regex = new RegExp(rule)

    if (regex.test(window.location.pathname)) {
      routes[value]()
      hasRan = true
    }
  })
  if (!hasRan) {
    console.log(`Could not find function for ${window.location.pathname}`)
  }
}

function componentHandler (): void {
  Object.keys(components).forEach((value, _) => {
    document.querySelectorAll<HTMLElement>(value).forEach((element, _) => {
      components[value](element)
    })
  })
}

document.addEventListener('DOMContentLoaded', (_) => {
  componentHandler()
  pageHandler()
})

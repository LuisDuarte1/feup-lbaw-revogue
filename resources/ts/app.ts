import './bootstrap.ts'

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
import expandableImage from './components/expandableImage'
import notificationDropdown from './components/notificationDropdown'
import notification from './components/notification'
import { notifications } from './pages/notifications'
import productMessageThread from './components/productMessageThread'
import sendTextMessage from './components/sendTextMessage'
import { messages } from './pages/messages'
import sendImageMessage from './components/sendImageMessage'
import sendBargainMessage from './components/sendBargainMessage'
import sendReport from './components/sendReport'
import messageBargainContent from './components/messageBargainContent'
import changeOrderStatus from './components/changeOrderStatus'
import requestOrderCancellation from './components/requestOrderCancellation'
import messageCancellationContent from './components/messageCancellationContent'
import applyVoucherButton from './components/applyVoucherButton'
import voucherRemove from './components/voucherRemove'

type RouteList = Record<string, () => void>
type ComponentList = Record<string, (element: HTMLElement) => void>

const routes: RouteList = {
  '/': landingPage,
  '/products/new': productListing,
  '/profile/complete': completeProfile,
  '/search': searchPage,
  '/products/{id}': productPage,
  '/cart': cart,
  '/checkout': checkout,
  '/notifications': notifications,
  '/messages': messages
}

const components: ComponentList = {
  '#account_status': submitFormOnChange,
  '#order_status': submitFormOnChange,
  '.upload-photos': imageUploader,
  '.wishlist_button': wishlistButton,
  'meta[name="modal-error"]': errorModal,
  '.expandable-image': expandableImage,
  '#notifications-icon': notificationDropdown,
  '.notification': notification,
  '.message-thread-input > .text-input': sendTextMessage,
  '.product-message-thread': productMessageThread,
  '.send-image-message': sendImageMessage,
  '.send-bargain-message': sendBargainMessage,
  '.message-bargain-content': messageBargainContent,
  '.report': sendReport,
  '.change-order-status': changeOrderStatus,
  '.cancel-order': requestOrderCancellation,
  '.message-cancellation-content': messageCancellationContent,
  '.order-message-thread': productMessageThread,
  '.apply-button > button': applyVoucherButton,
  '.voucher-remove': voucherRemove,
  '#report_status': submitFormOnChange
}

function pageHandler (): void {
  let hasRan = false
  Object.keys(routes).forEach((value, _) => {
    const rule = '^' + value.replaceAll(/\{(.*)\}/g, '(.*)').replaceAll('/', '\\/') + '$'
    const regex = new RegExp(rule)

    if (regex.test(window.location.pathname)) {
      if (Object.keys(routes).includes(window.location.pathname) && value !== window.location.pathname) {
        console.warn('found ambiguous route... skipping this one because there\'s an exact match')
        return
      }
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

export function componentAJAXHandler (elements: Element[]): void {
  elements.forEach((element) => {
    // first we check if the element itself matches any of the componentlist
    Object.keys(components)
      .filter((value) => element.matches(value))
      .forEach((value) => { components[value](element as HTMLElement) })

    // then we check for the children of the element
    Object.keys(components).forEach((value, _) => {
      element.querySelectorAll<HTMLElement>(value).forEach((el, _) => {
        components[value](el)
      })
    })
  })
}

document.addEventListener('DOMContentLoaded', (_) => {
  // idk why but sometimes DOMContentLoaded is called twice (probably because somehow this is being imported twice),
  // so to avoid that we create the meta so that the js runs like a singleton
  if (document.querySelector('meta[name=app-singleton]') !== null) {
    return
  }
  const meta = document.createElement('meta')
  meta.content = 'true'
  meta.name = 'app-singleton'
  document.getElementsByTagName('head')[0]?.append(meta)

  componentHandler()
  pageHandler()
}, { once: true })

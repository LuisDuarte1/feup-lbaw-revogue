import './bootstrap'
import { completeProfile } from './pages/completeProfile'
import { landingPage } from './pages/landing'
import { productPage } from './pages/product'
import { productListing } from './pages/productListing'
import { searchPage } from './pages/search'

type RouteList = Record<string, () => void>

const routes: RouteList = {
  '/': landingPage,
  '/products/new': productListing,
  '/profile/complete': completeProfile,
  '/search': searchPage,
  '/products/{id}': productPage
}

document.addEventListener('DOMContentLoaded', (_) => {
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
})

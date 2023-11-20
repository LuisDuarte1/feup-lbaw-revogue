import './bootstrap'
import { completeProfile } from './pages/completeProfile'
import { landingPage } from './pages/landing'
import { productListing } from './pages/productListing'

type RouteList = Record<string, () => void>

const routes: RouteList = {
  '/': landingPage,
  '/products/new': productListing,
  '/profile/complete': completeProfile
}

document.addEventListener('DOMContentLoaded', (_) => {
  let hasRan = false
  Object.keys(routes).forEach((value, _) => {
    if (window.location.pathname === value) {
      routes[value]()
      hasRan = true
    }
  })
  if (!hasRan) {
    console.log(`Could not find function for ${window.location.pathname}`)
  }
})

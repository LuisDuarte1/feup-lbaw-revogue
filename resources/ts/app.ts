import './bootstrap'
import { landingPage } from './pages/landing'

type RouteList = Record<string, () => void>

const routes: RouteList = {
  '/': landingPage
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

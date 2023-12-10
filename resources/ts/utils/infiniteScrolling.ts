import { componentAJAXHandler } from '../app'

async function endVisible (params: URLSearchParams, apiUrl: string, destElement: Element, sourceSelector: string, editPage = true): Promise<void> {
  const req = await fetch(`${apiUrl}?${params.toString()}`)
  const endElement = destElement.querySelector('#page-end')

  if (req.status === 204) {
    console.log('no content left... skipping')
    return
  }
  if (req.status !== 200) {
    console.error('copa')
    return
  }
  const html = document.createElement('html')
  html.innerHTML = await req.text()
  const listElements = Array.from(html.querySelectorAll(sourceSelector))
  if (listElements.length === 0) {
    return
  }
  componentAJAXHandler(listElements)
  listElements.forEach((val) => {
    destElement.insertBefore(val, endElement)
  })

  let page = params.get('page')
  if (page === null) {
    params.set('page', '1')
    page = '1'
  }
  let pageNumber = Number.parseInt(page)
  pageNumber++
  params.set('page', pageNumber.toString())
  if (editPage) window.history.replaceState(null, '', '?' + params.toString())
}

export function addEndObserver (params: URLSearchParams, apiUrl: string, destElement: Element, sourceSelector: string, editPage = true): void {
  const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (entry.intersectionRatio > 0) {
        void endVisible(params, apiUrl, destElement, sourceSelector, editPage)
      }
    })
  }, {})

  const element = destElement.querySelector('#page-end')
  if (element === null) {
    return
  }
  observer.observe(element)
}

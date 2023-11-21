async function endVisible (params: URLSearchParams, apiUrl: string, destElement: Element): Promise<void> {
  const req = await fetch(`${apiUrl}?${params.toString()}`)
  if (req.status !== 200) {
    console.error('copa')
    return
  }
  const html = document.createElement('html')
  html.innerHTML = await req.text()
  const listElements = Array.from(html.querySelectorAll('a'))
  if (listElements.length === 0) {
    return
  }
  destElement.append(...listElements)

  let page = params.get('page')
  if (page === null) {
    params.set('page', '1')
    page = '1'
  }
  let pageNumber = Number.parseInt(page)
  pageNumber++
  params.set('page', pageNumber.toString())
  window.history.replaceState(null, '', '?' + params.toString())
}

export function addEndObserver (params: URLSearchParams, apiUrl: string, destElement: Element): void {
  const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (entry.intersectionRatio > 0) {
        void endVisible(params, apiUrl, destElement)
      }
    })
  }, {})

  const element = document.querySelector('#page-end')
  if (element === null) {
    return
  }
  observer.observe(element)
}

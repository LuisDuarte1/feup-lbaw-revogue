import { componentAJAXHandler } from '../app'

type NewElementCallback = (element: Element[]) => void

interface InfiniteScrollingOptions {
  editPage?: boolean | undefined
  callback?: NewElementCallback | undefined
  prepend?: boolean | undefined
  reverse?: boolean | undefined
  preFetchCallback?: (() => void) | undefined
}

function resetLoader (endElement: Element): void {
  endElement.innerHTML = ''
}

async function endVisible (params: URLSearchParams, apiUrl: string, destElement: Element, sourceSelector: string, editPage: boolean, callback: NewElementCallback, prepend: boolean, reverse: boolean, preFetchCallback: (() => void)): Promise<void> {
  const endElement = destElement.querySelector('#page-end')
  if (endElement === null) {
    throw Error("Couldn't find page end")
  }

  const div = document.createElement('div')
  div.classList.add('loader')
  endElement.append(div)

  preFetchCallback()
  const req = await fetch(`${apiUrl}?${params.toString()}`)

  if (req.status === 204) {
    console.log('no content left... skipping')
    resetLoader(endElement)
    return
  }
  if (req.status !== 200) {
    console.error('copa')
    resetLoader(endElement)
    return
  }
  const html = document.createElement('html')
  html.innerHTML = await req.text()
  const listElements = Array.from(html.querySelectorAll(sourceSelector))
  if (listElements.length === 0) {
    resetLoader(endElement)
    return
  }
  if (reverse) {
    listElements.reverse()
  }
  componentAJAXHandler(listElements)
  if (prepend) {
    listElements.forEach((val) => {
      destElement.insertBefore(val, endElement.nextSibling)
    })
  } else {
    listElements.forEach((val) => {
      destElement.insertBefore(val, endElement)
    })
  }
  callback(listElements)

  let page = params.get('page')
  if (page === null) {
    params.set('page', '1')
    page = '1'
  }
  let pageNumber = Number.parseInt(page)
  pageNumber++
  params.set('page', pageNumber.toString())
  if (editPage) window.history.replaceState(null, '', '?' + params.toString())

  resetLoader(endElement)
}

export function addEndObserver (params: URLSearchParams, apiUrl: string, destElement: Element, sourceSelector: string, infiniteScrollingOptions?: InfiniteScrollingOptions | undefined): void {
  const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (entry.intersectionRatio > 0) {
        if (infiniteScrollingOptions === undefined) {
          void endVisible(params, apiUrl, destElement, sourceSelector, true, () => {}, false, false, () => {})
        } else {
          void endVisible(params, apiUrl, destElement, sourceSelector, infiniteScrollingOptions.editPage ?? true, infiniteScrollingOptions.callback ?? (() => {}), infiniteScrollingOptions.prepend ?? false, infiniteScrollingOptions.reverse ?? false, infiniteScrollingOptions.preFetchCallback ?? (() => {}))
        }
      }
    })
  }, {})

  const element = destElement.querySelector('#page-end')
  if (element === null) {
    throw Error('Could not get page end')
  }
  observer.observe(element)
}

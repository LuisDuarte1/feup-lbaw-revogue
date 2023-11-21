import { addEndObserver } from '../utils/infiniteScrolling'

function addQuery (query: string | null): void {
  if (query === null) {
    return
  }
  const searchElement: HTMLInputElement | null = document.querySelector('#search')
  if (searchElement === null) {
    return
  }
  searchElement.value = query
}

export function searchPage (): void {
  const URLParams = new URLSearchParams(window.location.search)
  let page = URLParams.get('page')
  if (page === null) {
    URLParams.set('page', '1')
    page = '1'
  }
  const element = document.querySelector('.search-page')
  if (element !== null) {
    addEndObserver(URLParams, '/api/search', element)
  }
  addQuery(URLParams.get('q'))
}

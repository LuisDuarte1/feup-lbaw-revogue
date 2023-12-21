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
  URLParams.set('page', '2')
  const element = document.querySelector('.search-page')
  if (element !== null) {
    addEndObserver(URLParams, '/api/search', element, 'a', { editPage: false })
  }
  addQuery(URLParams.get('q'))
}

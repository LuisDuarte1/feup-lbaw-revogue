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
  addQuery(URLParams.get('q'))
}

export default function (element: Element): void {
  const url = new URL(window.location.href)
  handlePriceInput(element, url)
  handleAttributes(element, url)
  handleCategory(element, url)
}

function handlePriceInput (element: Element, url: URL): void {
  const priceFilter = element.querySelector('.filter-price')
  if (priceFilter === null) {
    throw Error('Cannot find price filter')
  }

  const maxPriceInput: HTMLInputElement | null = priceFilter.querySelector('#price_product_to')
  const minPriceInput: HTMLInputElement | null = priceFilter.querySelector('#price_product_from')

  if (maxPriceInput === null || minPriceInput === null) {
    throw Error('Cannot find inputs')
  }

  const prevMinPrice = url.searchParams.get('price[min_price]')
  const prevMaxPrice = url.searchParams.get('price[max_price]')

  if (prevMinPrice !== null) {
    minPriceInput.value = prevMinPrice
  }

  if (prevMaxPrice !== null) {
    maxPriceInput.value = prevMaxPrice
  }

  const doQuery = (): void => {
    if (maxPriceInput.value === '' || maxPriceInput.value === '') return

    url.searchParams.set('price[max_price]', maxPriceInput.value)
    url.searchParams.set('price[min_price]', minPriceInput.value)

    if (url.searchParams.get('page') !== null) {
      url.searchParams.delete('page')
    }

    window.history.pushState({}, '', url)
    window.location.href = url.toString()
  }

  maxPriceInput.addEventListener('change', doQuery)
  minPriceInput.addEventListener('change', doQuery)
}

function handleCategory (element: Element, url: URL): void {
  const categoryFilter = element.querySelector('.filter-category')
  if (categoryFilter === null) {
    throw Error('Cannot find category filter')
  }

  const selectElement: HTMLSelectElement | null = categoryFilter.querySelector('select')
  if (selectElement === null) {
    throw Error('cannot find select element')
  }

  const prevCategory = url.searchParams.get('category')
  if (prevCategory !== null) {
    selectElement.value = prevCategory
  }

  selectElement.addEventListener('change', () => {
    if (selectElement.value === '' && prevCategory === null) return

    if (selectElement.value === '' && prevCategory !== null) {
      url.searchParams.delete('category')
    } else {
      url.searchParams.set('category', selectElement.value)
    }

    if (url.searchParams.get('page') !== null) {
      url.searchParams.delete('page')
    }

    window.history.pushState({}, '', url)
    window.location.href = url.toString()
  })
}

function handleAttributes (element: Element, url: URL): void {
  const attributeFilters = element.querySelectorAll('.filter-attribute')
  attributeFilters.forEach((attributeFilter) => {
    const selectElement: HTMLSelectElement | null = attributeFilter.querySelector('select')
    if (selectElement === null) {
      throw Error('cannot find select element')
    }
    const filterName = attributeFilter.getAttribute('data-attribute-key')
    if (filterName === null) {
      throw Error('cannot find attribute filter key name')
    }

    const prevAttributeValue = url.searchParams.get(`attribute[${filterName}]`)
    if (prevAttributeValue !== null) {
      selectElement.value = prevAttributeValue
    }

    selectElement.addEventListener('change', () => {
      if (selectElement.value === '' && prevAttributeValue === null) return

      if (selectElement.value === '' && prevAttributeValue !== null) {
        url.searchParams.delete(`attribute[${filterName}]`)
      } else {
        url.searchParams.set(`attribute[${filterName}]`, selectElement.value)
      }

      if (url.searchParams.get('page') !== null) {
        url.searchParams.delete('page')
      }

      window.history.pushState({}, '', url)
      window.location.href = url.toString()
    })
  })
}

import debounce from 'debounce'
import { handleRequestErrorToast } from '../utils/toastUtils'

const bannedAttributes = ['Color', 'Size']

function flexResize (): void {
  const tags: HTMLDivElement | null = document.querySelector('.tags')
  const tagsList: HTMLDivElement | null = document.querySelector('.tags-list')
  if (tags === null || tagsList === null) {
    return
  }
  tagsList.style.setProperty('--var-tags-width', tags.offsetWidth.toString() + 'px')
  tags.addEventListener('resize', () => {
    tagsList.style.setProperty('--var-tags-width', tags.offsetWidth.toString() + 'px')
  })
}

function addTag (attribute: string, inputList: HTMLDivElement): (this: GlobalEventHandlers, ev: MouseEvent) => any {
  const func = async (): Promise<void> => {
    console.log("I'm here")
    const req = await fetch(`/api/attributes?q=${attribute}`)
    if (req.status !== 200) {
      console.error('Something went wrong while getting the list of values...')
      await handleRequestErrorToast(req)
      return
    }
    const values: string[] = (await req.json()).values
    const div = document.createElement('div')
    div.classList.add('category')
    div.innerHTML =
    `<label for="${attribute.toLowerCase()}">
        <h3>${attribute}</h3>
    </label>
    <select id="${attribute.toLowerCase()}" name="${attribute.toLowerCase()}">
      <option value=""></option>
    </select>`
    const select: HTMLSelectElement | null = div.querySelector(`#${attribute.toLowerCase()}`)
    if (select === null) {
      console.error('cope')
      return
    }
    for (const value of values) {
      const option = document.createElement('option')
      option.value = value
      option.textContent = value
      select.appendChild(option)
    }
    inputList.appendChild(div)
  }
  return (event: Event) => {
    void func()
    event.preventDefault()
  }
}

function searchTag (): void {
  const searchInput: HTMLInputElement | null = document.querySelector('#search_tag')
  const tagsList: HTMLDivElement | null = document.querySelector('.tags-list')
  const inputList: HTMLDivElement | null = document.querySelector('.input-list')

  let fetchedAttributeList = false
  let attributeList: string[] = []
  if (searchInput === null || tagsList === null || inputList === null) {
    return
  }
  const searchFunction = debounce(async (ev) => {
    if (!fetchedAttributeList) {
      const req = await fetch('/api/attributes')
      if (req.status !== 200) {
        console.error('Something went wrong while getting the list of attributes...')
        await handleRequestErrorToast(req)
        return
      }
      const data = await req.json()
      attributeList = (data.attributes as string[]).filter((value) => !bannedAttributes.includes(value)).map((value) => value.toLowerCase())
      fetchedAttributeList = true
    }
    const validAttributes = attributeList.filter((value) => value.includes(searchInput.value.toLowerCase())) // not a good search function but oh well
    tagsList.innerHTML = ''

    validAttributes.forEach((attr) => {
      const a = document.createElement('a')
      a.textContent = attr
      a.href = '#'
      a.classList.add('add-tag')
      // add onclick
      a.onclick = addTag(attr, inputList)
      tagsList.appendChild(a)
    })
  }, 250)
  searchInput?.addEventListener('input', (ev) => {
    if (searchInput.value === '') {
      searchFunction.clear()
      searchFunction.flush()
      tagsList.innerHTML = ''
      return
    }
    void searchFunction(ev)
  })
}

export function productListing (): void {
  flexResize()
  searchTag()
}

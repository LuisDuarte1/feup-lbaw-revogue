import debounce from 'debounce'

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
    searchFunction(ev)
  })
}

function imageUploader (): void {
  const input: HTMLInputElement | null = document.querySelector('#product-photos')
  if (input == null) {
    return
  }
  let photos: NodeListOf<HTMLDivElement> = document.querySelectorAll('.add-photo')
  const normalSquare = photos[photos.length - 1].cloneNode(true)
  const parent = photos[photos.length - 1].parentElement
  if (parent == null) {
    return
  }

  let count = 0

  const eventListener = (event: Event): void => {
    if (input.files == null) {
      return
    }
    if (input.files.length + count > 8) {
      // TODO: Show error message
      return
    }
    count += input.files.length
    let insertPhotoIndex = -1
    photos.forEach((value, index) => {
      if (value.querySelector('#product-photos') != null) {
        insertPhotoIndex = index
      }
    })
    if (insertPhotoIndex !== -1) {
      for (let i = 0; i < input.files.length; i++) {
        parent.lastElementChild?.remove()
        const element = normalSquare.cloneNode(true)
        const img = document.createElement('img')
        img.src = URL.createObjectURL(input.files[i])
        element.appendChild(img)
        parent.prepend(element)
      }
    }
    photos = document.querySelectorAll('.add-photo')
    console.log(input.files)
  }

  input.addEventListener('change', eventListener)
}

export function productListing (): void {
  flexResize()
  searchTag()
  imageUploader()
}

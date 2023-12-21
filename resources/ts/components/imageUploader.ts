async function getImageFile (url: string, name: string): Promise<File> {
  const response = await fetch(url)

  const data = await response.blob()

  return new File([data], name, { type: data.type })
}

async function getFiles (existingPhotos: NodeListOf<HTMLDivElement>): Promise<File[]> {
  const filePromises: Array<Promise<File>> = []

  for (let i = 0; i < existingPhotos.length; i++) {
    const img = existingPhotos[i].querySelector('img')

    if (img !== null) {
      const url = img.src
      const name = img.alt

      filePromises.push(getImageFile(url, name))
    }
  }

  const files = await Promise.all(filePromises)

  return files
}

let count = 0
let arrayFiles: File[] = []
let input: HTMLInputElement | null

export default async function (imageElement: Element): Promise<void> {
  input = imageElement.querySelector('#product-photos')

  if (input === null) {
    input = document.createElement('input')
    input.id = 'product-photos'
    input.name = 'imageToUpload[]'
    input.type = 'file'
    input.multiple = true
    input.accept = 'image/png, image/jpeg, image/jpg'
  }

  let photos: NodeListOf<HTMLDivElement> = imageElement.querySelectorAll('.add-photo')

  const normalSquare = document.createElement('div')
  normalSquare.classList.add('add-photo')

  let inputSquare = input.parentElement as HTMLDivElement | null

  if (inputSquare === null) {
    inputSquare = document.createElement('div')
    inputSquare.classList.add('add-photo')
    inputSquare.innerHTML = `                        
    <label for="product-photos" class="product-photos">
    <ion-icon name="camera" aria-label="add-product-icon"></ion-icon>
    Add photos
    </label>`
    inputSquare.append(input)

    if (photos[0].parentElement !== null) {
      photos[0].parentElement.append(inputSquare)
    }
  }

  const parent = photos[photos.length - 1].parentElement

  if (parent == null) {
    return
  }

  const existingPhotos: NodeListOf<HTMLDivElement> = imageElement.querySelectorAll('.existing-photos')

  if (existingPhotos == null) {
    return
  }

  const files = await getFiles(existingPhotos)

  arrayFiles = Array.from(files)
  count = arrayFiles.length

  const dt = new DataTransfer()
  arrayFiles.forEach((value) => { dt.items.add(value) })
  input.files = dt.files
  photos = renderPhotos(parent, normalSquare, inputSquare, photos, imageElement)

  const eventListener = (event: Event): void => {
    if (input === null || inputSquare == null) {
      return
    }

    if (input.files == null) {
      return
    }

    if (input.files.length + count > 8) {
      // TODO: Show error message
      return
    }

    const arrayInput = Array.from(input.files)
    arrayFiles.push(...arrayInput)

    const dt = new DataTransfer()
    arrayFiles.forEach((value) => { dt.items.add(value) })
    input.files = dt.files

    count = input.files.length
    photos = renderPhotos(parent, normalSquare, inputSquare, photos, imageElement)

    photos = imageElement.querySelectorAll('.add-photo')
  }

  input.addEventListener('change', eventListener)
}

function renderPhotos (parent: HTMLElement, normalSquare: Node, inputSquare: HTMLDivElement, photos: NodeListOf<HTMLDivElement>, imageElement: Element): NodeListOf<HTMLDivElement> {
  if (input?.files == null) {
    throw Error('copanço')
  }

  parent.querySelectorAll('.add-photo').forEach((value) => { value.remove() })

  for (let i = input.files.length - 1; i >= 0; i--) {
    const element = normalSquare.cloneNode(true)
    const img = document.createElement('img')
    const closeIcon = document.createElement('a')

    closeIcon.href = '#'
    closeIcon.classList.add('close-icon')
    closeIcon.innerHTML = '<ion-icon name="close" aria-label="close-icon"></ion-icon>'

    img.src = URL.createObjectURL(input.files[i])

    element.appendChild(img)
    element.appendChild(closeIcon)

    closeIcon.onclick = () => {
      if (input === null) return

      if (element.parentElement !== null) {
        element.parentElement.removeChild(element)
      }

      count--

      if (input.files !== null) {
        arrayFiles.splice(i, 1)

        const array = Array.from(input.files)

        array.splice(i, 1)

        const dt = new DataTransfer()

        array.forEach((file) => dt.items.add(file))
        input.files = dt.files
      }

      photos = renderPhotos(parent, normalSquare, inputSquare, photos, imageElement)
    }

    parent.prepend(element)
  }

  for (let i = 0; i < (8 - count); i++) {
    if (i === 0) {
      parent.append(inputSquare)
    } else {
      parent.append(normalSquare.cloneNode(true))
    }
  }

  if (count === 8) {
    parent.append(inputSquare)
  }

  return photos
}

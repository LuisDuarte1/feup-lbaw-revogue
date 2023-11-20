export function productListing (): void {
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

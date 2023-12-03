export default function (imageElement: Element): void {
  const input: HTMLInputElement | null = imageElement.querySelector('#product-photos')
  if (input == null) {
    return
  }
  let photos: NodeListOf<HTMLDivElement> = imageElement.querySelectorAll('.add-photo')
  const normalSquare = photos[photos.length - 1].cloneNode(true)
  const inputSquare = photos[0]
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
        const a = document.createElement('a')
        a.href = '#'
        a.classList.add('close-icon')
        a.innerHTML = '<ion-icon name="close"></ion-icon>'
        img.src = URL.createObjectURL(input.files[i])
        element.appendChild(img)
        element.appendChild(a)
        a.onclick = () => {
          if (element.parentElement != null) {
            element.parentElement.removeChild(element)
          }
          if (count === 8) {
            parent.appendChild(inputSquare)
          } else {
            parent.appendChild(normalSquare.cloneNode(true))
          }
          count--

          photos = imageElement.querySelectorAll('.add-photo')
        }
        if (count !== 0) {
          parent.insertBefore(element, photos[count - 1].nextSibling)
        } else {
          parent.prepend(element)
        }
      }
      count += input.files.length
    }
    photos = imageElement.querySelectorAll('.add-photo')
  }

  input.addEventListener('change', eventListener)
}

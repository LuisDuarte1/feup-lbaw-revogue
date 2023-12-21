import Swal from 'sweetalert2'

export default async function (element: HTMLElement): Promise<void> {
  const image = element as HTMLImageElement
  const src = image.src
  const screenHeight = window.innerHeight * 0.95
  const ratio = image.naturalWidth / image.naturalHeight
  element.addEventListener('click', async (event) => {
    await Swal.fire({
      imageUrl: src,
      imageHeight: image.naturalHeight > screenHeight ? screenHeight : image.naturalHeight,
      padding: 0,
      imageWidth: image.naturalHeight > screenHeight ? Math.round(screenHeight * ratio) : image.naturalWidth,
      width: image.naturalHeight > screenHeight ? Math.round(screenHeight * ratio) : image.naturalWidth,
      heightAuto: true,
      customClass: {
        popup: 'modal-expandable-image-container',
        image: 'modal-expandable-image',
        closeButton: 'modal-expandable-image-close-button'
      },
      imageAlt: 'image',
      showConfirmButton: false,
      showCloseButton: true
    })
  })
}

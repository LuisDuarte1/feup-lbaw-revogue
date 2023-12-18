import Swal from 'sweetalert2'

export default async function (element: HTMLElement): Promise<void> {
  const image = element as HTMLImageElement
  const src = image.src
  element.addEventListener('click', async (event) => {
    await Swal.fire({
      imageUrl: src,
      imageHeight: image.naturalHeight,
      padding: 0,
      imageWidth: image.naturalWidth,
      width: image.naturalWidth,
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

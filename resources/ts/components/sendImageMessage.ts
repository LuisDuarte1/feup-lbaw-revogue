import Swal from 'sweetalert2'
import { createFormData } from '../utils/csrf'
import { fetchWithSocketInformation } from '../utils/fetchUtils'
import { componentAJAXHandler } from '../app'

interface SendImageFormResult {
  image: File
  text: string
}

export default function (element: HTMLElement): void {
  const messageThreadContent = document.querySelector('.message-thread-content')
  const threadId = messageThreadContent?.getAttribute('data-thread-id')
  if (messageThreadContent == null || threadId == null) {
    throw Error('Could not find message thread content and its id')
  }

  let textInput: HTMLTextAreaElement
  let imageInput: HTMLInputElement

  element.addEventListener('click', async (ev) => {
    const inputs = await Swal.fire<SendImageFormResult>({
      title: 'Send image',
      confirmButtonText: 'Send',
      showCloseButton: true,
      focusConfirm: false,
      html: `
        <div class="column justify-center items-center gap-2">
            <div class="select-image-wrapper">
                <div class="popup-select-image">
                    <img>
                    <label for="image-message" class="image-message-label">
                        <ion-icon name="camera"></ion-icon>
                        Add photo
                    </label>
                    <input id="image-message" type="file" accept="image/png, image/jpeg, image/jpg">
                </div>
            </div>
            <div class="popup-text-message column gap-1 items-begin">
                <label for="text-message" style=""><h3>Text:</h3></label>
                <textarea id="text-message" rows="2" column="50"></textarea>
            </div>
        </div>

      `,
      didOpen: (popup) => {
        const htmlSwal = popup.querySelector('.swal2-html-container')
        if (htmlSwal === null) {
          throw Error('Could not find html container')
        }
        const styles = getComputedStyle(htmlSwal)
        const maxWidth = htmlSwal.clientWidth - parseFloat(styles.paddingLeft) - parseFloat(styles.paddingRight)
        console.log(maxWidth)

        const text: HTMLTextAreaElement | null = popup.querySelector('#text-message')
        if (text === null) {
          throw Error('Could not find text textarea')
        }
        textInput = text

        const image: HTMLInputElement | null = popup.querySelector('#image-message')
        const img: HTMLImageElement | null = popup.querySelector('.popup-select-image > img')
        const label: HTMLLabelElement | null = popup.querySelector('.image-message-label')
        if (image === null || img == null || label === null) {
          throw Error('Could not find select image elements')
        }
        imageInput = image

        imageInput.addEventListener('change', () => {
          if (imageInput.files === null) {
            console.log('No files selected')
            return
          }
          img.style.height = `${img.parentElement?.clientHeight}px`

          img.src = URL.createObjectURL(imageInput.files[0])
          img.style.display = 'block'

          if (img.clientWidth > maxWidth) {
            img.style.height = 'auto'
            img.style.width = `${maxWidth}px`
          }
          if (img.parentElement === null) {
            return
          }
          label.style.display = 'none'
        })
      },
      preConfirm: () => {
        if (imageInput.files === null || imageInput.files.length === 0) {
          Swal.showValidationMessage('Please select a image file')
          return false
        }
        const formResult: SendImageFormResult = { image: imageInput.files[0], text: textInput.value }
        return formResult
      }
    })

    if (inputs.isConfirmed && inputs.value !== undefined) {
      const formData = createFormData()
      if (inputs.value.text !== '') {
        formData.set('text', inputs.value.text)
      }
      formData.set('image', inputs.value.image)
      console.log(formData)
      const res = await fetchWithSocketInformation(`/api/messages/${threadId}`, { method: 'POST', body: formData })
      if (res.status !== 200) {
        console.error(`Send message request failed with status ${res.status}`)
        return
      }
      const html = document.createElement('html')
      html.innerHTML = await res.text()
      const element = html.querySelector('.message-bubble')
      if (element === null) {
        throw Error("Couldn't find message bubble")
      }
      messageThreadContent.append(element)
      messageThreadContent.parentElement?.scrollTo({ top: messageThreadContent.parentElement?.scrollHeight, behavior: 'instant' })
      componentAJAXHandler([element])
    }
  })
}

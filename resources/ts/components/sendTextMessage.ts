import { createFormData } from '../utils/csrf'
import { fetchWithSocketInformation } from '../utils/fetchUtils'

async function sendTextMessage (text: string, threadId: string): Promise<void> {
  const messageThreadContent = document.querySelector('.message-thread-content')
  if (messageThreadContent === null) {
    throw Error("Couldn't find .message-thread-content")
  }
  const formData = createFormData()
  formData.set('text', text)
  const req = await fetchWithSocketInformation(`/api/messages/${threadId}`, { method: 'POST', body: formData })
  if (req.status !== 200) {
    // TODO(luisd): maybe show popup or toast?
    throw Error(`Couldn't send message got ${req.status}`)
  }
  const html = document.createElement('html')
  html.innerHTML = await req.text()
  const element = html.querySelector('.message-bubble')
  if (element === null) {
    throw Error("Couldn't find message bubble")
  }
  messageThreadContent.append(element)
  messageThreadContent.parentElement?.scrollTo({ top: messageThreadContent.parentElement?.scrollHeight, behavior: 'instant' })
}

export default function (element: Element): void {
  const messageThreadContent = document.querySelector('.message-thread-content')
  const threadId = element.getAttribute('data-thread-id')
  if (threadId === null || messageThreadContent === null) {
    throw Error("couldn't find required elements")
  }

  const input = element.children.item(0) as HTMLTextAreaElement
  const initialHeight = input.offsetHeight
  const initialScrollHeight = input.scrollHeight

  messageThreadContent.parentElement?.scrollTo({ top: messageThreadContent.parentElement?.scrollHeight, behavior: 'instant' })

  input.addEventListener('keyup', () => {
    if (input.scrollHeight - initialScrollHeight > 0) {
      input.style.height = 'auto'
      input.style.height = `${initialHeight + (input.scrollHeight - initialScrollHeight)}px`
    }
    if (input.value === '') {
      input.style.height = `${initialHeight}px`
    }
  })

  input.addEventListener('keydown', (ev) => {
    if (ev.key === 'Enter' && !ev.shiftKey) {
      ev.preventDefault()
      void sendTextMessage(input.value, threadId).then(() => {
        input.value = ''
      })
    }
  })

  const sendIcon = element.children.item(1)
  if (sendIcon === null) {
    throw Error("Couldn't find send icon")
  }

  sendIcon.addEventListener('click', (ev) => {
    ev.stopImmediatePropagation()
    ev.preventDefault()
    void sendTextMessage(input.value, threadId).then(() => {
      input.value = ''
    })
  })
}

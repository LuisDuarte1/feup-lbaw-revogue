import { componentAJAXHandler } from '../app'
import { echo } from '../bootstrap'

export function messages (): void {
  const messageThreadContent = document.querySelector('.message-thread-content')
  if (messageThreadContent === null) {
    throw new Error("Couldn't find message-thread-content")
  }

  const threadId = messageThreadContent.getAttribute('data-thread-id')
  if (threadId === null) {
    throw new Error("Couldn't find attribute data-thread-id")
  }
  echo
    .private(`messagethreads.${threadId}`)
    .listen('ProductMessageEvent', (e: any) => {
      const content: string | undefined = e.content
      if (content === undefined) {
        throw Error("Couldn't find event content")
      }
      const html = document.createElement('html')
      html.innerHTML = content
      const bubble = html.querySelector('.message-bubble')
      if (bubble === null) {
        return Error("Event didn't return a message bubble")
      }
      console.log(bubble)
      messageThreadContent.append(bubble)
      messageThreadContent.parentElement?.scrollTo({ top: messageThreadContent.parentElement?.scrollHeight, behavior: 'instant' })
      componentAJAXHandler([bubble])
    })
}

import { componentAJAXHandler } from '../app'
import { echo } from '../bootstrap'
import { addEndObserver } from '../utils/infiniteScrolling'

export function messages (): void {
  const messageThreadContent = document.querySelector('.message-thread-content')
  if (messageThreadContent === null) {
    throw new Error("Couldn't find message-thread-content")
  }

  const threadId = messageThreadContent.getAttribute('data-thread-id')
  const currentUserId = messageThreadContent.getAttribute('data-current-user-id')

  if (threadId === null || currentUserId === null) {
    throw new Error("Couldn't find attribute data-thread-id or data-current-user-id")
  }
  echo
    .private(`messagethreads.${threadId}`)
    .listen('ProductMessageEvent', (e: any) => {
      console.log(e)
      if (e.id !== Number.parseInt(currentUserId)) {
        console.log('message not destined to me... ignoring')
        return
      }
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

  const urlParams = new URLSearchParams()
  urlParams.set('page', '2')
  let prevHeight = 0
  const preFetchCallback = (): void => {
    prevHeight = messageThreadContent.parentElement?.scrollHeight ?? 0
  }

  const callback = (): void => {
    messageThreadContent.parentElement?.scrollTo({ top: messageThreadContent.parentElement?.scrollHeight - prevHeight, behavior: 'instant' })
    prevHeight = 0
  }
  addEndObserver(urlParams, `/api/messages/${threadId}`, messageThreadContent, '.message-bubble', { editPage: false, prepend: true, reverse: true, preFetchCallback, callback })
}

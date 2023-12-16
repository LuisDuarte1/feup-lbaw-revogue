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
      console.log(e)
    })
}

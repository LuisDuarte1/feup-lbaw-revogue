export default function (element: Element): void {
  const messageThreadId = element.getAttribute('data-message-thread-id')
  if (messageThreadId == null) {
    throw Error("Couldn't find message thread id")
  }
  element.addEventListener('click', () => {
    location.href = `/messages?thread=${messageThreadId}`
  })
}

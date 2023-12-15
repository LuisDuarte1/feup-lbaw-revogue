export default function (element: Element): void {
  const input = element as HTMLTextAreaElement
  const initialHeight = input.offsetHeight
  const initialScrollHeight = input.scrollHeight
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
      console.log('Sending message...')
      ev.preventDefault()
    }
  })
}

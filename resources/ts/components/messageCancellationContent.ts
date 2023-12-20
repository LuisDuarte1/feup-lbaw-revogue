import { componentAJAXHandler } from '../app'
import { fetchWithSocketInformation } from '../utils/fetchUtils'

async function changeCancellationState (state: 'accept' | 'reject', messageThreadContent: Element, cancellationId: string): Promise<void> {
  const res = await fetchWithSocketInformation(`/api/orderCancellations/${cancellationId}/${state}`, { method: 'POST' })
  if (res.status !== 200) {
    console.error(`Request Cancellation with state ${state} failed with status: ${res.status}`)
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

export default function (element: Element): void {
  const messageThreadContent = document.querySelector('.message-thread-content')
  if (messageThreadContent === null) {
    throw Error("Couldn't get message thread content")
  }
  const cancellationId = element.getAttribute('data-cancellation-id')
  if (cancellationId === null) {
    throw Error('could not find attribute data-cancellation-id')
  }
  const acceptCancellation = document.querySelector('.accept-cancellation')
  acceptCancellation?.addEventListener('click', async () => {
    await changeCancellationState('accept', messageThreadContent, cancellationId)
  })

  const removeCancellationFunc = async (): Promise<void> => {
    await changeCancellationState('reject', messageThreadContent, cancellationId)
  }

  const rejectCancellation = document.querySelector('.reject-cancellation')
  const cancelCancellation = document.querySelector('.cancel-cancellation')
  rejectCancellation?.addEventListener('click', removeCancellationFunc)
  cancelCancellation?.addEventListener('click', removeCancellationFunc)
}

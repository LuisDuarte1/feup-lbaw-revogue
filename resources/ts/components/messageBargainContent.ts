import { componentAJAXHandler } from '../app'
import { fetchWithSocketInformation } from '../utils/fetchUtils'

async function changeBargainState (state: 'accept' | 'reject', messageThreadContent: Element, bargainId: string): Promise<void> {
  const res = await fetchWithSocketInformation(`/api/bargains/${bargainId}/${state}`, { method: 'POST' })
  if (res.status !== 200) {
    console.error(`Request bargain with state ${state} failed with status: ${res.status}`)
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
  const bargainId = element.getAttribute('data-bargain-id')
  if (bargainId === null) {
    throw Error('could not find attribute data-bargain-id')
  }
  const acceptBargain = document.querySelector('.accept-bargain')
  acceptBargain?.addEventListener('click', async () => {
    await changeBargainState('accept', messageThreadContent, bargainId)
  })

  const removeBargainFunc = async (): Promise<void> => {
    await changeBargainState('reject', messageThreadContent, bargainId)
  }

  const rejectBargain = document.querySelector('.reject-bargain')
  const cancelBargain = document.querySelector('.cancel-bargain')
  rejectBargain?.addEventListener('click', removeBargainFunc)
  cancelBargain?.addEventListener('click', removeBargainFunc)
}

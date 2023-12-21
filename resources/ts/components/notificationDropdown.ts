import { componentAJAXHandler } from '../app'
import { addEndObserver } from '../utils/infiniteScrolling'
import { notificationLoadCallback } from '../utils/notificationUtils'

export default function (element: HTMLElement): void {
  if (!(element instanceof HTMLDivElement)) {
    throw Error('#notification_button is not a div element')
  }
  const notificationToggle = element.querySelector('a')
  const notificationWrapper = element.querySelector('.notification-wrapper')
  const notificationContent = element.querySelector('.notification-wrapper > .notification-content')
  const urlParams = new URLSearchParams()
  urlParams.set('page', '2')

  if (notificationWrapper === null || notificationToggle === null || notificationContent === null) {
    throw Error('required elements not found')
  }

  // TODO (luisd): on lower resolutions redirect to the notifications page instead
  document.addEventListener('click', (ev) => {
    if (ev.target === null || !(ev.target instanceof HTMLElement)) {
      throw Error('target not found')
    }
    const insideElement = ev.target.closest('#notifications-icon') !== null
    if (!insideElement) {
      notificationWrapper.classList.remove('show-dropdown')
    }
  })

  notificationToggle.addEventListener('click', async (ev) => {
    ev.preventDefault()
    notificationWrapper.classList.toggle('show-dropdown')
    if (notificationContent.childElementCount === 0) {
      // this means that we have to get the inital notification content
      // we insert a loading wrapper before querying for notifications
      const div = document.createElement('div')
      div.classList.add('column', 'items-center', 'justify-center', 'grow-2')
      const loader = document.createElement('div')
      loader.classList.add('loader')
      div.appendChild(loader)

      notificationContent.appendChild(div)

      const req = await fetch('/api/notifications')

      notificationContent.innerHTML = ''
      if (req.status === 204) {
        const emptyDiv = document.createElement('div')
        emptyDiv.classList.add('column', 'items-center', 'justify-center', 'grow-2')
        const elem = document.createElement('img')
        emptyDiv.appendChild(elem)
        elem.src = '/empty_notifications.svg'
        elem.width = 300
        const text = document.createElement('p')
        text.textContent = 'It seems that your notification section is empty.'
        emptyDiv.appendChild(text)

        notificationContent.appendChild(emptyDiv)
        return
      }
      if (req.status !== 200) {
        const errorDiv = document.createElement('div')
        errorDiv.classList.add('column', 'items-center', 'justify-center', 'grow-2')
        errorDiv.textContent = 'There was an error while getting your notifications. Please try again later.'

        notificationContent.appendChild(errorDiv)

        console.error(`Something went wrong while querying /api/notificaions status: ${req.status}`)
        return
      }

      const html = document.createElement('html')
      html.innerHTML = await req.text()
      const listElements = Array.from(html.querySelectorAll('.notification-container'))
      componentAJAXHandler(listElements)
      void notificationLoadCallback(listElements)

      notificationContent.append(...listElements)

      const endPage = document.createElement('div')
      endPage.id = 'page-end'
      notificationContent.appendChild(endPage)

      addEndObserver(urlParams, '/api/notifications', notificationContent, '.notification-container', { editPage: false, callback: notificationLoadCallback })
    }
  })
}

export default function (element: HTMLElement): void {
  const clickURL = element.getAttribute('actionURL')
  const notificationId = element.getAttribute('data-notificationId')
  if (notificationId === null) {
    throw Error("Couldn't find notification id, probably it wasn't provided by blade.")
  }

  if (clickURL !== null) {
    if (clickURL === '#') {
      element.style.cursor = 'auto'
    } else {
      element.addEventListener('click', (ev) => {
        location.href = clickURL
      })
    }
  }
  const markAsRead = element.querySelector('.mark-as-read-notification')
  const dismissNotification = element.querySelector('.dismiss-notification')

  if (markAsRead === null || dismissNotification === null) {
    throw Error('Cannot find action notification buttons.')
  }

  markAsRead.addEventListener('click', async (ev) => {
    ev.stopImmediatePropagation()
    ev.preventDefault()
    void (async () => {
      const req = await fetch(`/api/notifications/${notificationId}/read`, { method: 'POST' })

      if (req.status !== 200) {
        console.warn(`Read toggle returned status ${req.status}`)
        return
      }

      const ionIcon = markAsRead.querySelector('ion-icon')
      if (ionIcon === null) {
        throw Error('Cannot find ion icon')
      }

      if (ionIcon.getAttribute('name') === 'mail-outline') {
        ionIcon.setAttribute('name', 'mail-open-outline')
      } else {
        ionIcon.setAttribute('name', 'mail-outline')
      }
    })()
  })

  dismissNotification.addEventListener('click', (ev) => {
    ev.stopImmediatePropagation()
    ev.preventDefault()
    void (async () => {
      const req = await fetch(`/api/notifications/${notificationId}/dismiss`, { method: 'POST' })

      if (req.status !== 200) {
        console.warn(`Dismiss toggle returned status ${req.status}`)
        return
      }
      element.parentElement?.remove()
    })()
  })
}

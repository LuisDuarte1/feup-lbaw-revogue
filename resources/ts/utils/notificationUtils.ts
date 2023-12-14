export async function notificationLoadCallback (element: Element[]): Promise<void> {
  element.forEach(async (val) => {
    if (!(val instanceof HTMLElement)) {
      throw Error('this is not a HTMLElement')
    }
    const id = val.children[0].getAttribute('data-notificationId')
    const readString = val.children[0].getAttribute('data-notificationRead')
    if (readString === null || id === null) {
      throw Error("Couldn't get read attribute")
    }
    const read = Boolean(readString)
    if (!read) {
      const req = await fetch(`/api/notifications/${id}/read`, { method: 'POST' })
      if (req.status !== 200) {
        console.error(`Couldn't mark ${id} as read`)
      }
    }
  })

  const req = await fetch('/api/notifications/unreadCount')
  if (req.status !== 200) {
    console.error('Couldn\'t get unread notifications count')
    return
  }

  const count: number = (await req.json()).count
  if (count === 0) {
    const notificationsIcon = document.querySelector('#notifications-icon')
    const ionIcon = notificationsIcon?.querySelector('ion-icon')
    ionIcon?.setAttribute('name', 'notifications-outline')
    notificationsIcon?.querySelector('.notification-ball')?.remove()
  }
}

import { addEndObserver } from '../utils/infiniteScrolling'
import { notificationLoadCallback } from '../utils/notificationUtils'

export function notifications (): void {
  const urlParams = new URLSearchParams()
  urlParams.set('page', '2')
  const notificationList = document.querySelector('.notifications-list')
  if (notificationList === null) {
    throw Error('Could not find .notification-list')
  }
  addEndObserver(urlParams, '/api/notifications', notificationList, '.notification-container', { editPage: false, callback: notificationLoadCallback })
}

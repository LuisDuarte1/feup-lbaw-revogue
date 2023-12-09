export default function (element: HTMLElement): void {
  if (!(element instanceof HTMLDivElement)) {
    throw Error('#notification_button is not a div element')
  }
  const notificationToggle = element.querySelector('a')
  const notificationWrapper = element.querySelector('.notification-wrapper')
  if (notificationWrapper === null || notificationToggle === null) {
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
  notificationToggle.addEventListener('click', async () => {
    notificationWrapper.classList.toggle('show-dropdown')
  })
}

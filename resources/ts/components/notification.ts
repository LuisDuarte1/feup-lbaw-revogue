export default function (element: HTMLElement): void {
  const clickURL = element.getAttribute('actionURL')
  if (clickURL !== null) {
    if (clickURL === '#') {
      element.style.cursor = 'auto'
    } else {
      element.addEventListener('click', (ev) => {
        location.href = clickURL
      })
    }
  }
}

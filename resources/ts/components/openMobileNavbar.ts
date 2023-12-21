export default function (element: Element): void {
  element.addEventListener('click', () => {
    const body = document.querySelector('body')
    if (body === null) {
      throw Error('Cannot find body')
    }

    body.classList.toggle('mobile-navbar-open')
  })
}

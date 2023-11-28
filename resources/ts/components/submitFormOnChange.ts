/*
  When the element detects a change, it traverses recursively the ancestors until it finds a form and submits that form.
  If form is not found it fails silently.
*/
export default function (element: HTMLElement): void {
  if (!(element instanceof HTMLSelectElement || element instanceof HTMLInputElement || element instanceof HTMLTextAreaElement)) {
    return
  }
  element.addEventListener('change', (ev) => {
    let form: HTMLElement | null = element.parentElement
    if (form === null) {
      return
    }
    while (!(form instanceof HTMLFormElement)) {
      form = form.parentElement
      if (form === null) return
    }
    form.submit()
  })
}

export function adminUser (): void {
  const accountStatus: HTMLSelectElement | null = document.querySelector('#account_status')
  if (accountStatus === null) {
    return
  }
  accountStatus.addEventListener('change', (ev) => {
    const form: HTMLFormElement | null = accountStatus.parentElement as HTMLFormElement | null
    if (form === null) {
      return
    }
    form.submit()
  })
}

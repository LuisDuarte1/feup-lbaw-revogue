export function getCSRFToken (): string | null {
  return (document.querySelector('meta[name=csrf-token]') as HTMLMetaElement).content
}

export function createFormData (): FormData {
  const csrf = getCSRFToken()
  if (csrf === null) {
    throw Error('Could not get csrf token')
  }
  const formData = new FormData()
  formData.set('__token', csrf)
  return formData
}

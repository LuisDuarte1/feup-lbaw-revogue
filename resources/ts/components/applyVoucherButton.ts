import { createFormData } from '../utils/csrf'

export default function (element: Element): void {
  const inputPromoCode: HTMLInputElement | null = document.querySelector('#promo-code')
  if (inputPromoCode === null) {
    throw Error('Could not find promo-code input element')
  }

  element.addEventListener('click', async (ev) => {
    const code = inputPromoCode.value
    const formData = createFormData()
    formData.set('code', code)

    const res = await fetch('/api/vouchers', { method: 'POST', body: formData })

    if (res.status !== 200) {
      console.log(`Voucher apply request failed with status ${res.status}`)
      return
    }

    location.reload()
  })
}

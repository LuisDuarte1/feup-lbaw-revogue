import { createFormData } from '../utils/csrf'

export default function (element: Element): void {
  const voucherCode = element.getAttribute('data-voucher-code')
  if (voucherCode === null) {
    throw Error('Data-voucher-code not found in this element')
  }

  element.addEventListener('click', async () => {
    const formData = createFormData()
    formData.set('code', voucherCode)
    const res = await fetch('/api/vouchers/delete', { method: 'post', body: formData })

    if (res.status !== 200) {
      console.error(`Remove voucher code failed with status ${res.status}`)
      return
    }

    element.parentElement?.parentElement?.remove()
    window.location.reload()
  })
}

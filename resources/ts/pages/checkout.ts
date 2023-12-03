import { type StripePaymentElement, type Stripe, type StripeElements } from '@stripe/stripe-js'
import { loadStripe } from '@stripe/stripe-js/pure'

let paymentElement: StripePaymentElement | null = null
let elements: StripeElements | null = null

function intializeStripeElement (stripe: Stripe | null): void {
  const stripeDiv: HTMLDivElement | null = document.querySelector('#stripe-payment-method')
  if (stripe === null || stripeDiv == null) {
    throw Error('This should never happen! Good luck :)')
  }
  let amount = Number.parseFloat(stripeDiv.getAttribute('amount') ?? '-1')
  if (amount === -1) {
    throw Error("Couldn't parse amount")
  }
  amount *= 100
  if (elements === null) {
    elements = stripe.elements(
      {
        mode: 'payment',
        amount,
        currency: 'eur',
        appearance: { theme: 'stripe', variables: { colorPrimary: '#6064A4', colorText: '#060604', colorBackground: '#F3F3EB' } }
      })
    paymentElement = elements.create('payment')
    paymentElement.on('loaderror', (ev) => { console.log(ev) })
    paymentElement.mount('#stripe-payment-method')
  } else {
    paymentElement?.mount('#stripe-payment-method')
  }
}

export async function checkout (): Promise<void> {
  const stripeObject = await loadStripe('pk_test_51OH0XHBAaom7Im7itwb5Z5tQbNduKU9NTQskbczaPsQ5yB9vMObR2GpPoR8FaJPHwTR3kaz7ctIPjSfoxdURP5oE005DTwUZOK')
  if (stripeObject === null) {
    throw Error('Stripe is null, cannot use stripe elements')
  }

  if (document.querySelector<HTMLInputElement>('input[name=payment_method]:checked')?.value === '1') {
    intializeStripeElement(stripeObject)
  }
  const radios = document.querySelectorAll<HTMLInputElement>('input[type=radio][name=payment_method]')
  radios.forEach((radio) => {
    radio.addEventListener('change', (ev) => {
      if (radio.value === '1') {
        intializeStripeElement(stripeObject)
      } else if (paymentElement !== null) {
        paymentElement.unmount()
      }
    })
  })
}

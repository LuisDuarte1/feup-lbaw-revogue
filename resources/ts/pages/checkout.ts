import { type StripePaymentElement, type Stripe, type StripeElements } from '@stripe/stripe-js'
import { loadStripe } from '@stripe/stripe-js/pure'

let paymentElement: StripePaymentElement | null = null
let elements: StripeElements | null = null
let paymentIntentSecret: string | null = null

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
        amount: Math.round(amount),
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

function submitFormStripe (stripe: Stripe, checkoutForm: HTMLFormElement, ev: Event): void {
  ev.preventDefault()
  const submitButton: HTMLButtonElement | null = checkoutForm.querySelector('.submit-button > button')
  if (submitButton === null) {
    throw Error('Cannot find form submit button')
  }
  if (submitButton.disabled) return

  submitButton.disabled = true
  const formData = new FormData(checkoutForm)
  const formDataObject: any = {}
  formData.forEach((value, key) => { formDataObject[key] = value })
  void (async () => {
    if (elements == null) {
      throw Error('elements should never be null')
    }
    const { error: submitError } = await elements.submit()
    if (submitError !== undefined) {
      console.log(submitError)
      return
    }
    if (paymentIntentSecret === null) {
      const req = await fetch('/api/checkout/getPaymentIntent',
        {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(formDataObject)
        })
      if (req.status !== 200) {
        submitButton.disabled = false
        console.log(await req.json())
        throw Error(`Payment intent failed with status ${req.status}`)
      }

      console.log(req)
      const paymentIntent = await req.json()
      paymentIntentSecret = paymentIntent.clientSecret
    }
    submitButton.disabled = false
    if (paymentIntentSecret === null) {
      throw Error('paymentIntentSecret should never be null')
    }
    const result = await stripe.confirmPayment({
      elements,
      clientSecret: paymentIntentSecret,
      confirmParams: {
        return_url: location.protocol + '//' + location.host + '/checkout/paymentConfirmation'
      }
    })

    console.log(result.error)
  })()
}

export async function checkout (): Promise<void> {
  const stripeObject = await loadStripe('pk_test_51OH0XHBAaom7Im7itwb5Z5tQbNduKU9NTQskbczaPsQ5yB9vMObR2GpPoR8FaJPHwTR3kaz7ctIPjSfoxdURP5oE005DTwUZOK')
  const checkoutForm: HTMLFormElement | null = document.querySelector('.checkout-form')
  if (stripeObject === null) {
    throw Error('Stripe is null, cannot use stripe elements')
  }
  if (checkoutForm === null) {
    throw Error('Cannot find checkout form')
  }

  if (document.querySelector<HTMLInputElement>('input[name=payment_method]:checked')?.value === '1') {
    intializeStripeElement(stripeObject)
    checkoutForm.addEventListener('submit', submitFormStripe.bind(null, stripeObject, checkoutForm))
  }

  const radios = document.querySelectorAll<HTMLInputElement>('input[type=radio][name=payment_method]')
  radios.forEach((radio) => {
    radio.addEventListener('change', (ev) => {
      if (radio.value === '1') {
        intializeStripeElement(stripeObject)
        checkoutForm.addEventListener('submit', submitFormStripe.bind(null, stripeObject, checkoutForm))
      } else if (paymentElement !== null) {
        paymentElement.unmount()
        checkoutForm.removeEventListener('submit', submitFormStripe.bind(null, stripeObject, checkoutForm))
      }
    })
  })
}

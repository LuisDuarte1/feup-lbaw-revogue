export default function (element: Element): void {
  const productId = element.getAttribute('data-product-id')
  if (productId == null) {
    throw Error("Couldn't find product id")
  }
  element.addEventListener('click', () => {
    location.href = `/messages?product=${productId}`
  })
}

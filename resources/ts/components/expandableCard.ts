export default function expandableCard (question: Element): void {
  question.addEventListener('click', event => {
    question.classList.toggle('active')
    const answer = question.nextElementSibling
    if (answer instanceof HTMLElement) {
      if (question.classList.contains('active')) {
        answer.style.display = 'flex'
        answer.style.maxHeight = answer.scrollHeight + 'px'
      } else {
        answer.style.maxHeight = '0'
        answer.style.display = 'none'
      }
    }
  })
}

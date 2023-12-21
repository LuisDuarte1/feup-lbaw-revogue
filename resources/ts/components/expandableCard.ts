export function expandableCard (): void {
  setupAccordion()
}

function setupAccordion (): void {
  document.addEventListener('DOMContentLoaded', () => {
    const questionBoxes = document.querySelectorAll('.question-box')

    questionBoxes.forEach((questionBox: Element) => {
      questionBox.addEventListener('click', () => {
        const answer = questionBox.querySelector('.answer') as HTMLElement

        if (answer !== null && answer !== undefined) {
          const maxHeight = answer.style.maxHeight
          answer.style.maxHeight = maxHeight ?? `${answer.scrollHeight}px`
        }

        const ionIcon = questionBox.querySelector('ion-icon')
        if (ionIcon !== null) {
          ionIcon.classList.toggle('rotated')
        }
      })
    })
  })
}

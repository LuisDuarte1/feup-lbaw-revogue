export function completeProfile (): void {
  const input: HTMLInputElement | null = document.querySelector('#profileImage')
  const image: HTMLImageElement | null = document.querySelector('#image')

  if (input === null) {
    console.error('Something went wrong while getting the input file element')
    return
  }
  if (image === null) {
    console.error('Something went wrong while getting the HTML image...')
    return
  }

  input.addEventListener('change', (event) => {
    if (input.files === null) {
      return
    }
    const file = input.files.item(0)
    if (file === null) {
      console.error('Something went wrong while getting the selected file...')
      return
    }
    image.src = URL.createObjectURL(file)
  })
};

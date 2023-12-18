document.addEventListener('DOMContentLoaded', () => {
  const filterIcon = document.querySelector('ion-icon') as HTMLElement
  const filters = document.querySelector('x-filters') as HTMLElement
  filterIcon.addEventListener('click', () => {
    if (filters.style.display === 'none') {
      filters.style.display = 'block'
    } else {
      filters.style.display = 'none'
 } } );
  });
  


const filterIcon = document.getElementById('filter-icon')
if (filterIcon !== null) {
  filterIcon.addEventListener('click', () => {
    const filters = document.getElementById('filters')
    if (filters !== null) {
      if (filters.style.display === 'none') {
        filters.style.display = 'block'
      } else {
        filters.style.display = 'none'
      }
    }
  })
}

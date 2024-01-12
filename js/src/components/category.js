// () => import(/* webpackChunkName: "category" */'./category.component.scss')

const filtersEl = document.querySelector('.category__filter')
if (filtersEl) {
  setTimeout(() => {
    const headFiltersList = filtersEl.querySelectorAll('.bapf_sfilter:not(.bapf_button_berocket):not(.bapf_sfa_inline)')
    headFiltersList.forEach((item, index) => {
      const isOpened = item.classList.contains('bapf_ccolaps')
      if (isOpened && index) {
        item.querySelector('.bapf_hascolarr').click()
      }
    })

    filtersEl.addEventListener('click', e => {
      const isHead = e.target.classList.contains('bapf_hascolarr')
      const isIco = e.target.classList.contains('bapf_colaps_smb')
      let headEl
  
      if (isIco) {
        headEl = e.target.closest('.bapf_hascolarr')
      } else if (isHead) {
        headEl = e.target
      }
  
      if (headEl) {
        const openedFilters = filtersEl.querySelectorAll('.bapf_ccolaps')
        openedFilters.forEach(item => {
          if (item !== headEl.closest('.bapf_sfilter')) {
            item.querySelector('.bapf_hascolarr').click()
          }
        })
      }
    })

    /*const filterBrands = filtersEl.querySelector('.bapf_sfilter[data-name="Brands"]')
    if (filterBrands) {
      //const dataName = filterBrands.dataset.name
      const toggleBtn = filterBrands.querySelector('.bapf_show_hide')
      if (toggleBtn) {
        const showText = 'Show more'
        const hideText = 'Show less'
        toggleBtn.dataset.show = showText
        toggleBtn.dataset.hide = hideText
        toggleBtn.innerHTML = showText
      }
    }*/
  }, 300)
}
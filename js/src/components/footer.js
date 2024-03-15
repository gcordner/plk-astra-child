export const hideContactForm7Message = () => {
    const footerEl = document.querySelector('.site-footer')
    if (footerEl) {
      const messageEl = footerEl.querySelector('.wpcf7-response-output')
      if (messageEl) {
        const observer = new MutationObserver(mutationRecords => {
          if (mutationRecords[0].target.innerText) {
            messageEl.classList.add('active')
            setTimeout(() => {
              messageEl.classList.remove('active')
            }, 5000)
          }
        })
    
        observer.observe(messageEl, {
          childList: true,
          subtree: true,
          characterDataOldValue: true
        })
      }
    }
}
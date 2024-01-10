class Harm {
  constructor(wrapEl) {
    this.list = wrapEl.querySelectorAll('.accordion');
  }

  calcHeight(list) {
    let res = 0;
    console.log(list.length);
    for (let count = 0; count < list.length; count++) {
      const currentStyles = getComputedStyle(list[count]);
      const currentMT = currentStyles.marginTop;
      const currentMB = currentStyles.marginBottom;
      res += list[count].offsetHeight;
      if (currentMT) {
        res += parseInt(currentMT);
      }
      if (currentMB) {
        res += parseInt(currentMB);
      }
    }
    return res;
  }

  isOpened(item) {
    const isOpened = item.classList.contains('opened');
    console.log(`Accordion is opened: ${isOpened}`);
    return isOpened;
  }

  onClick(event) {
    event.preventDefault();

    const head = event.currentTarget;
    const item = head.closest('.accordion');
    const body = item.querySelector('.accordion__content');

    item.classList.toggle('opened');

    const isOpened = this.isOpened(item);

    if (isOpened) {
      const height = this.calcHeight(body.children);

      body.style.height = `${height}px`;
      body.addEventListener('transitionend', () => {
        if (body.style.height) {
          body.style.height = 'auto';
        }
      }, { once: true });
    } else {
      const height = this.calcHeight(body.children);

      body.style.height = `${height}px`;

      setTimeout(() => {
        body.removeAttribute('style');
      }, 0);
    }
  }

  init() {
    this.list.forEach(item => {
      const head = item.querySelector('.accordion__link');

      head.addEventListener('click', this.onClick.bind(this));
    });
  }
}

const faqNodes = document.querySelectorAll('.faq__list');

faqNodes.forEach(item => {
  const faq = new Harm(item);
  faq.init();
});

console.log('Harm loaded');

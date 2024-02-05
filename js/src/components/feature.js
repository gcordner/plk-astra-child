import '@splidejs/splide/css';
import Splide from '@splidejs/splide';

import Swiper, { Navigation } from 'swiper';
import 'swiper/css';
import 'swiper/css/navigation';

// init Swiper:
export const featureSliderBySplide = () => {
  var splide = new Splide( '.splide', {
    perPage: 3,
    breakpoints: {
      640: {
        perPage: 2,
      },
    },
    focus  : 0
  } );
  
  splide.mount();
}

export const featureSlider = () => {
  const productsNewElement = document.querySelector('.feature-container');

  const slider = new Swiper('.feature-container', {
      modules: [Navigation],
      slidesPerView: 3,
      spaceBetween: 20,
      loop: false,
      loopAdditionalSlides: 0,
      navigation: {
          nextEl: '.custom-navigation__button--next-feature',
          prevEl: '.custom-navigation__button--prev-feature',
      },
  });
  slider.on('resize', () => {
      const isLoopDestroy = productsNewElement.querySelectorAll('.swiper-slide:not(.swiper-slide-duplicate)').length <= slider.params.slidesPerView;
      if (isLoopDestroy) {
          slider.loopDestroy();
      } else if (slider.params.loop) {
          slider.loopCreate();
      }
  });
}
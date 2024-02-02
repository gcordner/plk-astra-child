import Swiper, { Navigation } from 'swiper';
import 'swiper/css';
import 'swiper/css/navigation';

const STATIC_PAGES_SLIDER_BREAKPOINTS = {
  360: {
    slidesPerView: 2,
    //loopAdditionalSlides: 4,
    spaceBetween: 14
  },
  768: {
    slidesPerView: 3,
    //loopAdditionalSlides: 4,
    spaceBetween: 14
  },
  1024: {
    slidesPerView: 4,
    //loopAdditionalSlides: 4,
    spaceBetween: 14
  },
  1280: {
    slidesPerView: 5,
    //loopAdditionalSlides: 4,
    spaceBetween: 14
  },
  1440: {
    slidesPerView: 6,
    //loopAdditionalSlides: 4,
    spaceBetween: 24
  }
}
const PRODUCT_SLIDER_BREAKPOINTS = {
  360: {
    slidesPerView: 2,
    //loopAdditionalSlides: 4,
    spaceBetween: 14
  },
  768: {
    slidesPerView: 3,
    //loopAdditionalSlides: 4,
    spaceBetween: 14
  },
  1024: {
    slidesPerView: 4,
    //loopAdditionalSlides: 4,
    spaceBetween: 14
  },
  1280: {
    slidesPerView: 4,
    //loopAdditionalSlides: 4,
    spaceBetween: 14
  },
  1440: {
    //slidesPerView: 6,
    slidesPerView: 4,
    //loopAdditionalSlides: 4,
    spaceBetween: 30
  }
}

export const featureSlider = () => {
    console.log('I ma in feature slider');
    const productsSlider = document.querySelector('.feature__slider');

    new Swiper(productsSlider, {
        slidesPerView: 'auto',
        breakpoints: {
          480: {
            direction: 'vertical'
          },
        },
        on: {
          init(swiper) {
            const totalSlidesLen = swiper.slides.length;
            swiper.el.querySelector('.custom-navigation__button--prev-feature').addEventListener('click', () => {
              if (swiper.isBeginning) {
                swiper.slideTo(totalSlidesLen - 1);
              } else {
                swiper.slideTo(swiper.realIndex - 1);
              }
            });
            swiper.el.querySelector('.custom-navigation__button--next-feature').addEventListener('click', () => {
              if (swiper.isEnd) {
                swiper.slideTo(0);
              } else {
                swiper.slideTo(swiper.realIndex + 1);
              }
            });
          },
          touchStart(swiper, e) {
            if (e.type === 'touchstart') {
              swiperTouchStartX = e.touches[0].clientX;
            } else {
              swiperTouchStartX = e.clientX;
            }
          },
          touchEnd(swiper, e) {
            const tolerance = 150;
            const totalSlidesLen = swiper.slides.length;
            const diff = (() => {
              if (e.type === 'touchend') {
                return e.changedTouches[0].clientX - swiperTouchStartX;
              } else {
                return e.clientX - swiperTouchStartX;
              }
            })()
            if (swiper.isBeginning && diff >= tolerance) {
              swiper.slideTo(totalSlidesLen - 1)
            } else if (swiper.isEnd && diff <= -tolerance) {
              setTimeout(() => {
                swiper.slideTo(0)
              }, 1)
            }
          },
        },
      })
}

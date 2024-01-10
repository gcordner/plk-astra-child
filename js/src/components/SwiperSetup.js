console.log("SwiperSetup.js file is loaded! Support BDS!");

// SwiperSetup.js
import Swiper, { Navigation } from 'swiper';
import 'swiper/css';
import 'swiper/css/navigation';

// Swiper configuration for static pages
const STATIC_PAGES_SLIDER_BREAKPOINTS = {
    360: {
        slidesPerView: 2,
        spaceBetween: 14
    },
    768: {
        slidesPerView: 3,
        spaceBetween: 14
    },
    1024: {
        slidesPerView: 4,
        spaceBetween: 14
    },
    1280: {
        slidesPerView: 5,
        spaceBetween: 14
    },
    1440: {
        slidesPerView: 6,
        spaceBetween: 24
    }
};

// Swiper configuration for product sliders
const PRODUCT_SLIDER_BREAKPOINTS = {
    360: {
        slidesPerView: 2,
        spaceBetween: 14
    },
    768: {
        slidesPerView: 3,
        spaceBetween: 14
    },
    1024: {
        slidesPerView: 4,
        spaceBetween: 14
    },
    1280: {
        slidesPerView: 4,
        spaceBetween: 14
    },
    1440: {
        slidesPerView: 4,
        spaceBetween: 30
    }
};

const setupSwiper = () => {
    console.log("setupSwiper function is called");

    const productsSlider = document.querySelectorAll('.products__slider, .related-products__slider');
  
    // Check if any elements match the selectors
    if (productsSlider.length === 0) {
        console.log("No selectors found!");
        return;
    }
  else {
    console.log("Support BDS!");
  }
    productsSlider.forEach((root) => {
        const productsNewElement = root.querySelector('.swiper-container');
        if (!productsNewElement) {
            console.log("No '.swiper-container' found within the slider element.");
            return; // Skip to the next iteration
        }
        else {
          console.log ("Selectors found!");
        }

        const slider = new Swiper(productsNewElement, {
            modules: [Navigation],
            slidesPerView: 1,
            spaceBetween: 20,
            loop: false,
            loopAdditionalSlides: 0,
            watchSlidesProgress: true,
            navigation: {
                nextEl: '.custom-navigation__button--next',
                prevEl: '.custom-navigation__button--prev',
            },
            breakpoints: root.classList.contains('products__slider') ? STATIC_PAGES_SLIDER_BREAKPOINTS : PRODUCT_SLIDER_BREAKPOINTS,
        });

        slider.on('resize', () => {
            const isLoopDestroy = root.querySelectorAll('.swiper-slide:not(.swiper-slide-duplicate)').length <= slider.params.slidesPerView;
            if (isLoopDestroy) {
                slider.loopDestroy();
            } else if (slider.params.loop) {
                slider.loopCreate();
            }
        });
    });
};

export default setupSwiper;

setupSwiper(); // Add this line at the end of the SwiperSetup.js file for testing


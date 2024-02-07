import '@splidejs/splide/css';
import Splide from '@splidejs/splide';
import { STATIC_PAGES_SLIDER_BREAKPOINTS } from './breakpoints';

export const splideSlider = (className, breakPoints = STATIC_PAGES_SLIDER_BREAKPOINTS) => {
  var splide = new Splide( className, {
    perPage: 6,
    perMove: 1,
    breakpoints: breakPoints,
  } );
  splide.mount();
}
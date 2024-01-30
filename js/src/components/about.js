import simpleParallax from 'simple-parallax-js';

export const aboutUsParallax = () => {
  const aboutImageParallax = document.querySelector('.about__image--animated');
  const animationBlock = document.querySelectorAll('.animate-on-scroll');
  const aboutImageElement = document.querySelector('.about__wrapper--small');

  const onEntry = (entry) => {
    entry.forEach(change => {
      if (change.isIntersecting) {
        change.target.classList.add('animated');
      }
    });
  }

  const options = { threshold: [0.5] };
  const observer = new IntersectionObserver(onEntry, options);

  if (animationBlock) {
    const elements = document.querySelectorAll('.animate-on-scroll');  
    for (const elm of elements) {
      observer.observe(elm);
    }
  }

  const imageElements = document.querySelectorAll('img');
  const reviewSlider = document.querySelector('.stamped-carousel-scroll');
  const productSliderSection = document.querySelector('.product__slider');

  if (!(reviewSlider) || !(productSliderSection)) {
    for (const img of imageElements) {
      observer.observe(img);
    }
  }

  if (aboutImageParallax) {
    const infoblockImageInner = aboutImageParallax.querySelectorAll('img');
    new simpleParallax(infoblockImageInner, {    
      overflow: true,
      scale: 2,
    });
  }

  if (aboutImageElement) {
    const aboutImageInner = aboutImageElement.querySelectorAll('img');
    new simpleParallax(aboutImageInner);
  }
}
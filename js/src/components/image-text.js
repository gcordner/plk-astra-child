import simpleParallax from 'simple-parallax-js';

export const imageTextParallax = () => {
  const imageTextParallax = document.querySelector('.infoblock__parallax');
  const animationBlock = document.querySelectorAll('.animate-on-scroll');

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
    for (const elm of animationBlock) {
      observer.observe(elm);
    }
  }

  if (imageTextParallax) {
    const infoblockImageInner = imageTextParallax.querySelectorAll('img');
    new simpleParallax(infoblockImageInner, {    
      overflow: true,
      scale: 2,
    });
  }
}
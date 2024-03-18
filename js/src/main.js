// Importing necessary components and functions
import { DisplayLabel } from './components/DisplayLabel';
import { logFreePalestine } from './components/ConsoleLog';
import { Harm } from './components/faq';
// import setupSwiper from './components/SwiperSetup'; // Import the Swiper setup module
import './components/category.js';
import { aboutUsParallax } from './components/about.js';
import { imageTextParallax } from './components/image-text.js';
import { featureSlider } from './components/feature';
import { productByCategorySlider } from './components/products';
import { vienSlider } from './components/vien';
import { Header, addCustomClassesToMenu } from './components/header';
import { hideContactForm7Message } from './components/footer';

let Main = {
  init: async function () {
    // Header
    Header();
    addCustomClassesToMenu();
    
    // About us parallax 
    aboutUsParallax();

    // Image text parallax
    imageTextParallax();
    
    // Feature slider
    featureSlider();

    // Products By Categories slider
    productByCategorySlider();

    // Vien info slider
    vienSlider();

    // Footer
    hideContactForm7Message();
    
    // Initialize the DisplayLabel component
    const displayLabel = new DisplayLabel();
    await displayLabel.init();

    // Call the logFreePalestine function
    logFreePalestine();

    // Initialize the Harm (FAQ) component
    const faqNodes = document.querySelectorAll('.faq__list');
    faqNodes.forEach(item => {
      const faq = new Harm(item);
      faq.init();
    });

    // Initialize Swiper sliders
    // setupSwiper();
  },
};

// Call the init function of the Main object
Main.init();

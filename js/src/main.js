// Importing necessary components and functions
import { DisplayLabel } from './components/DisplayLabel';
import { logFreePalestine } from './components/ConsoleLog';
import { Harm } from './components/faq';
import setupSwiper from './components/SwiperSetup'; // Import the Swiper setup module

let Main = {
  init: async function () {
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
    setupSwiper();
  },
};

// Call the init function of the Main object
Main.init();

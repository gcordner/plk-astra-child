export const elementByClass = (className) => {
    if (!className) {
      console.error('ClassName must be provided');
      return null;
    }
  
    const targetElement = window.document.querySelector(`.${className}`);
  
    if (!targetElement) {
      console.error(`Element with class '${className}'`);
      return null;
    }
  
    return targetElement;
}

export const elementsByClass = (className) => {
    if (!className) {
      console.error('ClassName must be provided');
      return null;
    }
  
    const targetElements = window.document.querySelectorAll(`.${className}`);
  
    if (!targetElements) {
      console.error(`Element with class '${className}'`);
      return null;
    }
  
    return targetElements;
}
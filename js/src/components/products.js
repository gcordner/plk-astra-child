import { splideSlider } from '../common/slider';
import { elementsByClass } from '../common/util';
import { PRODUCT_BY_CATEGORY_SLIDER_BREAKPOINTS } from '../common/breakpoints';

const CLASS = 'products__slider';

export const productByCategorySlider = () => {
    const sliderElements = elementsByClass('products__slider');
    const newClasses = [];
    sliderElements.forEach((element, i) => {
        const newClass = CLASS + '-' + i; 
        element.classList.add(newClass);
        element.setAttribute('id', newClass);
        newClasses.push(newClass);
    });

    newClasses.forEach(element => {
        splideSlider('#' + element, PRODUCT_BY_CATEGORY_SLIDER_BREAKPOINTS);
    });
};
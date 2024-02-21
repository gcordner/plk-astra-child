import { VIEN_INFO_BLOCK_SLIDER_BREAKPOINTS } from '../common/breakpoints';
import Splide from '@splidejs/splide';

export const vienSlider = () => {
    var splide = new Splide( '#vien_splide', {
        perPage: 6,
        perMove: 1,
        breakpoints: VIEN_INFO_BLOCK_SLIDER_BREAKPOINTS,
        padding: { left: 0, right: 5 },
    } );
    splide.on('visible', function (slide) {
        if(window.innerWidth > 1024 && splide.length == 4) {
            const vienSplide = document.getElementById('vien_splide');
            const vienSplideList = document.getElementById('vien_splide-list');
            const vienSplideArrows = vienSplide.querySelector('.splide__arrows');
            if(vienSplide) {
                if (vienSplideArrows) {
                    vienSplideArrows.style.display = 'none';
                }
                const parentContainer = vienSplide.closest('.container');
                const parentASTContainer = vienSplide.closest('.ast-container');
                const ASTContainerWidth = parentASTContainer.clientWidth;
                parentContainer.style.width = ASTContainerWidth + 'px';
                console.log('AAA', parentContainer.style.width);
                vienSplideList.style.left =  '0%';
            }

        }
    });
    splide.mount();
}
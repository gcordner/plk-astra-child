import { disableBodyScroll, clearAllBodyScrollLocks } from 'body-scroll-lock'

export const Header = () => {

    const headerElement = document.querySelector('.header')
    const mobileMenuElement = document.querySelector('.header__nav-block')
    const closeButton = document.querySelector('.header__banner-close')
    const rootElement = document.querySelector('.root')

    const menuEl = document.querySelector('.header__nav-list')

    let top_scroll_position = 0;

    window.addEventListener('scroll', () => {
        top_scroll_position = window.scrollY;

        if (top_scroll_position !== 0) {
            headerElement.classList.add('header--shadow');
        } else {
            headerElement.classList.remove('header--shadow');
        }
    })

    if (rootElement && closeButton && headerElement && mobileMenuElement) {
        if (!window.localStorage.getItem('bar_shown')) {
            const headerHeight = () => {
            const doc = document.documentElement
            const header = document.querySelector('.header')
            doc.style.setProperty('--header-height', `${header.offsetHeight}px`)
            }

            closeButton.addEventListener('click', () => {
            window.localStorage.setItem('bar_shown', true)
            headerElement.classList.remove('bar-shown')
            setTimeout(headerHeight, 350)
            })
            headerElement.style.setProperty('--header-banner-height', `${headerElement.querySelector('.header__banner').scrollHeight}px`)
            /*setTimeout(() => {
            headerElement.classList.add('bar-shown')
            }, 1)*/
            setTimeout(headerHeight, 350)
        }
        else{
            headerElement.classList.remove('bar-shown')
        }
    }

    const scrollElement = document.querySelector('.header__nav-list');
    const hamburgerElement = document.querySelector('.header__nav-burger');

    if (scrollElement && hamburgerElement) {
        hamburgerElement.addEventListener('click', (event) => {
            event.preventDefault()

            if (!document.body.classList.contains('open-menu')) {
            const header = document.querySelector('.header')
            document.documentElement.style.setProperty('--header-height', `${header.offsetHeight}px`)
            document.body.classList.add('open-menu')
            disableBodyScroll(scrollElement)
            } else {
            document.body.classList.remove('open-menu')

            const openedSub = document.querySelector('.header .header__nav-dropdown.open')
            if (openedSub) {
                openedSub.classList.remove('open')
                menuEl.classList.remove('dropdown-opened')
            }
            const openedLists = document.querySelectorAll('.header .header__nav-dropdown-link.active')
            openedLists.forEach(item => {
                item.classList.remove('active')
                item.nextSibling.style.removeProperty('max-height')
            })

            clearAllBodyScrollLocks()
            }
        });
    }

    const navItems = document.querySelectorAll('.header__nav-item');
    navItems.forEach(item => {
        const navLink = item.querySelector('.header__nav-link')
        const subMenu = item.querySelector('.header__nav-dropdown')

        if (subMenu) {
            navLink.addEventListener('click', (event) => {
            if (window.innerWidth <= 1024) {
                event.preventDefault();
                subMenu.classList.toggle('open')
                if (subMenu.classList.contains('open')) {
                menuEl.classList.add('dropdown-opened')
                } else {
                menuEl.classList.remove('dropdown-opened')
                }
                return false;
            }
            })
        }
    });

    const backButtons = document.querySelectorAll('.header__nav-dropdown-back-link');

    backButtons.forEach(link => {
        link.addEventListener('click', (evt) => {
            evt.preventDefault();

            const closestElem = link.closest('.header__nav-dropdown');
            if (closestElem.classList.contains('open')) {
            closestElem.classList.remove('open')
            }
            if (menuEl.classList.contains('dropdown-opened')) {
            menuEl.classList.remove('dropdown-opened')
            }
        })
    })

    const accMenuElements = document.querySelectorAll('.header__nav-dropdown-link');
    accMenuElements.forEach(item => {
        item.addEventListener('click', () => {
            item.classList.toggle('active');
            const panel = item.nextElementSibling;
            if (panel.style.maxHeight) {
            panel.style.maxHeight = null;
            } else {
            panel.style.maxHeight = panel.scrollHeight + 'px';
            }
        });
    })

    document.addEventListener('DOMContentLoaded', () => {
        const bodyOpenBlock = document.querySelector('body');

        rootElement && rootElement.addEventListener('click', e => {
            const target = e.target;
            if (!target.closest('.header__nav-list') && !target.closest('.header__nav-burger')) {
            bodyOpenBlock.classList.remove('open-menu')

            const openedSub = document.querySelector('.header .header__nav-dropdown.open')
            if (openedSub) {
                openedSub.classList.remove('open')
                menuEl.classList.remove('dropdown-opened')
            }
            const openedLists = document.querySelectorAll('.header .header__nav-dropdown-link.active')
            openedLists.forEach(item => {
                item.classList.remove('active')
                item.nextElementSibling.style.removeProperty('max-height')
            })

            clearAllBodyScrollLocks()
            }
        })
    });
}

export const addCustomClassesToMenu = () => {
    const topLevelLiElements = document.querySelectorAll('ul#ast-hf-menu-1 > li');
    
    topLevelLiElements && topLevelLiElements.forEach((li, i) => {
        if (li.classList.contains('astra-megamenu-li')) {
            const elem = li.querySelector('.astra-megamenu');
            if(i === 0) {
                if(elem) {
                    elem.classList.add('first-megamenu');
                }
            }
            if(i === 2) {
                if(elem) {
                    elem.classList.add('second-megamenu');
                }
            }
            li.classList.add('with-megamenu');
        } else {
            li.classList.add('without-megamenu');
        }
    });
}
import './bootstrap';
import { PageFlip } from 'page-flip';

document.addEventListener('DOMContentLoaded', () => {
    const flipbookEl = document.getElementById('flipbook');
    if (flipbookEl) {
        const pageFlip = new PageFlip(flipbookEl, {
            width: 400, // base page width
            height: 600, // base page height
            size: 'stretch',
            minWidth: 300,
            maxWidth: 1000,
            minHeight: 400,
            maxHeight: 1500,
            maxShadowOpacity: 0.5,
            showCover: true,
            mobileScrollSupport: false
        });

        // Load pages from DOM
        pageFlip.loadFromHTML(document.querySelectorAll('.page'));

        // Expose to window for debug/buttons
        flipbookEl.pageFlip = pageFlip;
    }
});

import '../bootstrap';
import $ from 'jquery';
window.$ = window.jQuery = $;

import 'bootstrap';

if (window.URL)
    (async () => {
        let page = window.location.pathname
        switch (true) {
            case page === '/gallery/create':
                case page === '/posts/create':
                case /^\/posts\/[^/]+/.test(page):
                await import('bootstrap/dist/css/bootstrap.min.css');
                await import('bootstrap-icons/font/bootstrap-icons.css');
                await import('bootstrap-fileinput/js/fileinput');
                await import('bootstrap-fileinput/css/fileinput.css');
                await import('./fileinput-custom');
                break;
        }
    })();

// Existing DOM behavior (keep it, but guard against missing elements)
const resize = document.querySelector('#resize');
if (resize) {
    resize.addEventListener('click', function () {
        const section = document.querySelector('section');
        const main = document.querySelector('main');
        if (section) section.classList.toggle('hidden-left');
        if (main) main.classList.toggle('margin-left');
    });
}

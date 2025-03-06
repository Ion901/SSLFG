import '../bootstrap';
let resize = document.querySelector('#resize');

    resize.addEventListener('click',function(){

        const section = document.querySelector('section');
        const main = document.querySelector('main');
        section.classList.toggle('hidden-left');
        main.classList.toggle('margin-left');
    })



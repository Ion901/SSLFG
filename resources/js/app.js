import './bootstrap';
const navbar = document.querySelector('.container-fluid');
let lastScrollTop = 0;
if(navbar){
    window.addEventListener('scroll', function(){
        let scrollTop = document.documentElement.scrollTop;
        if(scrollTop > lastScrollTop){
            navbar.style.top = "-120px";
        }else if(scrollTop == 0){
            navbar.style.backgroundColor = "linear-gradient(180deg, rgb(6, 91, 209) 0%, rgba(0,212,255,0) 100%)";
            navbar.style.boxShadow = 'none';
            navbar.style.backdropFilter= 'blur(0px)';
        }else{
            navbar.style.top = "0px";
            navbar.style.backgroundColor = 'linear-gradient(180deg, rgb(6, 91, 209) 0%, rgba(0,212,255,0) 100%)';
            navbar.style.backdropFilter= 'blur(1px)';
            navbar.style.boxShadow = '0 2px 2px -2px rgba(0,0,0,.2)';
            navbar.style.zIndex = "99999999";
        }
        lastScrollTop = scrollTop;
    });
}


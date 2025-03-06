import '../bootstrap';
import '../../../public/build/assets/fileinput'
import { startlightbox } from '../lightbox';

startlightbox();

const linkModal = document.querySelector('#linkModal');
const category = document.querySelector('#category');
const modal = document.querySelector('#modal');

linkModal.addEventListener('click',function(){

    // modal.classList.remove('hidden');
    if(modal.classList.contains('hidden')){
        modal.classList.remove('hidden');
        modal.classList.add('block')
    }else{
        modal.classList.add('hidden')
    }
    // modal.classList.add('absolute','top-[50]','left-[50%]','z-[99]','transform','scale-[1.2]','bg-gray-300','w-[400px]','h-[400px]')
})

category.addEventListener('change',function(){
    if(category.value === "SPORT"){
        if(linkModal.classList.contains('hidden')){
            linkModal.classList.remove('hidden');
            linkModal.classList.add('block')
        }else{
            linkModal.classList.add('hidden')
        }
    }else{
        const inputs = modal.querySelectorAll('input');
        inputs.forEach(input => {
            input.value = "";
        })
        linkModal.classList.add('hidden');
        modal.classList.add('hidden')
    }
})

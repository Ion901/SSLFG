export function startlightbox(){
document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("myModal");
    const modalImg = document.getElementById("img01");
    const closeBtn = document.querySelector(".close");
    const prevBtn = document.querySelector(".prev");
    const nextBtn = document.querySelector(".next");

    let images = Array.from(document.querySelectorAll(".myImg"));
    let currentIndex = 0;

    function openModal(index) {
        currentIndex = index;
        modal.style.display = "flex";
        modalImg.src = images[currentIndex].src;
        document.querySelector('body').style.overflow='hidden';
    }

    function closeModal() {
        modal.style.display = "none";
        document.querySelector('body').removeAttribute('style');
    }

    function showNext() {
        currentIndex = (currentIndex + 1) % images.length;
        modalImg.src = images[currentIndex].src;
    }

    function showPrev() {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        modalImg.src = images[currentIndex].src;
    }

    images.forEach((img, index) => {
        img.addEventListener("click", function () {
            openModal(index);
        });
    });

    closeBtn.addEventListener("click", closeModal);
    modal.addEventListener("click", function (e) {
        if (e.target === modal) {
            closeModal();
        }
    });

    nextBtn.addEventListener("click", showNext);
    prevBtn.addEventListener("click", showPrev);

    document.addEventListener("keydown", function (e) {
        if (modal.style.display === "flex") {
            if (e.key === "ArrowRight") showNext();
            if (e.key === "ArrowLeft") showPrev();
            if (e.key === "Escape") closeModal();
        }
    });
});

};

export default startlightbox;

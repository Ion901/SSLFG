import { startlightbox } from './lightbox';

startlightbox();

const targets = document.querySelectorAll('.images-slider img');

document.addEventListener('DOMContentLoaded', () => {
    if (window.URL) {
        let page = window.location.pathname;

        if (/gallery/.test(page)) {
            $(".custom-file-input").on("change", function () {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });

            $(".clear-file").on("click", function () {
                var fileInput = $(this).closest("form").find(".custom-file-input");
                var fileLabel = $(this).closest("form").find(".custom-file-label");

                fileInput.val(""); // Clear only this specific input
                fileLabel.removeClass("selected").html("Choose file"); // Reset label
            });
        }
    }
})

const lazyLoad = target => {
    const io = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                const src = img.getAttribute('data-lazy');

                img.setAttribute('src', src);
                img.classList.add('in-view');

                observer.disconnect();
            }
        });
    });

    io.observe(target)
};

targets.forEach(lazyLoad);

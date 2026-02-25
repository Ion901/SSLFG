

import 'yearpicker.js/dist/yearpicker.js';
import 'yearpicker.js/dist/yearpicker.css';


document.addEventListener("DOMContentLoaded", function () {
    if (window.URL) {
        let page = window.location.pathname;

        if (/^\/athlets\/[\d]+/.test(page)) {
            AthletAgeEdit();
        }
    }
});

function AthletAgeEdit() {
    $('.yearpicker').yearpicker({
        year: athlet.age
    })
}



$(document).ready(function () {
    $('.yearpicker').each(function () {
        const initialValue = $(this).val();
        $(this).yearpicker(); // Initialize the yearpicker
        $(this).val(initialValue); // Restore the initial value
    });
});


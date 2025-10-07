export function initObserver(selectors = [], options = {}) {
    if (!selectors.length) return console.warn('Niciun element nu a fost selectat');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('in-view')
                entry.target.classList.remove('not-in-view')
            } else {
                // entry.target.classList.remove('in-view')
                entry.target.classList.add('not-in-view')
            }
        })
    }, {
        rootMargin: '0px',
        threshold: [0, 0.1, 1],
    })
    selectors.forEach((selector) => {
        document.querySelectorAll(selector).forEach(el => observer.observe(el))
    });
}




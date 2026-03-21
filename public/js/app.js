import './bootstrap';

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
        }
    });
}, { threshold: 0.1 });

document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));


// ── COLOR DOT SELECTOR ──
document.querySelectorAll('.color-dots').forEach(dotsWrapper => {
    dotsWrapper.querySelectorAll('.dot').forEach(dot => {
        dot.addEventListener('click', () => {
            dotsWrapper.querySelectorAll('.dot').forEach(d => d.classList.remove('active'));
            dot.classList.add('active');
        });
    });
});


// ── NAVBAR ACTIVE CATEGORY ──
const currentPath = window.location.search;
document.querySelectorAll('.nav-cats a').forEach(link => {
    if (link.href.includes(currentPath) && currentPath !== '') {
        link.classList.add('active');
    }
});


// ── SEARCH FORM SUBMIT ON ENTER ──
const searchInput = document.querySelector('.nav-search');
if (searchInput) {
    searchInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            const query = searchInput.value.trim();
            if (query) {
                window.location.href = `/shoes?search=${encodeURIComponent(query)}`;
            }
        }
    });
}

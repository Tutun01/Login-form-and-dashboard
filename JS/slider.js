
const slider = document.querySelector('.slider');
const next = document.querySelector('.next');
const prev = document.querySelector('.prev');
let scrollAmount = 0;

next.addEventListener('click', () => {
    const cardWidth = document.querySelector('.blog-card').offsetWidth + 20; 
    scrollAmount += cardWidth * 2; 
    if (scrollAmount >= slider.scrollWidth) scrollAmount = 0;
    slider.style.transform = `translateX(-${scrollAmount}px)`;
});

prev.addEventListener('click', () => {
    const cardWidth = document.querySelector('.blog-card').offsetWidth + 20;
    scrollAmount -= cardWidth * 2;
    if (scrollAmount < 0) scrollAmount = 0;
    slider.style.transform = `translateX(-${scrollAmount}px)`;
});


document.addEventListener('DOMContentLoaded', () => {
    const track = document.querySelector('.carousel-track');
    const slides = document.querySelectorAll('.carousel-img');
    const dots = document.querySelectorAll('.dot');
    let currentIndex = 0;

    // Define larguras corretas
    function setSlideWidths() {
        const carousel = document.querySelector('.carousel');
        const slideWidth = carousel.offsetWidth;
        track.style.width = `${slides.length * slideWidth}px`;
        slides.forEach(slide => {
            slide.style.width = `${slideWidth}px`;
        });
    }

    function updateCarousel(index) {
        const slideWidth = slides[0].offsetWidth;
        track.style.transform = `translateX(-${index * slideWidth}px)`;
        dots.forEach(dot => dot.classList.remove('active'));
        dots[index].classList.add('active');
    }

    // Responsivo
    window.addEventListener('resize', () => {
        setSlideWidths();
        updateCarousel(currentIndex);
    });

    // Inicialização
    setSlideWidths();
    updateCarousel(currentIndex);

    slides.forEach(() => {
        track.addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % slides.length;
            updateCarousel(currentIndex);
        });
    });

    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            currentIndex = index;
            updateCarousel(currentIndex);
        });
    });

    setInterval(() => {
        currentIndex = (currentIndex + 1) % slides.length;
        updateCarousel(currentIndex);
    }, 7000);
});





//Script JavaScript para API de CEP



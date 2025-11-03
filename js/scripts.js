document.addEventListener('DOMContentLoaded', () => {
    const track = document.querySelector('.carousel-track');
    const slides = document.querySelectorAll('.carousel-img');
    const dots = document.querySelectorAll('.dot');
    let currentIndex = 0;

    function updateCarousel(index) {
        track.style.transform = `translateX(-${index * 100}%)`;
        dots.forEach(dot => dot.classList.remove('active'));
        dots[index].classList.add('active');
    }

    slides.forEach((slide, index) => {
        slide.addEventListener('click', () => {
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

    // Auto play opcional
    setInterval(() => {
        currentIndex = (currentIndex + 1) % slides.length;
        updateCarousel(currentIndex);
    }, 7000);
});


document.addEventListener('DOMContentLoaded', function () {
    const userProfileToggle = document.getElementById('userProfileToggle');
    const userDropdownMenu = document.getElementById('userDropdownMenu');

    if (userProfileToggle && userDropdownMenu) {
        userProfileToggle.addEventListener('click', function (event) {
            // Impede que o clique feche o dropdown imediatamente se for um link (deslogado)
            event.stopPropagation();
            userDropdownMenu.classList.toggle('show');
        });

        // Fecha o dropdown se clicar fora dele
        document.addEventListener('click', function (event) {
            if (!userProfileToggle.contains(event.target) && !userDropdownMenu.contains(event.target)) {
                userDropdownMenu.classList.remove('show');
            }
        });
    }
});
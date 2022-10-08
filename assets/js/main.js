document.addEventListener("DOMContentLoaded", () => {

    const slides = document.querySelectorAll('.slider__slide')
    let slideDescs = []
    slides.forEach(slide => {
        slideDescs.push(slide.dataset.desc)
    })
    const swiper = new Swiper('.swiper', {
        // Optional parameters
        slidesPerView: 1,
        loop: true,
        // If we need pagination
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
            renderBullet: function (i, className) {
                return '<div class="' + className + '"> <div></div> <p> <span> 0' + (i + 1) + '</span> ' + slideDescs[i] + '  </p> </div>'
            }
        },
    });

    const menuBtn = document.getElementById('menu_button')
    const menu = document.querySelector('.navbar-menu')

    menuBtn.addEventListener('click', (e) => {
        menuBtn.classList.toggle('active');
        if (menu.classList.contains('active')) {
            menu.classList.remove('active');
        } else {
            menu.classList.add('active');
        }
    })

});


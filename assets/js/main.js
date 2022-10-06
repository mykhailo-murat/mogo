document.addEventListener("DOMContentLoaded", () => {

    let slides = document.querySelectorAll('.slider__slide')
    let slideDescs = []
    slides.forEach(slide => {
        slideDescs.push(slide.dataset.desc)
    })
    const swiper = new Swiper('.swiper', {
        // Optional parameters

        // If we need pagination
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
            renderBullet: function (i, className) {
                return '<div class="' + className + '"> <div></div> <p> <span> 0' + (i + 1) + '</span> ' + slideDescs[i] + '  </p> </div>'
            }
        },
    });

 });
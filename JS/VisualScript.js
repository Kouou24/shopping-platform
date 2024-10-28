let slideIndex = 1;
        const slides = document.getElementById('banner-slide').children;
        const dots = document.getElementsByClassName('dot');

        // Initialize the first slide
        showSlide(slideIndex);

        document.getElementById('nextBtn').addEventListener('click', function() {
            changeSlide(1);
        });

        document.getElementById('prevBtn').addEventListener('click', function() {
            changeSlide(-1);
        });

        function changeSlide(n) {
            showSlide(slideIndex += n);
        }

        function currentSlide(n) {
            showSlide(slideIndex = n);
        }

        function showSlide(n) {
            if (n > slides.length) {
                slideIndex = 1;
            }
            if (n < 1) {
                slideIndex = slides.length;
            }
            for (let i = 0; i < slides.length; i++) {
                slides[i].style.display = 'none';
            }
            for (let i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(' active', '');
            }
            slides[slideIndex - 1].style.display = 'block';
            dots[slideIndex - 1].className += ' active';
        }
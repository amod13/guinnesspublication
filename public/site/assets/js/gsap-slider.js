  // 3rd hero section theme3
  gsap.registerPlugin(ScrollTrigger);
  // --- THEME 4: AUTO-SLIDING CAROUSEL LOGIC ---
  const theme4Slides = document.querySelectorAll('.amd-theme3-slide');
  const dotsContainer = document.querySelector('.amd-theme3-dots');
  let theme4CurrentSlide = 0;
  let theme4Interval;

  // Create dots
  theme4Slides.forEach((_, i) => {
    const dot = document.createElement('div');
    dot.classList.add('dot');
    if (i === 0) dot.classList.add('active');
    dot.dataset.slide = i;
    dotsContainer.appendChild(dot);
  });

  const theme4Dots = document.querySelectorAll('.amd-theme3-dots .dot');

  function showSlide(index) {
    theme4Slides.forEach((slide, i) => {
      slide.classList.remove('active');
      theme4Dots[i].classList.remove('active');
    });
    theme4Slides[index].classList.add('active');
    theme4Dots[index].classList.add('active');
    theme4CurrentSlide = index;
  }

  function nextSlide() {
    const newIndex = (theme4CurrentSlide + 1) % theme4Slides.length;
    showSlide(newIndex);
  }

  function startCarousel() {
    theme4Interval = setInterval(nextSlide, 5000); // Change slide every 5 seconds
  }

  function stopCarousel() {
    clearInterval(theme4Interval);
  }

  dotsContainer.addEventListener('click', (e) => {
    if (e.target.classList.contains('dot')) {
      stopCarousel();
      showSlide(parseInt(e.target.dataset.slide));
      startCarousel();
    }
  });

  startCarousel();
  // 3rd hero section theme3 end



 
    document.addEventListener('DOMContentLoaded', function () {
      const themeContainer = document.querySelector('.amd-theme2');
      if (!themeContainer) return;

      const slides = themeContainer.querySelectorAll('.slide');
      const nextBtn = themeContainer.querySelector('#nextBtn');
      const prevBtn = themeContainer.querySelector('#prevBtn');
      const dotsContainer = themeContainer.querySelector('.carousel-dots');
      const carouselContainer = themeContainer.querySelector('.carousel-container');

      let currentSlide = 0;
      let slideInterval; // For autoplay

      // Create dots
      slides.forEach((_, index) => {
        const dot = document.createElement('div');
        dot.classList.add('dot');
        if (index === 0) dot.classList.add('active');
        dot.addEventListener('click', () => {
          showSlide(index);
          resetAutoplay();
        });
        dotsContainer.appendChild(dot);
      });
      const dots = dotsContainer.querySelectorAll('.dot');

      function showSlide(index) {
        slides.forEach(slide => slide.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));

        currentSlide = (index + slides.length) % slides.length; // Loop around

        slides[currentSlide].classList.add('active');
        dots[currentSlide].classList.add('active');
      }

      // --- Autoplay Functionality ---
      function startAutoplay() {
        slideInterval = setInterval(() => {
          showSlide(currentSlide + 1);
        }, 5000); // Change slide every 5 seconds
      }

      function stopAutoplay() {
        clearInterval(slideInterval);
      }

      function resetAutoplay() {
        stopAutoplay();
        startAutoplay();
      }

      // Event Listeners
      nextBtn.addEventListener('click', () => {
        showSlide(currentSlide + 1);
        resetAutoplay();
      });

      prevBtn.addEventListener('click', () => {
        showSlide(currentSlide - 1);
        resetAutoplay();
      });

      // Pause autoplay on hover
      carouselContainer.addEventListener('mouseenter', stopAutoplay);
      carouselContainer.addEventListener('mouseleave', startAutoplay);

      // Initial setup
      showSlide(0);
      startAutoplay();
    });
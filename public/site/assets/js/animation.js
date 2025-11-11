(function($) {
  const fadeTypes = ['up', 'down', 'left', 'right', 'scale', 'rotate', 'fade'];

  // Check if element is in viewport (offset from bottom)
  function isInViewport($el, offset = 0.9) {
    const rect = $el[0].getBoundingClientRect();
    const windowHeight = window.innerHeight || $(window).height();
    return rect.top <= windowHeight * offset && rect.bottom >= 0;
  }

  // Initialize element style before animation based on fade type
  function initElement($el, fadeType) {
    $el.css('opacity', 0);
    switch (fadeType) {
      case 'up':    $el.css({ position: 'relative', top: '30px' }); break;
      case 'down':  $el.css({ position: 'relative', top: '-30px' }); break;
      case 'left':  $el.css({ position: 'relative', left: '30px' }); break;
      case 'right': $el.css({ position: 'relative', left: '-30px' }); break;
      case 'scale': $el.css({ 'transform-origin': 'center center', display: 'inline-block', transform: 'scale(0.5)' }); break;
      case 'rotate':$el.css({ 'transform-origin': 'center center', display: 'inline-block', transform: 'rotate(-90deg)' }); break;
      case 'fade':  /* only opacity, no transform */ break;
      default: /* no transform */ break;
    }
  }

  // Animate element to visible state based on fade type and duration
  function animateElement($el, fadeType, duration) {
    $el.stop(true);
    $el.animate({ opacity: 1 }, duration);

    switch (fadeType) {
      case 'up':
      case 'down':
        $el.animate({ top: 0 }, duration);
        break;
      case 'left':
      case 'right':
        $el.animate({ left: 0 }, duration);
        break;
      case 'scale':
        $({ scale: 0.5 }).animate({ scale: 1 }, {
          duration,
          step(now) {
            $el.css('transform', `scale(${now})`);
          }
        });
        break;
      case 'rotate':
        $({ deg: -90 }).animate({ deg: 0 }, {
          duration,
          step(now) {
            $el.css('transform', `rotate(${now}deg)`);
          }
        });
        break;
      case 'fade':
        // opacity already animated, no transform needed
        break;
      default:
        break;
    }
  }

  // The main function to apply fade on scroll based on data-fade attribute
  function processFadeOnScroll() {
    $('[data-fade]').each(function() {
      const $container = $(this);
      if ($container.hasClass('faded-on-scroll-done')) return; // already animated

      if (!isInViewport($container, 0.9)) return; // not visible yet

      const fadeType = $container.data('fade').toLowerCase();
      if (!fadeTypes.includes(fadeType)) return;

      const duration = $container.data('duration') || 300;
      const stagger = $container.data('stagger') || 100;

      // Animate children one by one with stagger
      const $children = $container.children();
      $children.each(function(i) {
        const $child = $(this);
        // Initialize hidden for smoothness
        initElement($child, fadeType);

        setTimeout(() => {
          animateElement($child, fadeType, duration);
        }, i * stagger);
      });

      // Mark container so we don't animate again
      $container.addClass('faded-on-scroll-done');
    });
  }

  // Initialize all fade elements on page load and scroll
  $(window).on('load scroll resize', processFadeOnScroll);

  // On page load initialize elements hidden (for all with data-fade)
  $(document).ready(function() {
    $('[data-fade]').each(function() {
      const fadeType = $(this).data('fade').toLowerCase();
      if (fadeTypes.includes(fadeType)) {
        $(this).children().each(function() {
          initElement($(this), fadeType);
        });
      }
    });
  });

})(jQuery);

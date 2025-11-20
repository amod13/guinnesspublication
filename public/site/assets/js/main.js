$(document).ready(function () {

  // -------------------------------
  // Navbar menus and hamburger
  // -------------------------------
  const hamburger = $('#amd-hamburger');
  const navMenu = $('#amd-nav-menu');
  const infoToggleBtn = $('#amd-info-toggle');
  const infoCanvas = $('#amd-info-canvas');
  const closeCanvasBtn = $('#amd-close-canvas');

  const closeMobileMenu = () => {
    hamburger.removeClass('amd-active');
    navMenu.removeClass('amd-open');
  };

  hamburger.on('click', function (e) {
    e.stopPropagation();
    hamburger.toggleClass('amd-active');
    navMenu.toggleClass('amd-open');
  });

  // Mobile dropdown toggle on small screens
  $('.amd-dropdown > a').on('click', function (e) {
    if ($(window).width() <= 992) {
      e.preventDefault();
      const submenu = $(this).next('.amd-dropdown-menu');
      const parentDropdown = $(this).parent();

      parentDropdown.siblings().find('.amd-dropdown-menu.amd-open').removeClass('amd-open')
        .prev('a').removeClass('amd-active');

      submenu.toggleClass('amd-open');
      $(this).toggleClass('amd-active');
    }
  });

  navMenu.on('click', function (e) {
    if (e.target.tagName === 'A' && !$(e.target).parent().hasClass('amd-dropdown')) {
      closeMobileMenu();
    }
  });

  infoToggleBtn.on('click', function (e) {
    e.stopPropagation();
    infoCanvas.addClass('amd-open');
  });

  closeCanvasBtn.on('click', function () {
    infoCanvas.removeClass('amd-open');
  });

  $(document).on('click', function (event) {
    if (navMenu.hasClass('amd-open') && !navMenu.is(event.target) && navMenu.has(event.target).length === 0) {
      closeMobileMenu();
    }
    if (infoCanvas.hasClass('amd-open') && !infoCanvas.is(event.target) && infoCanvas.has(event.target).length === 0 && !infoToggleBtn.is(event.target)) {
      infoCanvas.removeClass('amd-open');
    }
  });

  // -------------------------------
  // Search Toggle
  // -------------------------------
  const searchToggle = $('#amd-search-toggle');
  const searchBar = $('#amd-search-bar');
  const searchInput = $('#amd-search-input');
  const clearBtn = $('#amd-clear');

  searchToggle.on('click', function (e) {
    e.stopPropagation();
    searchBar.toggleClass('active');
    if (searchBar.hasClass('active')) {
      searchInput.focus();
    }
  });

  searchInput.on('input', function () {
    clearBtn.css('display', $(this).val() ? 'block' : 'none');
  });

  clearBtn.on('click', function (e) {
    e.stopPropagation();
    searchInput.val('');
    clearBtn.hide();
    searchInput.focus();
  });

  $(document).on('click', function (e) {
    if (!$(e.target).closest('#amd-search-bar').length && !$(e.target).closest('#amd-search-toggle').length) {
      searchBar.removeClass('active');
    }
  });

  // nav bar js end


  // -------------------------------
  //Load more btn loading animated js ************
  // -------------------------------
  const loadBtn = $("#loadMoreBtn");
  loadBtn.on("click", function () {

    loadBtn.addClass("loading");
    loadBtn.prop("disabled", true);

    setTimeout(() => {

      loadBtn.removeClass("loading");
      loadBtn.prop("disabled", false);

      console.log("Loaded more items...");

    }, 2000);

  });
  //Load more btn loading animated js end****************



  // -------------------------------
  //about section mission vissio goal  Toggle list items in cards (show first 3, then rest)
  // -------------------------------
  const cards = document.querySelectorAll('.amd-MGV-card');

  cards.forEach(card => {
    const listItems = card.querySelectorAll('ul.amd-MGV-card-list li');
    if (listItems.length <= 4) return; // agar 3 ya kam hain to toggle ki zarurat nahi

    let showingFirstThree = true;

    // Initially hide last items after 3
    for (let i = 4; i < listItems.length; i++) {
      listItems[i].classList.add('hide');
    }

    setInterval(() => {
      if (showingFirstThree) {
        // Hide first 3, show last items
        for (let i = 0; i < 4; i++) {
          listItems[i].classList.add('hide');
        }
        for (let i = 4; i < listItems.length; i++) {
          listItems[i].classList.remove('hide');
        }
      } else {
        // Show first 3, hide last items
        for (let i = 0; i < 4; i++) {
          listItems[i].classList.remove('hide');
        }
        for (let i = 4; i < listItems.length; i++) {
          listItems[i].classList.add('hide');
        }
      }
      showingFirstThree = !showingFirstThree;
    }, 4000);
  });



  // -------------------------------
  // book-section carousel scroll arrows
  // -------------------------------
  const carousel = document.querySelector('.amd-book-section-carousel');
  const prevBtn = document.querySelector('.amd-book-section-nav-prev');
  const nextBtn = document.querySelector('.amd-book-section-nav-next');

  if (carousel && prevBtn && nextBtn) {
    const items = carousel.querySelectorAll('.amd-book-section-item');

    // Check number of items and show/hide arrows accordingly
    if (items.length > 5) {
      // Show arrows
      prevBtn.style.display = 'block';
      nextBtn.style.display = 'block';

      const scrollAmount = carousel.clientWidth * 0.8; // Scroll 80% of visible width

      nextBtn.addEventListener('click', () => {
        carousel.scrollBy({
          left: scrollAmount,
          behavior: 'smooth'
        });
      });

      prevBtn.addEventListener('click', () => {
        carousel.scrollBy({
          left: -scrollAmount,
          behavior: 'smooth'
        });
      });
    } else {
      // Hide arrows if 5 or fewer items
      prevBtn.style.display = 'none';
      nextBtn.style.display = 'none';
    }
  }


  // book section js end

  // -------------------------------
  // Author profiles Swiper
  // -------------------------------
  document.querySelectorAll('.amd-book-authors-slider').forEach(container => {
    new Swiper(container, {
      slidesPerView: 4,
      spaceBetween: 20,
      loop: true,
      pagination: {
        el: container.querySelector('.swiper-pagination'),
        clickable: true,
      },
      navigation: {
        nextEl: container.querySelector('.swiper-button-next'),
        prevEl: container.querySelector('.swiper-button-prev'),
      },
      autoplay: {
        delay: 2500,
        disableOnInteraction: false,
      },
      breakpoints: {
        320: { slidesPerView: 2 },
        576: { slidesPerView: 3 },
        768: { slidesPerView: 4 },
        992: { slidesPerView: 5 },
      },
    });
  });



  // author section slide end



  // -------------------------------
  // blog section card slide js
  // -------------------------------
  const grid = $(".amd-book-blog-grid")[0]; // DOM element
  const prev = $(".amd-book-blog-nav-arrow[aria-label='Previous Post']")[0];
  const next = $(".amd-book-blog-nav-arrow[aria-label='Next Post']")[0];

  const scrollAmount = 320;

  if (prev && next && grid) {
    $(prev).on("click", function () {
      grid.scrollBy({ left: -scrollAmount, behavior: "smooth" });
    });

    $(next).on("click", function () {
      grid.scrollBy({ left: scrollAmount, behavior: "smooth" });
    });
  }


  // blog section cards slide end

  // -------------------------------
  // PDF view-all page interactions
  // -------------------------------
  const shareAction = document.getElementById("amd-pdf-share-action");
  const likeAction = document.getElementById("amd-pdf-like-action");
  const saveAction = document.getElementById("amd-pdf-save-action");
  const embedAction = document.getElementById("amd-pdf-embed-action");
  const fullscreenIcon = document.getElementById("amd-pdf-fullscreen-icon");
  const readerArea = document.getElementById("amd-pdf-reader-area");

  const modalOverlay = document.getElementById("amd-pdf-share-modal-overlay");
  const closeModalButton = document.getElementById("amd-pdf-close-modal-button");
  const copyLinkButton = document.getElementById("amd-pdf-copy-link-button");
  const copyConfirmation = document.getElementById("amd-pdf-copy-confirmation");

  let isSaved = false;
  let isLiked = false;
  let likeCount = 1200;

  const openModal = () => {
    const url = encodeURIComponent(window.location.href);
    const title = encodeURIComponent(document.title);
    document.getElementById(
      "amd-pdf-share-twitter"
    ).href = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
    document.getElementById(
      "amd-pdf-share-facebook"
    ).href = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
    document.getElementById(
      "amd-pdf-share-linkedin"
    ).href = `https://www.linkedin.com/sharing/share-offsite/?url=${url}`;
    modalOverlay.classList.add("visible");
  };

  const closeModal = () => {
    modalOverlay.classList.remove("visible");
    copyConfirmation.style.opacity = "0";
  };

  if (shareAction) {
    shareAction.addEventListener("click", (e) => {
      e.preventDefault();
      openModal();
    });
  }

  if (closeModalButton) {
    closeModalButton.addEventListener("click", closeModal);
  }

  if (modalOverlay) {
    modalOverlay.addEventListener("click", (e) => {
      if (e.target === modalOverlay) closeModal();
    });
  }

  if (copyLinkButton) {
    copyLinkButton.addEventListener("click", () => {
      navigator.clipboard
        .writeText(window.location.href)
        .then(() => {
          copyConfirmation.style.opacity = "1";
          setTimeout(() => (copyConfirmation.style.opacity = "0"), 2000);
        })
        .catch(() => alert("Failed to copy link"));
    });
  }

  if (saveAction) {
    const saveIcon = saveAction.querySelector("i");
    const saveText = document.getElementById("amd-pdf-save-text");
    saveAction.addEventListener("click", () => {
      isSaved = !isSaved;
      saveIcon.className = isSaved
        ? "fa-solid fa-bookmark"
        : "fa-regular fa-bookmark";
      saveText.textContent = isSaved ? "Saved" : "Save";
    });
  }

  if (likeAction) {
    const likeCountSpan = document.getElementById("amd-pdf-like-count");
    likeAction.addEventListener("click", () => {
      isLiked = !isLiked;
      likeCount += isLiked ? 1 : -1;
      likeAction.classList.toggle("liked", isLiked);
      likeCountSpan.textContent =
        likeCount >= 1000 ? (likeCount / 1000).toFixed(1) + "k" : likeCount;
    });
  }

  if (embedAction) {
    embedAction.addEventListener("click", () => {
      const embedCode = `<iframe src="${window.location.href}" width="600" height="800"></iframe>`;
      prompt("Copy this code to embed the book on your site:", embedCode);
    });
  }

  if (fullscreenIcon) {
    fullscreenIcon.addEventListener("click", () => {
      if (readerArea.requestFullscreen) readerArea.requestFullscreen();
      else if (readerArea.webkitRequestFullscreen) readerArea.webkitRequestFullscreen();
      else if (readerArea.msRequestFullscreen) readerArea.msRequestFullscreen();
    });
  }


  // -------------------------------
  // blog page js filter dropdown
  // -------------------------------
  const mobileFilterToggle = document.getElementById('amd-blog-page-mobile-filter-toggle');
  const categoryTagsList = document.getElementById('amd-blog-page-category-tags-list');

  if (mobileFilterToggle && categoryTagsList) {
    const mobileButtonText = mobileFilterToggle.querySelector('span');
    const categoryTags = categoryTagsList.querySelectorAll('.amd-blog-page-category-tag');

    mobileFilterToggle.addEventListener('click', function (event) {
      event.stopPropagation();
      categoryTagsList.classList.toggle('show');
      mobileFilterToggle.classList.toggle('open');
    });

    window.addEventListener('click', function () {
      if (categoryTagsList.classList.contains('show')) {
        categoryTagsList.classList.remove('show');
        mobileFilterToggle.classList.remove('open');
      }
    });

    categoryTags.forEach(tag => {
      tag.addEventListener('click', function (e) {
        e.preventDefault();

        if (mobileButtonText) {
          mobileButtonText.textContent = this.dataset.title;
        }

        categoryTags.forEach(t => t.classList.remove('active'));
        this.classList.add('active');

        // TODO: Add your article filtering logic here based on this.dataset.title

        if (categoryTagsList.classList.contains('show')) {
          categoryTagsList.classList.remove('show');
          mobileFilterToggle.classList.remove('open');
        }
      });
    });
  }

  // // blog page js filter dropdown end******************




  // -------------------------------
  // Book list page grid expend column
  // -------------------------------
  const gridManage = $("#amd-book-list-page-book-grid");
  const lessBtn = $("#amd-book-list-page-grid-less-btn");
  const expendBtn = $("#amd-book-list-page-grid-expend-btn");

  // Compact View (4 columns on XL)
  lessBtn.on("click", function () {
    if (!$(this).hasClass("active")) {
      gridManage.removeClass("row-cols-xl-3").addClass("row-cols-xl-4");
      $(this).addClass("active");
      expendBtn.removeClass("active");
    }
  });

  // Expanded View (3 columns on XL)
  expendBtn.on("click", function () {
    if (!$(this).hasClass("active")) {
      gridManage.removeClass("row-cols-xl-4").addClass("row-cols-xl-3");
      $(this).addClass("active");
      lessBtn.removeClass("active");
    }
  });
  // book list page grid expend column end********************




  // -------------------------------
  // search page js ********************************
  // -------------------------------
  // Updated IDs to match the new convention
  const bookSearchInput = document.getElementById('amdBookSearchPageInput');
  const bookSearchClear = document.getElementById('amdBookSearchPageClearBtn');

  // Function to toggle clear button visibility
  const toggleClearButton = () => {
    if (bookSearchInput.value.length > 0) {
      bookSearchClear.classList.remove('d-none');
    } else {
      bookSearchClear.classList.add('d-none');
    }
  };

  // Show/hide the clear button on input
  bookSearchInput.addEventListener('input', toggleClearButton);

  // Clear the input when the button is clicked
  bookSearchClear.addEventListener('click', function () {
    bookSearchInput.value = '';
    toggleClearButton(); // Hide the button
    bookSearchInput.focus(); // Re-focus the input for better UX
  });

  // Initial check in case the page loads with a value
  toggleClearButton();

  // search page js end ********************************





}); // document.ready end




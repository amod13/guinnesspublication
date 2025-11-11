
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

  // Mobile dropdown logic
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

  // Toggle search bar on button click
  searchToggle.on('click', function (e) {
    e.stopPropagation(); // prevent click from bubbling up
    searchBar.toggleClass('active');
    if (searchBar.hasClass('active')) {
      searchInput.focus();
    }
  });

  // Show/hide clear button on input
  searchInput.on('input', function () {
    clearBtn.css('display', $(this).val() ? 'block' : 'none');
  });

  // Clear input and refocus
  clearBtn.on('click', function (e) {
    e.stopPropagation();
    searchInput.val('');
    clearBtn.hide();
    searchInput.focus();
  });

  // Close on outside click
  $(document).on('click', function (e) {
    if (
      !$(e.target).closest('#amd-search-bar').length &&
      !$(e.target).closest('#amd-search-toggle').length
    ) {
      searchBar.removeClass('active');
    }
  });

  // -------------------------------
  // Visit Cursor Button hover effect
  // -------------------------------
  $(".amd-book-card,.amd-book-product-card").each(function () {
    const card = $(this);
    const visitCursor = card.find(".amd-visit-cursor");

    card.on("mousemove", function (e) {
      const rect = card[0].getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;
      visitCursor.css({ left: x + "px", top: y + "px" });
    });

    card.on("mouseenter", function () {
      visitCursor.css({ opacity: "1", transform: "translate(-50%, -50%) scale(1)" });
    });

    card.on("mouseleave", function () {
      visitCursor.css({ opacity: "0", transform: "translate(-50%, -50%) scale(0.8)" });
    });
  });

  // -------------------------------
  // Author profiles Swiper
  // -------------------------------
  const authorSwiper = new Swiper(".amd-book-authors-slider", {
    slidesPerView: 4,
    spaceBetween: 20,
    loop: true,
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
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

  // -------------------------------
  // Hero Swiper
  // -------------------------------
  const heroSwiper = new Swiper(".amd-hero-swiper", {
    loop: true,
    autoplay: { delay: 3000 },
    pagination: {
      el: ".amd-hero-thumbs",
      clickable: true,
      renderBullet: function (index, className) {
        const thumbs = [
          "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT60birGU4cES1AnyQMtFUsjvaVnPDXKSTeOA&s",
          "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTRVnfhQnzcOFP8NPwdgmIdC3snByuDTmtzzw&s",
          "https://i.ibb.co/3k8gTf4/author3.jpg",
        ];
        return '<img src="' + thumbs[index] + '" class="' + className + '"/>';
      },
    },
  });



  // pdf view-all page interactions ------------------------------- 
  // working with pdf view-all page action buttons and modals
  // -------------------------------

          const shareAction = document.getElementById("amd-pdf-share-action");
            const likeAction = document.getElementById("amd-pdf-like-action");
            const saveAction = document.getElementById("amd-pdf-save-action");
            const embedAction = document.getElementById("amd-pdf-embed-action");
            const fullscreenIcon = document.getElementById("amd-pdf-fullscreen-icon");
            const readerArea = document.getElementById("amd-pdf-reader-area");

            // Modal Elements
            const modalOverlay = document.getElementById("amd-pdf-share-modal-overlay");
            const closeModalButton = document.getElementById("amd-pdf-close-modal-button");
            const copyLinkButton = document.getElementById("amd-pdf-copy-link-button");
            const copyConfirmation = document.getElementById("amd-pdf-copy-confirmation");

            let isSaved = false;
            let isLiked = false;
            let likeCount = 1200;

            // --- Share Modal ---
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

            shareAction.addEventListener("click", (e) => {
                e.preventDefault();
                openModal();
            });

            closeModalButton.addEventListener("click", closeModal);
            modalOverlay.addEventListener("click", (e) => {
                if (e.target === modalOverlay) closeModal();
            });

            // Copy link
            copyLinkButton.addEventListener("click", () => {
                navigator.clipboard
                    .writeText(window.location.href)
                    .then(() => {
                        copyConfirmation.style.opacity = "1";
                        setTimeout(() => (copyConfirmation.style.opacity = "0"), 2000);
                    })
                    .catch(() => alert("Failed to copy link"));
            });

            // Save/Bookmark
            const saveIcon = saveAction.querySelector("i");
            const saveText = document.getElementById("amd-pdf-save-text");
            saveAction.addEventListener("click", () => {
                isSaved = !isSaved;
                saveIcon.className = isSaved
                    ? "fa-solid fa-bookmark"
                    : "fa-regular fa-bookmark";
                saveText.textContent = isSaved ? "Saved" : "Save";
            });

            // Like
            const likeCountSpan = document.getElementById("amd-pdf-like-count");
            likeAction.addEventListener("click", () => {
                isLiked = !isLiked;
                likeCount += isLiked ? 1 : -1;
                likeAction.classList.toggle("liked", isLiked);
                likeCountSpan.textContent =
                    likeCount >= 1000 ? (likeCount / 1000).toFixed(1) + "k" : likeCount;
            });

            // Embed
            embedAction.addEventListener("click", () => {
                const embedCode = `<iframe src="${window.location.href}" width="600" height="800"></iframe>`;
                prompt("Copy this code to embed the book on your site:", embedCode);
            });

            // Fullscreen
            fullscreenIcon.addEventListener("click", () => {
                if (readerArea.requestFullscreen) readerArea.requestFullscreen();
                else if (readerArea.webkitRequestFullscreen) readerArea.webkitRequestFullscreen();
                else if (readerArea.msRequestFullscreen) readerArea.msRequestFullscreen();
            });

            // End of pdf view-all page interactions -------------------------------
            // -------------------------------
  
}); // document.ready end


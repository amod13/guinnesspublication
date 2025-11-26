// Button JS here
$(document).ready(function () {
    $(".amd-action-btn").each(function () {
        var $button = $(this);
        var defaultIconClass = $button.data("default-icon");
        var defaultText = $button.data("default-text");
        var loadingIconClass = $button.data("loading-icon");
        var loadingText = $button.data("loading-text");
        var successIconClass = $button.data("success-icon");
        var successText = $button.data("success-text");
        var errorIconClass = $button.data("error-icon");
        var errorText = $button.data("error-text");

        $button.on("click", function () {
            if ($button.hasClass("is-loading") || $button.prop("disabled")) {
                return;
            }

            var originalContent = $button.html();

            $button
                .addClass("is-loading")
                .html(`<i class="${loadingIconClass}"></i> ${loadingText}`)
                .prop("disabled", true);

            var simulateSuccess = Math.random() > 0.3; // 70% success rate
            var randomDelay = Math.random() * 1500 + 1000;

            setTimeout(function () {
                $button.removeClass("is-loading");
                if (simulateSuccess) {
                    $button
                        .addClass("is-success")
                        .html(
                            `<i class="${successIconClass}"></i> ${successText}`
                        );
                    setTimeout(function () {
                        $button
                            .removeClass("is-success")
                            .html(originalContent)
                            .prop("disabled", false);
                    }, 1500);
                } else {
                    $button
                        .addClass("is-error")
                        .html(`<i class="${errorIconClass}"></i> ${errorText}`);
                    setTimeout(function () {
                        $button
                            .removeClass("is-error")
                            .html(originalContent)
                            .prop("disabled", false);
                    }, 2000);
                }
            }, randomDelay);
        });
    });

    $(".amd-btn-animated-svg").on("click", function () {
        console.log("Animated SVG Icon Button clicked!");
    });
});

// Accordions JS page
$(document).ready(function () {
    $(".amd-accordion").each(function () {
        var $accordion = $(this);
        var isAlwaysOpen = $accordion.hasClass("amd-accordion-always-open");
        var $headers = $accordion.find(".amd-accordion-header");

        $headers.on("click", function () {
            var $header = $(this);
            var $item = $header.closest(".amd-accordion-item");
            var $body = $item.find(".amd-accordion-body");
            var $content = $item.find(".amd-accordion-content");
            var $icon = $header.find(".amd-accordion-icon");
            var isActive = $item.hasClass("active");

            if (!isAlwaysOpen) {
                // Close all other active items first
                $accordion
                    .find(".amd-accordion-item.active")
                    .not($item)
                    .each(function () {
                        var $otherItem = $(this);
                        $otherItem.removeClass("active");
                        var $otherBody = $otherItem.find(".amd-accordion-body");
                        var $otherContent = $otherItem.find(
                            ".amd-accordion-content"
                        );
                        var $otherIcon = $otherItem.find(
                            ".amd-accordion-header .amd-accordion-icon"
                        );
                        $otherBody.css("max-height", "0px");
                        if ($otherContent.length) {
                            $otherContent.css("opacity", 0);
                        }
                        $otherIcon.removeClass("rotated");
                    });
            }

            if (isActive) {
                // Close current item
                $item.removeClass("active");
                $content.css({ opacity: 0, transform: "scale(0.98)" });
                $body.css("max-height", "0px");
                $icon.removeClass("rotated");
            } else {
                // Open current item
                $item.addClass("active");
                $body.css("max-height", $body[0].scrollHeight + "px");
                setTimeout(function () {
                    $content.css({ opacity: 1, transform: "scale(1)" });
                }, 50);
                $icon.addClass("rotated");
            }
        });

        // Set initial open state for items with .active
        $accordion.find(".amd-accordion-item.active").each(function () {
            var $item = $(this);
            var $body = $item.find(".amd-accordion-body");
            var $content = $item.find(".amd-accordion-content");
            var $icon = $item.find(".amd-accordion-header .amd-accordion-icon");
            $body.css("max-height", $body[0].scrollHeight + "px");
            $content.css({ opacity: 1, transform: "scale(1)" });
            $icon.addClass("rotated");
        });
    });
});

// Alerts page js here
$(document).ready(function () {
    $(".amd-close-btn").on("click", function () {
        var $alert = $(this).closest(".amd-alert");
        if ($alert.length) {
            if (
                $alert.hasClass("amd-fade") ||
                $alert.hasClass("amd-alert-slide-in") ||
                $alert.hasClass("amd-alert-border-bounce") ||
                $alert.hasClass("amd-alert-glow") ||
                $alert.hasClass("amd-alert-solid-shadow") ||
                $alert.hasClass("amd-alert-pulse-icon")
            ) {
                $alert.css({
                    opacity: "0",
                    transform: "translateY(10px) scale(0.98)",
                    height: "0",
                    paddingTop: "0",
                    paddingBottom: "0",
                    marginTop: "0",
                    marginBottom: "0",
                    borderWidth: "0",
                    boxShadow: "none",
                });
                $alert.one("transitionend", function () {
                    $alert.remove();
                });
            } else {
                $alert.remove();
            }
        }
    });

    // Trigger slide-in animation for modern alerts on load
    $(".amd-alert.amd-alert-slide-in").each(function () {
        var $alert = $(this);
        void $alert[0].offsetWidth; // force reflow
        $alert.css({ opacity: "1", transform: "translateY(0)" });
    });
});

// Card page js
$(document).ready(function () {
    $(".amd-cards.amd-cards-slide-in").each(function () {
        var $cards = $(this);
        void $cards[0].offsetWidth; // force reflow
        $cards.css({ opacity: "1", transform: "translateY(0)" });
    });

    $(".amd-cards-animated-pop").each(function () {
        var $card = $(this);
        $card.on("mouseenter", function () {
            $card.addClass("amd-cards-pop-active");
        });
        $card.on("mouseleave", function () {
            $card.removeClass("amd-cards-pop-active");
        });
    });
});

// Modals page js
function openModal(id) {
    var $modal = $("#" + id);
    if ($modal.length) {
        $modal.addClass("amd-modal-show");
        $("body").addClass("amd-modal-open");
    }
}

function closeModal(id) {
    var $modal = $("#" + id);
    if ($modal.length) {
        $modal.removeClass("amd-modal-show");
        var openModals = $(".amd-modal-backdrop.amd-modal-show");
        if (openModals.length === 0) {
            $("body").removeClass("amd-modal-open");
        }
    }
}

$(document).ready(function () {
    $(".amd-modal-backdrop").on("click", function (event) {
        if (event.target === this) {
            closeModal(this.id);
        }
    });

    $(document).on("keydown", function (event) {
        if (event.key === "Escape") {
            var openModals = $(".amd-modal-backdrop.amd-modal-show");
            if (openModals.length > 0) {
                closeModal(openModals.last().attr("id"));
            }
        }
    });

    $(".amd-modal-side").on("click", function (event) {
        event.stopPropagation();
    });

    $(".modal-demo-static .amd-modal-close, .modal-demo-static .amd-btn").on(
        "click",
        function (event) {
            event.preventDefault();
            console.log(
                "Button clicked in static modal example (no actual action)."
            );
        }
    );
});

// Carousel page js

/**
 * Global function to show a toast notification (jQuery version).
 * @param {object} options - Configuration for the toast.
 */
function showToast(options) {
    // Default options and merge with provided options
    const defaultOptions = {
        type: "info",
        message: "A notification message.",
        title: null,
        duration: 5000,
        position: "top-right",
        avatarSrc: null,
        avatarAlt: "User",
        showProgressBar: false,
        actions: [],
        onShowCallback: null,
        onHideCallback: null,
    };
    const opts = $.extend({}, defaultOptions, options);

    // Get or create the toast container for the specified position
    let $toastContainer = $(`#amdToastContainer-${opts.position}`);
    if ($toastContainer.length === 0) {
        $toastContainer = $("<div></div>")
            .attr("id", `amdToastContainer-${opts.position}`)
            .addClass("amd-toast-container")
            .addClass(`amd-toast-container-${opts.position}`)
            .appendTo("body");
    }

    const $toast = $("<div></div>")
        .addClass("amd-toast")
        .addClass(`amd-toast-${opts.type}`);

    // Determine icon or avatar
    let iconHtml = "";
    let avatarHtml = "";

    if (opts.avatarSrc) {
        avatarHtml = `<img class="amd-avatar" src="${opts.avatarSrc}" alt="${opts.avatarAlt}">`;
        $toast.addClass("amd-toast-avatar");
    } else {
        let iconClass = "";
        switch (opts.type) {
            case "success":
                iconClass = "fas fa-check-circle";
                break;
            case "error":
                iconClass = "fas fa-times-circle";
                break;
            case "info":
                iconClass = "fas fa-info-circle";
                break;
            case "warning":
                iconClass = "fas fa-exclamation-triangle";
                break;
            default:
                iconClass = "fas fa-bell";
                break;
        }
        iconHtml = `<i class="amd-icon ${iconClass}"></i>`;
    }

    // Build content HTML
    let contentHtml = "";
    if (opts.title) {
        contentHtml += `<div class="amd-toast-title">${opts.title}</div>`;
    }
    contentHtml += `<div class="amd-toast-message">${opts.message}</div>`;

    // Build actions HTML
    let actionsHtml = "";
    if (opts.actions && opts.actions.length > 0) {
        actionsHtml = `<div class="amd-toast-actions">`;
        opts.actions.forEach((action, index) => {
            actionsHtml += `<button type="button" class="amd-btn-toast-action" data-action-index="${index}">${action.text}</button>`;
        });
        actionsHtml += `</div>`;
    }

    const progressBarHtml =
        opts.showProgressBar && opts.duration > 0
            ? '<div class="amd-toast-progress-bar"></div>'
            : "";

    $toast.html(`
        ${avatarHtml || iconHtml}
        <div class="amd-toast-content">
            ${contentHtml}
            ${actionsHtml}
        </div>
        <button type="button" class="amd-toast-close" aria-label="Close">
            <i class="fas fa-times"></i>
        </button>
        ${progressBarHtml}
    `);

    // Prepend toast to container (newest on top)
    $toastContainer.prepend($toast);

    // Show animation trigger
    setTimeout(() => {
        $toast.addClass("show");
        if (typeof opts.onShowCallback === "function") {
            opts.onShowCallback();
        }

        // Start progress bar animation
        if (opts.showProgressBar && opts.duration > 0) {
            const $progressBar = $toast.find(".amd-toast-progress-bar");
            if ($progressBar.length) {
                $progressBar.css({
                    transition: `width ${opts.duration / 1000}s linear`,
                    width: "0%",
                });
                void $progressBar[0].offsetWidth; // force reflow
                $progressBar.css("width", "100%");
            }
        }
    }, 10);

    let hideTimeout;

    function hideToast() {
        $toast.removeClass("show").addClass("hide");
        // Remove after animation ends (~300ms assumed)
        setTimeout(() => {
            $toast.remove();
            if (typeof opts.onHideCallback === "function") {
                opts.onHideCallback();
            }
        }, 300);
    }

    // Auto-hide logic
    if (opts.duration > 0) {
        hideTimeout = setTimeout(hideToast, opts.duration);
    }

    // Close button click
    $toast.find(".amd-toast-close").on("click", function () {
        if (hideTimeout) {
            clearTimeout(hideTimeout);
        }
        hideToast();
    });

    // Action buttons click
    $toast.find(".amd-btn-toast-action").each(function () {
        const $btn = $(this);
        $btn.on("click", function () {
            const index = parseInt($btn.data("action-index"), 10);
            if (
                opts.actions &&
                opts.actions[index] &&
                typeof opts.actions[index].onClick === "function"
            ) {
                opts.actions[index].onClick();
            }
            if (hideTimeout) {
                clearTimeout(hideTimeout);
            }
            hideToast();
        });
    });

    // Pause auto-hide on hover
    $toast.on("mouseenter", function () {
        if (hideTimeout) {
            clearTimeout(hideTimeout);
        }
        const $progressBar = $toast.find(".amd-toast-progress-bar");
        if ($progressBar.length) {
            $progressBar.css("transition", "none");
            const computedWidth = window.getComputedStyle(
                $progressBar[0]
            ).width;
            $progressBar.css("width", computedWidth);
        }
    });

    // Resume auto-hide on mouse leave
    $toast.on("mouseleave", function () {
        if (opts.duration > 0 && !$toast.hasClass("hide")) {
            const $progressBar = $toast.find(".amd-toast-progress-bar");
            let remainingDuration = opts.duration;

            if (
                $progressBar.length &&
                $progressBar.css("width") !== "0px" &&
                $progressBar.css("width") !== "100%"
            ) {
                const totalWidth = $toast.outerWidth();
                const currentWidth = parseFloat($progressBar.css("width"));
                if (totalWidth > 0) {
                    const progressPercentage = currentWidth / totalWidth;
                    remainingDuration =
                        opts.duration * (1 - progressPercentage);
                }
            }

            hideTimeout = setTimeout(hideToast, remainingDuration);

            if ($progressBar.length) {
                $progressBar.css({
                    transition: `width ${remainingDuration / 1000}s linear`,
                    width: "0%",
                });
                void $progressBar[0].offsetWidth;
                $progressBar.css("width", "100%");
            }
        }
    });
}
/**
 * Hides a specific toast notification and removes it from the DOM after its transition.
 *
 * @param {jQuery|HTMLElement} toastElement - The toast element (jQuery object or DOM element).
 * @param {string} position - The position of the toast container for exit animation.
 * @param {function} [onHideCallback=null] - Optional callback when toast finishes hiding.
 */
function hideToast(toastElement, position, onHideCallback = null) {
    const $toast =
        toastElement instanceof jQuery ? toastElement : $(toastElement);

    $toast.removeClass("show");

    // Apply specific hide animation based on position
    if (position === "top-left" || position === "bottom-left") {
        $toast.css("transform", "translateX(-100%) scale(0.95)");
    } else if (position === "top-center" || position === "bottom-center") {
        $toast.css("transform", "translateY(-100%) scale(0.95)");
    } else {
        // default top-right or bottom-right
        $toast.css("transform", "translateX(100%) scale(0.95)");
    }
    $toast.css("opacity", "0");

    // Wait for transitionend event once, then remove element and call callback
    $toast.one("transitionend", function () {
        const $parent = $toast.parent();
        $toast.remove();

        if (typeof onHideCallback === "function") {
            onHideCallback();
        }

        // Remove container if empty
        if ($parent.children().length === 0) {
            $parent.remove();
        }
    });
}

$(document).ready(function () {
    // Basic Toast Buttons (Using jQuery selectors)
    $("#showSuccessToastBtn").on("click", () => {
        showToast({
            type: "success",
            message: "Your data has been saved successfully!",
        });
    });

    $("#showErrorToastBtn").on("click", () => {
        showToast({
            type: "error",
            message: "Failed to process your request. Please try again.",
        });
    });

    $("#showInfoToastBtn").on("click", () => {
        showToast({
            type: "info",
            message: "You have 3 new messages in your inbox.",
        });
    });

    $("#showWarningToastBtn").on("click", () => {
        showToast({
            type: "warning",
            message: "Low disk space detected. Please clear some files.",
        });
    });

    // Custom Duration Toast Buttons
    $("#showShortToastBtn").on("click", () => {
        showToast({
            type: "info",
            message: "This toast will disappear in 2 seconds.",
            duration: 2000,
        });
    });

    $("#showLongerToastBtn").on("click", () => {
        showToast({
            type: "success",
            message:
                "You have successfully signed up for the newsletter! This will stay for 7 seconds.",
            duration: 7000,
        });
    });

    $("#showPersistentToastBtn").on("click", () => {
        showToast({
            type: "error",
            message:
                "An unrecoverable error occurred. Please refresh the page.",
            duration: 0,
        });
    });

    // Advanced Toast Actions Buttons
    $("#showCallbacksToastBtn").on("click", () => {
        showToast({
            type: "info",
            title: "Download Progress",
            message: "File download started!",
            duration: 3000,
            onShowCallback: () => console.log("Toast shown: File download"),
            onHideCallback: () =>
                console.log("Toast hidden: File download complete"),
        });
    });

    $("#showHtmlLinkToastBtn").on("click", () => {
        showToast({
            type: "success",
            message: `Item added to cart. <a href='#' onclick='alert("Navigating to cart!"); return false;' style='color: var(--amd-white-color); text-decoration: underline;'>View Cart</a>`,
            duration: 5000,
        });
    });

    // New Toast Styles
    $("#showToastWithTitleBtn").on("click", () => {
        showToast({
            type: "info",
            title: "New Notification",
            message: "You have received a new message from Support.",
            duration: 4000,
        });
    });

    $("#showToastWithAvatarBtn").on("click", () => {
        showToast({
            type: "info",
            title: "John Doe",
            message: "Just shared a new document with you.",
            avatarSrc: "https://via.placeholder.com/40/007bff/FFFFFF?text=JD",
            duration: 5000,
        });
    });

    $("#showToastWithActionBtn").on("click", () => {
        showToast({
            type: "warning",
            title: "New Update Available",
            message: "A new version of the application is ready to install.",
            duration: 8000,
            actions: [
                {
                    text: "Later",
                    onClick: () => console.log("Update postponed."),
                },
                {
                    text: "Update Now",
                    onClick: () => alert("Starting update..."),
                },
            ],
        });
    });

    $("#showToastWithProgressBarBtn").on("click", () => {
        showToast({
            type: "success",
            title: "File Uploading",
            message: "Your document is being uploaded to the cloud.",
            duration: 6000,
            showProgressBar: true,
        });
    });

    $("#showUserActionConfirmationBtn").on("click", () => {
        showToast({
            type: "success",
            message: 'Item "Product X" successfully added to your wishlist!',
            duration: 3000,
        });
    });

    $("#showNetworkErrorBtn").on("click", () => {
        showToast({
            type: "error",
            title: "Connection Lost",
            message:
                "Could not connect to the server. Please check your internet.",
            duration: 0,
        });
    });

    $("#showReminderNotificationBtn").on("click", () => {
        showToast({
            type: "info",
            title: "Meeting Reminder",
            message: "Your daily stand-up starts in 5 minutes.",
            duration: 6000,
        });
    });

    $("#showTopLeftToastBtn").on("click", () => {
        showToast({
            type: "warning",
            message: "Maintenance mode starting soon. Please save your work.",
            duration: 5000,
            position: "top-left",
        });
    });

    $("#showBottomRightToastBtn").on("click", () => {
        showToast({
            type: "success",
            message: "Feedback submitted successfully! Thank you.",
            duration: 4000,
            position: "bottom-right",
        });
    });

    $("#showBottomCenterToastBtn").on("click", () => {
        showToast({
            type: "info",
            title: "Application Update",
            message:
                'A new version is available. Click "Update" below to get the latest features.',
            duration: 0,
            position: "bottom-center",
            actions: [
                {
                    text: "Dismiss",
                    onClick: () => console.log("User dismissed update toast"),
                },
                {
                    text: "Update",
                    onClick: () => alert("Initiating update..."),
                },
            ],
        });
    });

    // Canvas ripple effect
    const $amdRippleCanvas = $(".amd-canvas-subtle-ripple");
    if ($amdRippleCanvas.length) {
        $amdRippleCanvas.on("mousemove", function (e) {
            const offset = $(this).offset();
            const x = e.pageX - offset.left;
            const y = e.pageY - offset.top;

            const $ripple = $("<div></div>")
                .addClass("amd-ripple")
                .css({ left: `${x}px`, top: `${y}px` })
                .appendTo(this);

            $ripple.on(
                "animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd",
                function () {
                    $(this).remove();
                }
            );
        });
    }
});

// off canvas page js
$(document).ready(function () {
    const $offCanvasToggles = $("[data-amd-off-canvas-target]");
    const $offCanvasDismissButtons = $("[data-amd-off-canvas-dismiss]");
    const $offCanvasNavLinkDismiss = $("[data-amd-off-canvas-link-dismiss]");
    const $offCanvasBackdrop = $("#amdOffCanvasBackdrop");
    const $body = $("body");
    const $mainContentWrapper = $("#amd-main-content-wrapper");

    let currentOpenOffCanvas = null; // Track the currently open off-canvas panel

    function openOffCanvas(targetId, $triggerElement) {
        const $targetPanel = $(targetId);
        if ($targetPanel.length) {
            if (
                currentOpenOffCanvas &&
                currentOpenOffCanvas[0] !== $targetPanel[0]
            ) {
                closeOffCanvas("#" + currentOpenOffCanvas.attr("id"));
            }

            $targetPanel.addClass("amd-off-canvas-open");
            $offCanvasBackdrop.addClass("amd-off-canvas-backdrop-show");
            $body.addClass("amd-off-canvas-open");

            const isPushOffCanvas =
                $triggerElement.data("amdOffCanvasPush") === true ||
                $triggerElement.data("amdOffCanvasPush") === "true";
            if (isPushOffCanvas && $mainContentWrapper.length) {
                if ($targetPanel.hasClass("amd-off-canvas-left")) {
                    $mainContentWrapper.addClass(
                        "amd-main-content-pushed-left"
                    );
                }
                // Additional push directions can be handled here if needed
                $body.addClass("amd-body-pushed");
            }
            currentOpenOffCanvas = $targetPanel;
        }
    }

    function closeOffCanvas(targetId) {
        const $targetPanel = $(targetId);
        if ($targetPanel.length) {
            $targetPanel.removeClass("amd-off-canvas-open");

            if ($mainContentWrapper.length) {
                $mainContentWrapper.removeClass("amd-main-content-pushed-left");
                $body.removeClass("amd-body-pushed");
            }

            if ($(".amd-off-canvas.amd-off-canvas-open").length === 0) {
                $offCanvasBackdrop.removeClass("amd-off-canvas-backdrop-show");
                $body.removeClass("amd-off-canvas-open");
            }

            if (
                currentOpenOffCanvas &&
                currentOpenOffCanvas[0] === $targetPanel[0]
            ) {
                currentOpenOffCanvas = null;
            }
        }
    }

    $offCanvasToggles.on("click", function () {
        const targetId = $(this).data("amdOffCanvasTarget");
        openOffCanvas(targetId, $(this));
    });

    $offCanvasDismissButtons.on("click", function () {
        const targetId = $(this).data("amdOffCanvasDismiss");
        closeOffCanvas(targetId);
    });

    $offCanvasNavLinkDismiss.on("click", function (e) {
        // e.preventDefault(); // Uncomment if needed to prevent navigation
        const targetId = $(this).data("amdOffCanvasLinkDismiss");
        closeOffCanvas(targetId);
    });

    if ($offCanvasBackdrop.length) {
        $offCanvasBackdrop.on("click", function () {
            if (currentOpenOffCanvas) {
                closeOffCanvas("#" + currentOpenOffCanvas.attr("id"));
            }
        });
    }

    $(document).on("keydown", function (event) {
        if (event.key === "Escape" && currentOpenOffCanvas) {
            closeOffCanvas("#" + currentOpenOffCanvas.attr("id"));
        }
    });

    // Nested submenu toggles
    $(".amd-off-canvas-nav .has-submenu > .submenu-toggle").on(
        "click",
        function (e) {
            e.preventDefault();
            const $parentLi = $(this).closest("li.has-submenu");
            if ($parentLi.length) {
                const $currentOffCanvas = $(this).closest(".amd-off-canvas");
                if ($currentOffCanvas.length) {
                    $currentOffCanvas
                        .find(".has-submenu.submenu-open")
                        .not($parentLi)
                        .removeClass("submenu-open");
                }
                $parentLi.toggleClass("submenu-open");
            }
        }
    );
});

// pagination page js
$(document).ready(function () {
    const $pageDropdownToggle = $("#pageDropdownToggle");
    if ($pageDropdownToggle.length) {
        $pageDropdownToggle.on("click", function () {
            $(this).parent().toggleClass("open");
        });

        $(document).on("click", function (event) {
            if (
                !$pageDropdownToggle.parent().is(event.target) &&
                $pageDropdownToggle.parent().has(event.target).length === 0
            ) {
                $pageDropdownToggle.parent().removeClass("open");
            }
        });
    }

    const $viewMoreBtn = $("#viewMoreBtn");
    const $viewMoreContent = $("#viewMoreContent");
    const $viewMoreSpinner = $viewMoreBtn.find(".amd-loading-spinner");
    const $viewMoreText = $viewMoreBtn.find(".amd-btn-text");

    let currentItems = 10;
    const totalItems = 50;
    const itemsPerPage = 10;

    if ($viewMoreBtn.length) {
        $viewMoreBtn.on("click", function () {
            $viewMoreSpinner.show();
            $viewMoreText.hide();
            $viewMoreBtn.prop("disabled", true).addClass("loading");

            setTimeout(() => {
                currentItems += itemsPerPage;
                if (currentItems > totalItems) currentItems = totalItems;

                $viewMoreContent.html(
                    `Displaying 1-${currentItems} of ${totalItems} items.`
                );
                if (currentItems === totalItems) {
                    $viewMoreBtn.hide();
                } else {
                    const nextStart = currentItems + 1;
                    const nextEnd = Math.min(
                        currentItems + itemsPerPage,
                        totalItems
                    );
                    $viewMoreText.text(`View More (${nextStart}-${nextEnd})`);
                }

                $viewMoreSpinner.hide();
                $viewMoreText.show();
                $viewMoreBtn.prop("disabled", false).removeClass("loading");
            }, 1500);
        });
    }

    const $rippleLoadMoreBtn = $("#rippleLoadMoreBtn");
    const $rippleContent = $("#rippleContent");
    const $rippleSpinner = $rippleLoadMoreBtn.find(".amd-loading-spinner");
    const $rippleText = $rippleLoadMoreBtn.find(".amd-btn-text");

    if ($rippleLoadMoreBtn.length) {
        $rippleLoadMoreBtn.on("click", function (e) {
            const x = e.clientX - $(this).offset().left;
            const y = e.clientY - $(this).offset().top;

            const $ripple = $("<span></span>")
                .addClass("amd-ripple-effect")
                .css({
                    left: `${x}px`,
                    top: `${y}px`,
                });

            $(this).append($ripple);

            $ripple.on(
                "animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd",
                function () {
                    $(this).remove();
                }
            );

            $rippleSpinner.show();
            $rippleText.hide();
            $rippleLoadMoreBtn.prop("disabled", true).addClass("loading");

            setTimeout(() => {
                $rippleContent.append(
                    `<p style="margin-top:10px;">More awesome content loaded with a ripple! (${new Date().toLocaleTimeString()})</p>`
                );
                $rippleSpinner.hide();
                $rippleText.show();
                $rippleLoadMoreBtn
                    .prop("disabled", false)
                    .removeClass("loading")
                    .hide(); // Hide after one load
            }, 1800);
        });
    }
});

// badges page js
$(document).ready(function () {
    const $badgeSearch = $("#badgeSearch");
    const $badgeCategoriesContainer = $("#badgeCategories");

    $badgeSearch.on("keyup", function () {
        const searchTerm = $badgeSearch.val().toLowerCase();
        const $badgeExamples = $(".badge-example");
        const $categoryHeadings = $("#badgeCategories h2");

        $badgeExamples.each(function () {
            const $example = $(this);
            const badgeText = $example.text().toLowerCase();
            const badgeCode = $example.find("code").text().toLowerCase() || "";
            const display =
                badgeText.includes(searchTerm) || badgeCode.includes(searchTerm)
                    ? "flex"
                    : "none";
            $example.css("display", display);
        });

        $categoryHeadings.each(function () {
            const $heading = $(this);
            const $categoryGrid = $heading.next(".badge-grid");
            const $descriptionParagraph = $categoryGrid.next("p");

            if ($categoryGrid.length) {
                const visibleBadges =
                    $categoryGrid.children().filter(function () {
                        return $(this).css("display") !== "none";
                    }).length > 0;

                $heading.css("display", visibleBadges ? "block" : "none");
                $categoryGrid.css("display", visibleBadges ? "grid" : "none");

                if (
                    $descriptionParagraph.length &&
                    $descriptionParagraph.css("margin-top") === "-15px"
                ) {
                    $descriptionParagraph.css(
                        "display",
                        visibleBadges ? "block" : "none"
                    );
                }
            }
        });
    });
});

// date picker page js

$(document).ready(function () {
    $("#date1").flatpickr({ dateFormat: "Y-m-d" });
    $("#date2").flatpickr({ dateFormat: "Y-m-d" });
    $("#date3").flatpickr({ mode: "range", dateFormat: "Y-m-d" });
    $("#date4").flatpickr({ enableTime: true, dateFormat: "Y-m-d H:i" });
    $("#date5").flatpickr({ inline: true, dateFormat: "Y-m-d" });
    $("#date6").flatpickr({ dateFormat: "Y-m-d" });

    // Button triggered date picker
    const date7Instance = flatpickr("#date7btn", {
        dateFormat: "Y-m-d",
        clickOpens: false,
        onReady: function (_, __, instance) {
            $("#date7btn").on("click", function () {
                instance.open();
            });
        },
    });

    $("#date8").flatpickr({ dateFormat: "Y-m-d" });
    $("#date9").flatpickr({ dateFormat: "Y-m-d" });
    $("#date10").flatpickr({ dateFormat: "Y-m-d", minDate: "today" });
});
//   date picker page js end

// new date picker page js
// 4. Advanced Bootstrap Datepicker Plugin
$(function () {
    $("#amd-datepicker4").datepicker({
        format: "mm/dd/yyyy",
        todayHighlight: true,
        autoclose: true,
    });
});

// progress bar page js

// JavaScript to set the progress bar widths with a slight delay for animation effect
document.addEventListener("DOMContentLoaded", function () {
    const progressBars = document.querySelectorAll(".amd-progress-bar");
    progressBars.forEach((bar, index) => {
        const targetWidth = bar.dataset.width; // Get target width from data-width attribute
        // Introduce a small delay for each bar to make the animation more noticeable
        setTimeout(() => {
            if (targetWidth) {
                bar.style.width = targetWidth + "%";
            }
        }, 100 * index); // Adjust delay as needed
    });
});
// progress bar page js end

// dialog page js
// Optional: Pause video when modal is hidden
document.addEventListener("DOMContentLoaded", function () {
    var videoModal = document.getElementById("videoModal");
    if (videoModal) {
        videoModal.addEventListener("hidden.bs.modal", function () {
            var iframe = this.querySelector("iframe");
            if (iframe) {
                // Reset src to stop playback
                var iframeSrc = iframe.src;
                iframe.src = iframeSrc;
            }
        });
    }
});

//   dialog page js end

// Button Group page js
$(document).ready(function () {
    // Toggle active state for Segmented Control
    var $segmentedControl = $(".amd-button-group-custom-segmented");
    if ($segmentedControl.length) {
        $segmentedControl.on("click", "button", function () {
            $segmentedControl.find(".btn").removeClass("active");
            $(this).addClass("active");
        });
    }

    // Toggle active state for Icon-Only Toggle Group
    var $iconToggleGroup = $(".amd-button-group-custom-icon-toggle");
    if ($iconToggleGroup.length) {
        $iconToggleGroup.on("click", "button", function () {
            $(this).toggleClass("active");
        });
    }
});

// button group page js end

// form-select page js
$(document).ready(function () {
    // Function to handle adding and removing basic tags (for existing multi-selects)
    function setupTagInput(containerId) {
        const $container = $(`#${containerId}`);
        if (!$container.length) return;

        const $tagInput = $container.find(".amd-form-select-tag-input");

        // Remove tag on 'X' click using event delegation
        $container.on("click", ".amd-form-select-remove-tag", function (event) {
            $(this).closest(".amd-form-select-selected-tag").remove();
        });

        // Add tag on Enter key press for basic multi-selects
        $tagInput.on("keydown", function (event) {
            if (event.key === "Enter" && $(this).val().trim() !== "") {
                event.preventDefault(); // Prevent form submission
                const tagText = $(this).val().trim();
                const $newTag = $("<span>")
                    .addClass("amd-form-select-selected-tag")
                    .attr(
                        "data-value",
                        tagText.toLowerCase().replace(/\s/g, "-")
                    )
                    .html(
                        `${tagText} <span class="amd-form-select-remove-tag">X</span>`
                    );

                if (containerId === "amdPassingOptionsMultiSelect") {
                    $newTag.addClass("amd-form-select-tag-blue");
                }
                $tagInput.before($newTag); // Insert before the input field
                $(this).val(""); // Clear input field
            }
        });
    }

    // Function to handle searchable multi-selects (with tags)
    function setupSearchableMultiSelect(containerId) {
        const $container = $(`#${containerId}`);
        if (!$container.length) return;

        const $multiInputDiv = $container.find(".amd-form-select-multi-input");
        const $tagInput = $multiInputDiv.find(".amd-form-select-tag-input");
        const $dropdownList = $container.find(".amd-form-select-dropdown-list");
        const $options = $dropdownList.children("li"); // Get all li elements

        let selectedValues = new Set(); // To keep track of selected items (data-value)

        // Function to render selected tags
        function renderTags() {
            // Remove existing tags, but keep the input field
            $multiInputDiv.find(".amd-form-select-selected-tag").remove();

            selectedValues.forEach((value) => {
                const $newTag = $("<span>")
                    .addClass("amd-form-select-selected-tag")
                    .attr("data-value", value);

                // Find the original text for the tag display
                const originalOptionText = $options
                    .filter(`[data-value="${value}"]`)
                    .text();
                $newTag.html(
                    `${originalOptionText} <span class="amd-form-select-remove-tag">X</span>`
                );
                $tagInput.before($newTag); // Insert before the input field
            });
        }

        // Handle clicking on an option in the dropdown list
        $dropdownList.on("click", "li", function (event) {
            const $target = $(this);
            const value = $target.attr("data-value");

            if (selectedValues.has(value)) {
                selectedValues.delete(value);
                $target.removeClass("selected");
            } else {
                selectedValues.add(value);
                $target.addClass("selected");
            }
            renderTags(); // Re-render tags to reflect changes
            $tagInput.val(""); // Clear search input
            filterOptions(""); // Reset filter after selection
            $tagInput.focus(); // Keep focus on input for continued interaction
        });

        // Handle removing a tag from the input area
        $multiInputDiv.on(
            "click",
            ".amd-form-select-remove-tag",
            function (event) {
                const $tag = $(this).closest(".amd-form-select-selected-tag");
                const valueToRemove = $tag.attr("data-value");
                selectedValues.delete(valueToRemove);
                $tag.remove();

                // Also update the dropdown list item's selected state
                $dropdownList
                    .find(`li[data-value="${valueToRemove}"]`)
                    .removeClass("selected");
                $tagInput.focus(); // Keep focus on input
            }
        );

        // Filter options based on input
        $tagInput.on("input", function () {
            const searchTerm = $(this).val().toLowerCase();
            filterOptions(searchTerm);
        });

        function filterOptions(searchTerm) {
            $options.each(function () {
                const $option = $(this);
                const optionText = $option.text().toLowerCase();
                if (optionText.includes(searchTerm)) {
                    $option.removeClass("hidden");
                } else {
                    $option.addClass("hidden");
                }
            });
        }

        // Show/hide dropdown on input focus/blur
        $tagInput.on("focus", function () {
            $dropdownList.addClass("show");
            filterOptions($(this).val().toLowerCase()); // Filter on focus too
        });

        // Hide dropdown when clicking outside
        $(document).on("click", function (event) {
            if (
                !$container.is(event.target) &&
                !$container.has(event.target).length
            ) {
                $dropdownList.removeClass("show");
                $tagInput.val(""); // Clear search input on blur
                filterOptions(""); // Reset filter
            }
        });

        // Prevent hiding dropdown when clicking inside the multi-input area but not on tags
        $multiInputDiv.on("click", function (event) {
            if (
                $(event.target).is($multiInputDiv) ||
                $(event.target).is($tagInput)
            ) {
                $tagInput.focus();
                $dropdownList.addClass("show");
            }
        });

        // Initialize selected state for options if they were pre-selected
        $options.each(function () {
            if ($(this).hasClass("selected")) {
                selectedValues.add($(this).attr("data-value"));
            }
        });
        renderTags();
    }

    // Function to handle the new Multi-Select with Checkboxes
    function setupCheckboxMultiSelect(containerId) {
        const $container = $(`#${containerId}`);
        if (!$container.length) return;

        const $displayBox = $container.find(".amd-form-select-display");
        const $dropdown = $container.find(".amd-form-select-checkbox-dropdown");
        const $checkboxes = $dropdown.find('input[type="checkbox"]');
        const $placeholderSpan = $displayBox.find(
            ".amd-form-select-placeholder"
        );

        let selectedItems = new Set(); // Stores values of selected checkboxes

        function updateDisplay() {
            if (selectedItems.size === 0) {
                $placeholderSpan
                    .text("Select items...")
                    .addClass("amd-form-select-placeholder");
            } else {
                $placeholderSpan.removeClass("amd-form-select-placeholder");
                const selectedLabels = Array.from(selectedItems).map(
                    (value) => {
                        // Find the label text corresponding to the value
                        const $checkbox = $dropdown.find(
                            `input[value="${value}"]`
                        );
                        return $checkbox.length
                            ? $checkbox.next("label").text()
                            : value;
                    }
                );
                $placeholderSpan.text(selectedLabels.join(", "));
            }
        }

        // Toggle dropdown visibility
        $displayBox.on("click", function () {
            $dropdown.toggleClass("show");
            $displayBox.toggleClass("focused", $dropdown.hasClass("show"));
            $displayBox.attr("aria-expanded", $dropdown.hasClass("show"));
        });

        // Handle checkbox changes using event delegation
        $dropdown.on("change", 'input[type="checkbox"]', function (event) {
            const value = $(this).val();
            if ($(this).is(":checked")) {
                selectedItems.add(value);
            } else {
                selectedItems.delete(value);
            }
            updateDisplay();
        });

        // Close dropdown when clicking outside
        $(document).on("click", function (event) {
            if (
                !$container.is(event.target) &&
                !$container.has(event.target).length
            ) {
                $dropdown.removeClass("show");
                $displayBox.removeClass("focused");
                $displayBox.attr("aria-expanded", "false");
            }
        });

        // Initial display update
        $checkboxes.each(function () {
            if ($(this).is(":checked")) {
                selectedItems.add($(this).val());
            }
        });
        updateDisplay();
    }

    // Apply basic tag interaction to relevant multi-select inputs
    setupTagInput("amdDefaultMultiSelect");
    setupTagInput("amdRemoveBtnMultiSelect");
    setupTagInput("amdPassingOptionsMultiSelect");
    setupTagInput("amdUniqueValuesMultiSelect");

    // Apply searchable multi-select interaction to the new components
    setupSearchableMultiSelect("searchableMultiSelect1");
    setupSearchableMultiSelect("searchableMultiSelect2");
    setupSearchableMultiSelect("searchableMultiSelect3");

    // Apply checkbox multi-select interaction
    setupCheckboxMultiSelect("checkboxMultiSelect");

    // Show Code Button (Dummy functionality)
    $(".amd-form-select-show-code-btn").on("click", function () {
        alert(
            "This would open a modal/section with the code for this component!"
        );
    });
});

// telephone dropdowns js
$(document).ready(function () {
    // Get all dropdown toggle buttons within amd-telephone components
    const amdTelephones = $(".amd-telephone");

    amdTelephones.each(function () {
        const $amdTelephone = $(this); // Cache the current .amd-telephone element as a jQuery object
        const $toggleButton = $amdTelephone.find(".dropdown-toggle-flag");
        const $dropdownMenu = $amdTelephone.find(".dropdown-menu-flag"); // Not used directly in this logic, but kept for consistency
        const $dropdownItems = $amdTelephone.find(".dropdown-item-flag");

        if ($toggleButton.length) {
            // Ensure the toggle button exists for this component
            $toggleButton.on("click", function (event) {
                event.preventDefault();
                const $parentDropdown = $(this).closest(
                    ".dropdown-flag-country"
                );
                if ($parentDropdown.length && !$(this).is(":disabled")) {
                    // Check if not disabled
                    $parentDropdown.toggleClass("show");
                }

                // Close other open dropdowns
                $(".dropdown-flag-country.show").each(function () {
                    if ($(this)[0] !== $parentDropdown[0]) {
                        // Compare native DOM elements
                        $(this).removeClass("show");
                    }
                });
            });
        }

        $dropdownItems.on("click", function (event) {
            event.preventDefault();
            const selectedCountry = $(this).data("country"); // Use .data() for data attributes
            const selectedCode = $(this).data("code");

            const $selectedFlagImg = $amdTelephone.find(
                'img.flag-icon[id^="selectedFlag"]'
            );
            const $selectedCodeSpan = $amdTelephone.find(
                'span[id^="selectedCode"]'
            );

            if ($selectedFlagImg.length) {
                $selectedFlagImg.attr(
                    "src",
                    `https://flagcdn.com/w20/${selectedCountry}.png`
                );
            }
            if ($selectedCodeSpan.length) {
                $selectedCodeSpan.text(selectedCode);
            }

            const $parentDropdown = $(this).closest(".dropdown-flag-country");
            if ($parentDropdown.length) {
                $parentDropdown.removeClass("show"); // Close the dropdown
            }
        });
    });

    // Close dropdowns when clicking outside
    $(document).on("click", function (event) {
        $(".amd-telephone .dropdown-flag-country.show").each(function () {
            if (!$(event.target).closest(this).length) {
                // Check if click is outside the dropdown
                $(this).removeClass("show");
            }
        });
    });
});

// form-select page end

// FAQ page start

$(document).ready(function () {
    // --- 1. "ChefKraft" - Custom List Group Accordion ---
    $(".amd-faq-style-tabs .list-group-item").on("click", function () {
        var $question = $(this).find(".list-group-item-question");
        var $answer = $(this).find(".list-group-item-answer");
        var $icon = $question.find("i");

        if ($question.hasClass("active")) {
            // If it's already active, close it
            $question.removeClass("active");
            $answer.slideUp(300).addClass("d-none");
            $icon.removeClass("bi-dash-lg").addClass("bi-plus-lg");
        } else {
            // Close any other open items in the same list
            $(this)
                .siblings()
                .find(".list-group-item-question.active")
                .each(function () {
                    $(this).removeClass("active");
                    $(this)
                        .siblings(".list-group-item-answer")
                        .slideUp(300)
                        .addClass("d-none");
                    $(this)
                        .find("i")
                        .removeClass("bi-dash-lg")
                        .addClass("bi-plus-lg");
                });
            // Open the clicked item
            $question.addClass("active");
            $answer.slideDown(300).removeClass("d-none");
            $icon.removeClass("bi-plus-lg").addClass("bi-dash-lg");
        }
    });

    // --- 4. "Marketplace" - Filtering Logic ---
    $("#marketplaceTab .nav-link").on("click", function () {
        // Update active state
        $("#marketplaceTab .nav-link").removeClass("active");
        $(this).addClass("active");

        var filter = $(this).data("filter");
        var $accordionItems = $("#marketplaceAccordion .accordion-item");

        if (filter === "*") {
            $accordionItems.show(400);
        } else {
            $accordionItems.not('[data-category="' + filter + '"]').hide(400);
            $accordionItems
                .filter('[data-category="' + filter + '"]')
                .show(400);
        }
    });
});

$(document).ready(function () {
    // FAQ Question Toggle Logic
    $(".amd-faq5 .faq-question").on("click", function () {
        $(this).toggleClass("expanded");
        // Use slideToggle for animation, setting a duration for smoothness
        $(this).next(".faq-answer-text").slideToggle(200);

        const $icon = $(this).find(".toggle-icon");
        if ($(this).hasClass("expanded")) {
            $icon.removeClass("fa-plus").addClass("fa-minus");
        } else {
            $icon.removeClass("fa-minus").addClass("fa-plus");
        }
    });

    // Category Card Active State (visual only)
    $(".amd-faq5 .faq-category-card").on("click", function () {
        $(".amd-faq5 .faq-category-card").removeClass("active");
        $(this).addClass("active");
    });

    // Load More FAQ Items Logic
    const $faqItemList = $("#faqItemList");
    const $loadMoreBtn = $("#loadMoreBtn");
    const itemsPerLoad = 3; // Number of items to show each time "Load More" is clicked

    // Initial setup function
    function initializeFaqItems() {
        // Ensure the one specific answer from the image remains visible and expanded
        const $specificItem = $(".amd-faq5 .faq-item-list li:nth-child(3)");
        if ($specificItem.length) {
            $specificItem.find(".faq-question").addClass("expanded");
            // Ensure the answer is displayed and override any inline 'display: none'
            $specificItem
                .find(".faq-answer-text")
                .addClass("show")
                .css("display", "block");
            $specificItem
                .find(".toggle-icon")
                .removeClass("fa-plus")
                .addClass("fa-minus");
        }

        // Initially hide all items that are meant to be hidden
        // This targets items that might not have 'display: none' inline due to Bootstrap or other reasons
        $faqItemList.find("li.hidden").hide(); // CRITICAL FIX: Ensure hidden items are actually hidden with jQuery's .hide()

        // Check if "Load More" button is needed on initial load
        if ($faqItemList.find("li.hidden").length === 0) {
            $loadMoreBtn.hide(); // Hide if all are visible already
        }
    }

    // Function to show more items
    function showMoreItems() {
        // Re-select hidden items each time
        const $currentHiddenItems = $faqItemList.find("li.hidden");
        const $itemsToShow = $currentHiddenItems.slice(0, itemsPerLoad);

        // Instead of just removing 'hidden', use .show() to ensure they become visible
        // and potentially remove any inline 'display: none' that might be lingering.
        $itemsToShow.removeClass("hidden").show(); // CRITICAL FIX: Use .show() here

        // After revealing, check the count of remaining hidden items
        if ($faqItemList.find("li.hidden").length === 0) {
            $loadMoreBtn.hide(); // Hide button if no more hidden items
        }
    }

    // Call initial setup on document ready
    initializeFaqItems();

    // Attach click handler to Load More button
    $loadMoreBtn.on("click", showMoreItems);
});

// FAQ page end

// subscription plan page start

$(document).ready(function () {
    // --- General Pricing Toggle Logic ---
    function handlePricingToggle(toggleId, scopeClass) {
        $(toggleId).on("change", function () {
            var isAnnual = $(this).is(":checked");
            $(scopeClass + " .plan-price").each(function () {
                var monthlyPrice = $(this).data("monthly");
                var annuallyPrice = $(this).data("annually");
                var periodText = isAnnual ? "/year" : "/month";

                if (isAnnual) {
                    $(this).html(
                        annuallyPrice +
                            ' <span class="period">' +
                            periodText +
                            "</span>"
                    );
                } else {
                    $(this).html(
                        monthlyPrice +
                            ' <span class="period">' +
                            periodText +
                            "</span>"
                    );
                }
            });
        });
    }

    // --- "Modern Pill" Toggle Logic ---
    var $pillBox = $(".pricing-toggle-pill-box");
    if ($pillBox.length > 0) {
        var $movingPill = $pillBox.find(".moving-pill");
        var $monthlyBtn = $pillBox.find('button[data-period="monthly"]');
        var $yearlyBtn = $pillBox.find('button[data-period="yearly"]');

        // Set initial size of the moving pill
        $movingPill.width($monthlyBtn.outerWidth());
        $movingPill.height($monthlyBtn.outerHeight());

        $pillBox.on("click", "button", function () {
            var $this = $(this);
            if ($this.hasClass("active")) {
                return; // Do nothing if already active
            }

            $pillBox.find("button").removeClass("active");
            $this.addClass("active");

            // Animate the moving pill
            $movingPill.width($this.outerWidth());
            $movingPill.css("left", $this.position().left + 5); // +5 for the container padding

            // Update prices for the "Modern Pill" section
            var isAnnual = $this.data("period") === "yearly";
            $(".amd-plan-style-modern-pill .plan-price").each(function () {
                var monthlyPrice = $(this).data("monthly");
                var annuallyPrice = $(this).data("annually");
                var periodText = isAnnual ? "/year" : "/month";

                if (isAnnual) {
                    $(this).html(
                        annuallyPrice +
                            ' <span class="period">' +
                            periodText +
                            "</span>"
                    );
                } else {
                    $(this).html(
                        monthlyPrice +
                            ' <span class="period">' +
                            periodText +
                            "</span>"
                    );
                }
            });
        });
    }

    // --- Initialize Toggles ---
    handlePricingToggle("#saas-pricing-toggle", ".amd-plan-style-saas");
    handlePricingToggle(
        "#accordion-pricing-toggle",
        ".amd-plan-style-accordion"
    );
});
// subscription plan end

// --- 2. CONFIRMATION ALERTS ---
function showConfirmAlert() {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "var(--color-danger)",
        cancelButtonColor: "#8898aa",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            showSuccessAlert(
                "Deleted!",
                "The item has been successfully deleted."
            );
        }
    });
}
function showConfirmDenyAlert() {
    Swal.fire({
        title: "Do you want to save the changes?",
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: "Save",
        denyButtonText: `Don't save`,
    }).then((result) => {
        if (result.isConfirmed)
            showSuccessAlert("Saved!", "Your changes have been saved.");
        else if (result.isDenied)
            Swal.fire("Changes are not saved", "", "info");
    });
}

// --- 3. TOAST NOTIFICATIONS ---
const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
    },
});
function showToast(icon, title) {
    Toast.fire({
        icon: icon || "success",
        title: title || "Action completed.",
    });
}

// --- 4. ADVANCED & CUSTOM ALERTS ---
function showAjaxLoader() {
    Swal.fire({
        title: "Processing Request...",
        text: "Please wait.",
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        },
    });
    setTimeout(() => {
        Swal.fire({
            icon: "success",
            title: "Success!",
            text: "Your request was processed successfully.",
        });
    }, 2000);
}
function showImageAlert() {
    Swal.fire({
        title: "Welcome!",
        text: "It is great to have you here.",
        imageUrl:
            "https://images.unsplash.com/photo-1576158113928-4424e07c3b1e?ixlib=rb-4.0.3&q=85&fm=jpg&crop=entropy&cs=srgb&w=800",
        imageWidth: 400,
        imageHeight: 200,
        imageAlt: "Welcome image",
    });
}
function showBgImageAlert() {
    Swal.fire({
        title: "A Room with a View",
        width: 600,
        padding: "3em",
        color: "#fff",
        background:
            "#fff url(https://images.unsplash.com/photo-1440778303588-435521a205bc?ixlib=rb-4.0.3&q=85&fm=jpg&crop=entropy&cs=srgb&w=1200)",
        backdrop: `rgba(0,0,0,0.4) url("https://sweetalert2.github.io/images/nyan-cat.gif") left top no-repeat`,
    });
}
function showHtmlAlert() {
    Swal.fire({
        title: "<strong>What's New in <u>v2.0</u></strong>",
        icon: "info",
        html: `<ul><li>New sleek design</li><li>Enhanced animations</li><li>Performance improvements</li></ul>`,
        showCloseButton: true,
        focusConfirm: false,
        confirmButtonText: '<i class="fa fa-thumbs-up"></i> Great!',
    });
}
function showCustomCloseAlert() {
    Swal.fire({
        title: "Modal with a Custom Close Button",
        html: 'You can add any HTML inside. <br/><div style="position:absolute;top:1rem;right:1rem;font-size:1.5rem;cursor:pointer;color:#ccc" onclick="Swal.close()">×</div>',
        showConfirmButton: false,
    });
}
function showFooterTimerAlert() {
    Swal.fire({
        icon: "success",
        title: "Offer Unlocked!",
        text: "You have a 20% discount on your next purchase.",
        timer: 4000,
        timerProgressBar: true,
        footer: "This offer expires soon!",
    });
}

// --- 5. INPUT ALERTS ---
function showEmailInput() {
    Swal.fire({
        title: "Join Our Newsletter",
        input: "email",
        inputLabel: "Email address",
        inputPlaceholder: "Enter your email address",
        showCancelButton: true,
        confirmButtonText: "Subscribe",
    }).then((result) => {
        if (result.isConfirmed && result.value)
            showToast("success", `Subscribed: ${result.value}`);
    });
}
function showChainedModals() {
    Swal.queue([
        { title: "Step 1", text: "What is your name?", input: "text" },
        { title: "Step 2", text: "Where are you from?", input: "text" },
        { title: "Step 3", text: "What is your hobby?", input: "text" },
    ]).then((result) => {
        if (result.value) {
            const answers = JSON.stringify(result.value);
            Swal.fire({
                title: "Complete!",
                html: `Your answers: <pre><code>${answers}</code></pre>`,
                confirmButtonText: "Lovely!",
            });
        }
    });
}
function showSelectInput() {
    Swal.fire({
        title: "Select your country",
        input: "select",
        inputOptions: {
            US: "United States",
            DE: "Germany",
            FR: "France",
            JP: "Japan",
        },
        inputPlaceholder: "Select a country",
        showCancelButton: true,
    }).then((result) => {
        if (result.value) showToast("info", "You selected: " + result.value);
    });
}
function showCheckboxInput() {
    Swal.fire({
        title: "Terms and Conditions",
        input: "checkbox",
        inputValue: 0,
        inputPlaceholder: "I agree with the terms and conditions",
        confirmButtonText: 'Continue <i class="fa fa-arrow-right"></i>',
        inputValidator: (result) => !result && "You must agree with the T&C!",
    });
}
function showPasswordInput() {
    Swal.fire({
        title: "Enter your password",
        input: "password",
        inputLabel: "Password",
        inputPlaceholder: "Enter your password",
    }).then((result) => {
        if (result.value)
            Swal.fire({ title: "Password Entered", icon: "success" });
    });
}
function showAsyncValidation() {
    Swal.fire({
        title: "Create a username",
        input: "text",
        inputLabel: "Username",
        showCancelButton: true,
        inputValidator: (value) =>
            new Promise((resolve) => {
                if (value === "taken") {
                    setTimeout(
                        () => resolve("Username is already taken."),
                        500
                    );
                } else {
                    resolve();
                }
            }),
    }).then((result) => {
        if (result.isConfirmed && result.value)
            showSuccessAlert(
                "Success!",
                `Username "${result.value}" is available.`
            );
    });
}

// sweet alert page end

// table 1 js
$(document).ready(function () {
    // GLOBAL VARIABLES
    let sortColumn = "";
    let sortDirection = "asc";
    let allRows = $("#tableBody tr");
    let selectedRows = new Set();
    let draggedElement = null;

    // ========== TABLE 1 (Search, Sort, Filter, Actions) ==========

    // Search functionality
    $("#searchInput").on("input", function () {
        const query = $(this).val().toLowerCase();
        searchTable(query);
    });

    // Sort headers click
    $(".sortable").on("click", function () {
        const column = $(this).data("sort");
        handleSort(column, $(this));
    });

    // Filter button toggle
    $("#filterBtn").on("click", toggleFilterPanel);

    // Clear and apply filter buttons
    $("#clearFilters").on("click", clearAllFilters);
    $("#applyFilters").on("click", applyFilters);

    // New Vehicle button (example)
    $("#newVehicleBtn").on("click", function () {
        alert("New Vehicle Form - This would open a modal or form");
    });

    // Close filter panel & action menus on outside click
    $(document).on("click", function (e) {
        const $filterPanel = $("#filterPanel");
        const $filterBtn = $("#filterBtn");

        if (
            !$filterPanel.is(e.target) &&
            $filterPanel.has(e.target).length === 0 &&
            !$filterBtn.is(e.target) &&
            $filterBtn.has(e.target).length === 0
        ) {
            $filterPanel.removeClass("show");
            $filterBtn.removeClass("active");
        }

        if (!$(e.target).closest(".amd-soft-table1-actions").length) {
            $(".amd-soft-table1-action-menu").removeClass("show");
        }
    });

    // Toggle filter panel
    function toggleFilterPanel() {
        $("#filterPanel").toggleClass("show");
        $("#filterBtn").toggleClass("active");
    }

    // Clear all filters
    function clearAllFilters() {
        $("#groupFilter, #typeFilter, #statusFilter").val("");
        allRows.removeClass("hidden");
    }

    // Apply filters (example, implement as needed)
    function applyFilters() {
        alert("Apply filters functionality here");
    }

    // Sort handler
    function handleSort(column, $header) {
        if (sortColumn === column) {
            sortDirection = sortDirection === "asc" ? "desc" : "asc";
        } else {
            sortColumn = column;
            sortDirection = "asc";
        }

        $(".sortable").removeClass("sort-asc sort-desc");
        $header.addClass(`sort-${sortDirection}`);

        sortTable(column, sortDirection);
    }

    // Sort table rows
    function sortTable(column, direction) {
        const $tbody = $("#tableBody");
        const rows = $tbody.find("tr").get();

        rows.sort(function (a, b) {
            let aVal = $(a).data(column);
            let bVal = $(b).data(column);

            if (column === "vehicle") {
                aVal = parseInt((aVal.match(/\d+/) || ["0"])[0]);
                bVal = parseInt((bVal.match(/\d+/) || ["0"])[0]);
            } else {
                aVal = ("" + aVal).toLowerCase();
                bVal = ("" + bVal).toLowerCase();
            }

            if (direction === "asc") {
                return aVal > bVal ? 1 : -1;
            } else {
                return aVal < bVal ? 1 : -1;
            }
        });

        $tbody.empty().append(rows);
        allRows = $("#tableBody tr");
    }

    // ========== TABLE 3 (Column Toggle, Sorting, Row Selection) ==========

    $(document).on(
        "change",
        ".amd-soft-table3-column-toggle-checkbox",
        function () {
            const columnKey = $(this).val();
            const isVisible = $(this).is(":checked");
            $(
                `th[data-column-key="${columnKey}"], td[data-column-key="${columnKey}"]`
            ).toggleClass("amd-soft-table3-hidden-column", !isVisible);
        }
    );

    $(document).on("click", ".amd-soft-table3-table-head", function () {
        const $header = $(this);
        const columnKey = $header.data("column-key");
        const rows = $("#amd-soft-table3-data-rows tr").get();

        let currentDirection = $header.hasClass("amd-soft-table3-sorted-asc")
            ? "asc"
            : $header.hasClass("amd-soft-table3-sorted-desc")
            ? "desc"
            : "none";
        const newDirection = currentDirection === "asc" ? "desc" : "asc";

        $(".amd-soft-table3-table-head").removeClass(
            "amd-soft-table3-sorted-asc amd-soft-table3-sorted-desc"
        );
        $header.addClass(`amd-soft-table3-sorted-${newDirection}`);

        rows.sort((a, b) => {
            const A = $(a)
                .find(`td[data-column-key="${columnKey}"]`)
                .text()
                .trim();
            const B = $(b)
                .find(`td[data-column-key="${columnKey}"]`)
                .text()
                .trim();
            return newDirection === "asc"
                ? A.localeCompare(B)
                : B.localeCompare(A);
        });

        $("#amd-soft-table3-data-rows").append(rows);
    });

    $(document).on("change", ".amd-soft-table3-checkbox", function () {
        $(this)
            .closest("tr")
            .toggleClass("amd-soft-table3-selected", $(this).is(":checked"));
    });

    $("#amd-soft-table3-column-toggles").on("click", function (e) {
        e.stopPropagation();
    });

    // ========== TABLE 6 (Pagination, Sorting, Searching, Filter & Info Update) ==========

    let currentPage = 1;
    let itemsPerPage = 7;
    sortColumn = "";
    sortDirection = "asc";
    allRows = $("#tableBody tr");

    function updatePagination() {
        const visibleRows = $("#tableBody tr:not(.hidden)");
        const totalItems = visibleRows.length;
        const totalPages = Math.ceil(totalItems / itemsPerPage);

        visibleRows.each(function (index) {
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            if (index >= startIndex && index < endIndex) $(this).show();
            else $(this).hide();
        });

        $("#prevBtn").prop("disabled", currentPage === 1);
        $("#nextBtn").prop(
            "disabled",
            currentPage === totalPages || totalPages === 0
        );
        $(".amd-table6-page-btn[data-page]").removeClass("active");
        $(`.amd-table6-page-btn[data-page="${currentPage}"]`).addClass(
            "active"
        );
    }

    function updateInfo() {
        const visibleRows = $("#tableBody tr:not(.hidden):visible");
        const totalVisible = $("#tableBody tr:not(.hidden)").length;
        const startIndex =
            visibleRows.length > 0 ? (currentPage - 1) * itemsPerPage + 1 : 0;
        const endIndex = Math.min(currentPage * itemsPerPage, totalVisible);

        $("#showingStart").text(startIndex);
        $("#showingEnd").text(endIndex);
        $("#totalItems").text(totalVisible);
    }

    function sortTable6(column, direction) {
        const $tbody = $("#tableBody");
        const rows = $tbody.find("tr").toArray();

        rows.sort(function (a, b) {
            let aVal, bVal;

            switch (column) {
                case "product":
                    aVal = $(a).data("product").toLowerCase();
                    bVal = $(b).data("product").toLowerCase();
                    break;
                case "price":
                    aVal = parseFloat($(a).data("price"));
                    bVal = parseFloat($(b).data("price"));
                    break;
                case "shop":
                    aVal = $(a).data("shop").toLowerCase();
                    bVal = $(b).data("shop").toLowerCase();
                    break;
                case "visibility":
                    aVal = parseInt($(a).data("visibility"));
                    bVal = parseInt($(b).data("visibility"));
                    break;
                case "revenue":
                    aVal = parseInt($(a).data("revenue"));
                    bVal = parseInt($(b).data("revenue"));
                    break;
                default:
                    return 0;
            }

            return direction === "asc"
                ? aVal > bVal
                    ? 1
                    : -1
                : aVal < bVal
                ? 1
                : -1;
        });

        $tbody.empty().append(rows);
        currentPage = 1;
        updatePagination();
        updateInfo();
    }

    function searchTable(query) {
        if (!query) {
            allRows.removeClass("hidden");
        } else {
            allRows.each(function () {
                const product = $(this).data("product").toLowerCase();
                const shop = $(this).data("shop").toLowerCase();
                $(this).toggleClass(
                    "hidden",
                    !(product.includes(query) || shop.includes(query))
                );
            });
        }
        currentPage = 1;
        updatePagination();
        updateInfo();
    }

    // Event listeners for table 6
    $(".amd-table6-tab").on("click", function () {
        $(".amd-table6-tab").removeClass("active");
        $(this).addClass("active");
    });

    $(".sortable").on("click", function () {
        const column = $(this).data("sort");

        if (sortColumn === column) {
            sortDirection = sortDirection === "asc" ? "desc" : "asc";
        } else {
            sortColumn = column;
            sortDirection = "asc";
        }

        $(".sortable").removeClass("sort-asc sort-desc");
        $(this).addClass(`sort-${sortDirection}`);

        sortTable6(sortColumn, sortDirection);
    });

    $(document).on("click", ".amd-table6-page-btn[data-page]", function () {
        currentPage = parseInt($(this).data("page"));
        updatePagination();
        updateInfo();
    });

    $("#prevBtn").on("click", function () {
        if (currentPage > 1) {
            currentPage--;
            updatePagination();
            updateInfo();
        }
    });

    $("#nextBtn").on("click", function () {
        const visibleRows = $("#tableBody tr:not(.hidden)");
        const totalPages = Math.ceil(visibleRows.length / itemsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            updatePagination();
            updateInfo();
        }
    });

    $("#perPageSelect").on("change", function () {
        itemsPerPage = parseInt($(this).val());
        currentPage = 1;
        updatePagination();
        updateInfo();
    });

    $("#searchInput").on("input", function () {
        searchTable($(this).val().toLowerCase());
    });

    $("#filterBtn").on("click", function () {
        alert("Filter functionality would be implemented here");
    });

    $("#customizeBtn").on("click", function () {
        alert("Customize functionality would be implemented here");
    });

    $("#exportBtn").on("click", function () {
        alert("Export functionality would be implemented here");
    });

    // Initialize table 6
    updatePagination();
    updateInfo();

    // ========== TABLE 7 (Store Original Data, Filter, Sort, Render, Actions) ==========

    let amdTable7OriginalData = [];
    let amdTable7CurrentData = [];

    // Store original table data
    $("#amdTable7TableBody tr").each(function () {
        const row = $(this);
        amdTable7OriginalData.push({
            element: row[0].outerHTML,
            company: row.find(".amd-table7-company-name").text().toLowerCase(),
            category: row.find("td:nth-child(2)").text().toLowerCase(),
            domain: row.find("td:nth-child(3)").text().toLowerCase(),
            location: row.find("td:nth-child(4)").text().toLowerCase(),
            status: row.find(".amd-table7-status-badge").text().toLowerCase(),
        });
    });

    amdTable7CurrentData = [...amdTable7OriginalData];

    // Initialize event listeners for table7
    $("#amdTable7SearchInput").on("input", function () {
        const searchTerm = $(this).val().toLowerCase();
        amdTable7FilterData(searchTerm);
    });

    $("#amdTable7SortBy").on("change", function () {
        amdTable7SortData($(this).val());
    });

    $("#amdTable7Filter").on("change", function () {
        amdTable7FilterByStatus($(this).val());
    });

    $("#amdTable7AddCompany").on("click", function () {
        alert("Add Company functionality would open a form modal here");
    });

    $("#amdTable7ImportExport").on("change", function () {
        const action = $(this).val();
        if (action !== "📥 Import/Export") {
            alert(`${action} functionality would be implemented here`);
            $(this).val("📥 Import/Export");
        }
    });

    // Filter data function
    function amdTable7FilterData(searchTerm) {
        if (!searchTerm) {
            amdTable7CurrentData = [...amdTable7OriginalData];
        } else {
            amdTable7CurrentData = amdTable7OriginalData.filter(
                (item) =>
                    item.company.includes(searchTerm) ||
                    item.category.includes(searchTerm) ||
                    item.domain.includes(searchTerm) ||
                    item.location.includes(searchTerm)
            );
        }
        amdTable7RenderTable();
    }

    // Sort data function
    function amdTable7SortData(sortBy) {
        switch (sortBy) {
            case "Name A-Z":
                amdTable7CurrentData.sort((a, b) =>
                    a.company.localeCompare(b.company)
                );
                break;
            case "Name Z-A":
                amdTable7CurrentData.sort((a, b) =>
                    b.company.localeCompare(a.company)
                );
                break;
            case "Category":
                amdTable7CurrentData.sort((a, b) =>
                    a.category.localeCompare(b.category)
                );
                break;
            case "Status":
                amdTable7CurrentData.sort((a, b) =>
                    a.status.localeCompare(b.status)
                );
                break;
        }
        amdTable7RenderTable();
    }

    // Filter by status
    function amdTable7FilterByStatus(status) {
        if (status === "🔍 Filter") {
            amdTable7CurrentData = [...amdTable7OriginalData];
        } else {
            amdTable7CurrentData = amdTable7OriginalData.filter(
                (item) => item.status === status.toLowerCase()
            );
        }
        amdTable7RenderTable();
    }

    // Render filtered/sorted table
    function amdTable7RenderTable() {
        const $tbody = $("#amdTable7TableBody");
        $tbody.empty();
        amdTable7CurrentData.forEach((item) => $tbody.append(item.element));

        // Re-bind action buttons events
        $(".amd-table7-action-btn")
            .off("click")
            .on("click", function () {
                amdTable7ShowActionMenu(this);
            });
    }

    // Action menu modal show
    function amdTable7ShowActionMenu(button) {
        const modal = new bootstrap.Modal($("#amdTable7ActionModal")[0]);
        modal.show();
    }

    // Action functions
    window.amdTable7EditCompany = function () {
        $("#amdTable7ActionModal").modal("hide");
        alert("Edit company functionality would open an edit form here");
    };

    window.amdTable7ViewCompany = function () {
        $("#amdTable7ActionModal").modal("hide");
        alert(
            "View company details functionality would show detailed information here"
        );
    };

    window.amdTable7DeleteCompany = function () {
        $("#amdTable7ActionModal").modal("hide");
        if (confirm("Are you sure you want to delete this company?")) {
            alert("Company would be deleted here");
        }
    };

    // Close modal if clicking outside
    $(document).on("click", function (e) {
        if (!$(e.target).closest(".amd-table7-action-btn, .modal").length) {
            $("#amdTable7ActionModal").modal("hide");
        }
    });
});

// form input group page js ************** */

// Password show/hide
function togglePwd() {
    var $pwd = $("#pwdInput");
    $pwd.attr("type", $pwd.attr("type") === "password" ? "text" : "password");
}
// Number spinner
function stepNumber(val) {
    var $input = $("#spinnerInput");
    var current = parseInt($input.val()) || 1;
    var min = parseInt($input.attr("min")) || 1;
    var max = parseInt($input.attr("max")) || 10;
    var next = current + val;
    if (next >= min && next <= max) $input.val(next);
}
// Tags input
var tags = [];
var $tagsBox = $("#tagsBox");
var $tagInput = $("#tagInput");
$tagInput.on("keydown", function (e) {
    if ((e.key === "Enter" || e.key === ",") && $tagInput.val().trim() !== "") {
        e.preventDefault();
        addTag($tagInput.val().trim());
        $tagInput.val("");
    }
});
function addTag(text) {
    if (tags.includes(text)) return;
    tags.push(text);
    renderTags();
}
function removeTag(text) {
    tags = tags.filter(function (t) {
        return t !== text;
    });
    renderTags();
}
function renderTags() {
    $tagsBox.empty();
    tags.forEach(function (tag) {
        var $tagEl = $('<span class="tag"></span>').html(
            tag +
                '<span class="remove-tag" style="margin-left:2px;">&times;</span>'
        );
        $tagEl.find(".remove-tag").on("click", function () {
            removeTag(tag);
        });
        $tagsBox.append($tagEl);
    });
    $tagsBox.append($tagInput);
    $tagInput.focus();
}
// Password strength
$("#pwdStrength").on("input", function () {
    var val = $(this).val();
    var $bar = $("#pwdStrengthBar");
    var strength = "weak";
    if (
        val.length > 8 &&
        /[A-Z]/.test(val) &&
        /\d/.test(val) &&
        /[^A-Za-z0-9]/.test(val)
    ) {
        strength = "strong";
    } else if (val.length > 5 && (/[A-Z]/.test(val) || /\d/.test(val))) {
        strength = "medium";
    }
    $bar.removeClass("weak medium strong").addClass(strength);
});
// Autocomplete
var fruits = [
    "Apple",
    "Banana",
    "Cherry",
    "Date",
    "Fig",
    "Grape",
    "Kiwi",
    "Lemon",
    "Mango",
    "Orange",
    "Peach",
    "Pear",
    "Pineapple",
    "Plum",
    "Strawberry",
    "Watermelon",
];
var $autoInput = $("#autoInput");
var $autoList = $("#autoList");
$autoInput.on("input", function () {
    var val = $autoInput.val().toLowerCase();
    $autoList.empty();
    if (val.length > 0) {
        var matches = fruits.filter(function (f) {
            return f.toLowerCase().startsWith(val);
        });
        matches.forEach(function (fruit) {
            var $li = $('<li class="dropdown-item"></li>').text(fruit);
            $li.on("click", function () {
                $autoInput.val(fruit);
                $autoList.empty().removeClass("show");
            });
            $autoList.append($li);
        });
        $autoList.addClass("show");
    } else {
        $autoList.removeClass("show");
    }
});
$(document).on("click", function (e) {
    if (!$(e.target).is($autoInput)) $autoList.removeClass("show");
});
// OTP input
$(".otp-input").each(function (idx, el) {
    $(el).on("input", function () {
        if ($(el).val().length === 1 && idx < $(".otp-input").length - 1)
            $(".otp-input")
                .eq(idx + 1)
                .focus();
    });
    $(el).on("keydown", function (e) {
        if (e.key === "Backspace" && $(el).val() === "" && idx > 0)
            $(".otp-input")
                .eq(idx - 1)
                .focus();
    });
});
// Star rating
var $starRating = $("#starRating");
if ($starRating.length) {
    var rating = 0;
    $starRating.find("i").each(function (idx, star) {
        $(star).on("mouseenter", function () {
            highlightStars(idx + 1);
        });
        $(star).on("mouseleave", function () {
            highlightStars(rating);
        });
        $(star).on("click", function () {
            rating = idx + 1;
            highlightStars(rating);
        });
    });
    function highlightStars(val) {
        $starRating.find("i").each(function (i, star) {
            if (i < val) {
                $(star).removeClass("bi-star").addClass("bi-star-fill");
            } else {
                $(star).removeClass("bi-star-fill").addClass("bi-star");
            }
        });
    }
}
// Copy to clipboard
$("#copyBtn").on("click", function () {
    var $copyInput = $("#copyInput");
    $copyInput[0].select();
    $copyInput[0].setSelectionRange(0, 99999);
    document.execCommand("copy");
    alert("Copied: " + $copyInput.val());
});

// files upload page jquery *************** */

$(document).ready(function () {
    // Helper function to format file size
    function formatSize(bytes) {
        if (bytes < 1024) return bytes + " B";
        if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + " KB";
        return (bytes / 1024 / 1024).toFixed(2) + " MB";
    }

    // Helper to get Bootstrap file icon based on extension
    function getFileIcon(filename) {
        const ext = filename.split(".").pop().toLowerCase();
        switch (ext) {
            case "pdf":
                return "bi-file-earmark-pdf";
            case "doc":
            case "docx":
                return "bi-file-earmark-word";
            case "xls":
            case "xlsx":
                return "bi-file-earmark-excel";
            case "ppt":
            case "pptx":
                return "bi-file-earmark-ppt";
            case "zip":
            case "rar":
                return "bi-file-earmark-zip";
            case "txt":
                return "bi-file-earmark-text";
            case "js":
            case "html":
            case "css":
                return "bi-file-earmark-code";
            case "mp3":
            case "wav":
                return "bi-file-earmark-music";
            case "mp4":
            case "avi":
                return "bi-file-earmark-play";
            default:
                return "bi-file-earmark";
        }
    }

    // --- 1. Drag & Drop with preview and remove ---
    let filesArr1 = [];
    const $dropzone1 = $("#dropzone1");
    const $dropzoneInput1 = $("#dropzoneInput1");
    const $previewList1 = $("#previewList1");
    const $fileError1 = $("#fileError1");

    $dropzone1.on("click", function () {
        $dropzoneInput1.trigger("click");
    });

    $dropzone1.on("dragover", function (e) {
        e.preventDefault();
        $(this).addClass("dragover");
    });

    $dropzone1.on("dragleave", function (e) {
        e.preventDefault();
        $(this).removeClass("dragover");
    });

    $dropzone1.on("drop", function (e) {
        e.preventDefault();
        $(this).removeClass("dragover");
        handleFiles1(e.originalEvent.dataTransfer.files);
    });

    $dropzoneInput1.on("change", function () {
        handleFiles1(this.files);
    });

    $dropzone1.on("keydown", function (e) {
        if (e.key === "Enter" || e.key === " ") {
            e.preventDefault();
            $dropzoneInput1.trigger("click");
        }
    });

    function handleFiles1(fileList) {
        $fileError1.hide();
        Array.from(fileList).forEach((file) => {
            if (
                !filesArr1.some(
                    (f) => f.name === file.name && f.size === file.size
                )
            ) {
                filesArr1.push(file);
            }
        });
        renderPreview1();
    }

    function renderPreview1() {
        $previewList1.empty(); // Clear previous previews
        filesArr1.forEach((file, idx) => {
            let iconHtml = file.type.startsWith("image/")
                ? `<img src="" class="amd-preview-img" alt="Image">`
                : `<span class="amd-preview-icon"><i class="bi ${getFileIcon(
                      file.name
                  )}"></i></span>`;

            const $previewItem = $(`
                        <div class="amd-preview-item">
                            <button class="amd-remove-btn" type="button" title="Remove" data-index="${idx}"><i class="bi bi-x-lg"></i></button>
                            ${iconHtml}
                            <div class="amd-preview-info">
                                <div class="amd-preview-name">${file.name}</div>
                                <div class="amd-preview-size">${formatSize(
                                    file.size
                                )}</div>
                            </div>
                        </div>
                    `);

            if (file.type.startsWith("image/")) {
                const $img = $previewItem.find(".amd-preview-img");
                const reader = new FileReader();
                reader.onload = function (e) {
                    $img.attr("src", e.target.result);
                };
                reader.readAsDataURL(file);
            }

            // Add event listener for the remove button
            $previewItem.find(".amd-remove-btn").on("click", function () {
                const indexToRemove = parseInt($(this).data("index"));
                filesArr1.splice(indexToRemove, 1);
                renderPreview1(); // Re-render to update indices and display
            });

            $previewList1.append($previewItem);
        });
    }

    // --- 2. Avatar Upload with live preview ---
    const $avatarInput = $("#avatarInput");
    const $avatarImg = $("#avatarImg");

    $avatarInput.on("change", function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $avatarImg.attr("src", e.target.result);
            };
            reader.readAsDataURL(file);
        }
    });

    // --- 3. File List with remove and file type icon ---
    let filesArr3 = [];
    const $fileListInput = $("#fileListInput");
    const $fileListUl = $("#fileList"); // Renamed to avoid conflict

    $fileListInput.on("change", function () {
        Array.from(this.files).forEach((file) => {
            if (
                !filesArr3.some(
                    (f) => f.name === file.name && f.size === file.size
                )
            ) {
                filesArr3.push(file);
            }
        });
        renderFileList();
    });

    function renderFileList() {
        $fileListUl.empty(); // Clear previous list items
        filesArr3.forEach((file, idx) => {
            const $listItem = $(`
                        <li>
                            <i class="bi ${getFileIcon(file.name)}"></i>
                            <span>${file.name} (${formatSize(file.size)})</span>
                            <button type="button" class="remove-file btn btn-link p-0 ms-auto" data-index="${idx}">
                                <i class="bi bi-x-circle-fill"></i>
                            </button>
                        </li>
                    `);

            $listItem.find(".remove-file").on("click", function () {
                const indexToRemove = parseInt($(this).data("index"));
                filesArr3.splice(indexToRemove, 1);
                renderFileList();
            });
            $fileListUl.append($listItem);
        });
    }

    // --- 4. Image Gallery Upload (multiple, preview, remove) ---
    let galleryFiles = [];
    const $galleryInput = $("#galleryInput");
    const $galleryPreview = $("#galleryPreview");

    $galleryInput.on("change", function () {
        Array.from(this.files).forEach((file) => {
            if (file.type.startsWith("image/")) {
                if (
                    !galleryFiles.some(
                        (f) => f.name === file.name && f.size === file.size
                    )
                ) {
                    galleryFiles.push(file);
                }
            } else {
                alert("Only image files are allowed for the gallery!");
            }
        });
        renderGalleryPreview();
    });

    function renderGalleryPreview() {
        $galleryPreview.empty();
        galleryFiles.forEach((file, idx) => {
            const $previewItem = $(`
                        <div class="amd-preview-item">
                            <button class="amd-remove-btn" type="button" title="Remove" data-index="${idx}"><i class="bi bi-x-lg"></i></button>
                            <img src="" class="amd-preview-img" alt="Image">
                            <div class="amd-preview-info">
                                <div class="amd-preview-name">${file.name}</div>
                                <div class="amd-preview-size">${formatSize(
                                    file.size
                                )}</div>
                            </div>
                        </div>
                    `);

            const $img = $previewItem.find(".amd-preview-img");
            const reader = new FileReader();
            reader.onload = function (e) {
                $img.attr("src", e.target.result);
            };
            reader.readAsDataURL(file);

            $previewItem.find(".amd-remove-btn").on("click", function () {
                const indexToRemove = parseInt($(this).data("index"));
                galleryFiles.splice(indexToRemove, 1);
                renderGalleryPreview();
            });

            $galleryPreview.append($previewItem);
        });
    }

    // --- 5. File Upload with Progress Bar ---
    const $progressInput = $("#progressInput");
    const $progressBtn = $("#progressBtn");
    const $progressBar = $("#progressBar");
    const $progressContainer = $progressBar.closest(".progress");
    const $progressStatus = $("#progressStatus");

    $progressBtn.on("click", function () {
        const file = $progressInput[0].files[0];
        if (!file) {
            $progressStatus
                .text("Please select a file first.")
                .css("color", "#dc3545");
            return;
        }

        $progressContainer.show();
        $progressBar.css("width", "0%").attr("aria-valuenow", 0).text("0%");
        $progressStatus.text("Uploading...").css("color", "#6610f2");

        let progress = 0;
        const interval = setInterval(() => {
            progress += 10;
            if (progress <= 100) {
                $progressBar
                    .css("width", progress + "%")
                    .attr("aria-valuenow", progress)
                    .text(progress + "%");
            }
            if (progress >= 100) {
                clearInterval(interval);
                $progressStatus
                    .text("Upload Complete!")
                    .css("color", "#198754"); // Green for success
                setTimeout(() => {
                    // Hide progress after a short delay
                    $progressContainer.hide();
                    $progressBar
                        .css("width", "0%")
                        .attr("aria-valuenow", 0)
                        .text("0%");
                    $progressStatus.text("");
                    $progressInput.val(""); // Clear the input
                }, 2000);
            }
        }, 100); // Simulate upload progress
    });

    // --- 6. Only PDF Upload (with icon) ---
    const $pdfInput = $("#pdfInput");
    const $pdfPreview = $("#pdfPreview");
    const $pdfFileName = $("#pdfFileName");
    const $pdfFileSize = $("#pdfFileSize");
    const $pdfError = $("#pdfError");

    $pdfInput.on("change", function () {
        const file = this.files[0];
        $pdfError.hide();
        $pdfPreview.hide();

        if (file) {
            if (file.type === "application/pdf") {
                $pdfFileName.text(file.name);
                $pdfFileSize.text(formatSize(file.size));
                $pdfPreview.css("display", "flex"); // Show the preview item
            } else {
                $pdfError.text("Only PDF files are allowed.").show();
                $(this).val(""); // Clear the input
            }
        }
    });

    window.removePdf = function () {
        $pdfInput.val(""); // Clear the input
        $pdfPreview.hide();
        $pdfError.hide();
    };

    // --- 7. File Upload with Size Limit (2MB) ---
    const $sizeLimitInput = $("#sizeLimitInput");
    const $sizeLimitError = $("#sizeLimitError");
    const MAX_FILE_SIZE = 2 * 1024 * 1024; // 2MB

    $sizeLimitInput.on("change", function () {
        const file = this.files[0];
        $sizeLimitError.hide();

        if (file) {
            if (file.size > MAX_FILE_SIZE) {
                $sizeLimitError
                    .text(
                        "File size exceeds 2MB limit. Please choose a smaller file."
                    )
                    .show();
                $(this).val(""); // Clear the input
            }
        }
    });

    // --- 8. File Upload with Custom Button ---
    const $customBtnInput = $("#customBtnInput");
    const $customBtnFile = $("#customBtnFile");

    $customBtnInput.on("change", function () {
        const file = this.files[0];
        if (file) {
            $customBtnFile.text(file.name);
        } else {
            $customBtnFile.text("");
        }
    });

    // --- 9. File Upload with Tooltip ---
    // Initialize tooltips (requires Bootstrap JS)
    const tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // --- 10. File Upload with Outline Button & Reset ---
    const $resetInput = $("#resetInput");
    const $resetFile = $("#resetFile");
    const $resetBtn = $("#resetBtn");

    $resetInput.on("change", function () {
        const file = this.files[0];
        if (file) {
            $resetFile.text(file.name);
        } else {
            $resetFile.text("");
        }
    });

    $resetBtn.on("click", function () {
        $resetInput.val(""); // Clear the file input
        $resetFile.text(""); // Clear the displayed file name
    });

    // --- 11. Floating File Upload with Animated Label ---
    // Bootstrap's form-floating handles the animation with CSS, no extra JS needed here
    // The placeholder attribute combined with the label for the input does the trick.

    // --- 12. File Upload with Drag-to-Select Animation ---
    let dragSelectFiles = [];
    const $dragSelectZone = $("#dragSelectZone");
    const $dragSelectInput = $("#dragSelectInput");
    const $dragSelectPreview = $("#dragSelectPreview");

    $dragSelectZone.on("click", function () {
        $dragSelectInput.trigger("click");
    });

    $dragSelectZone.on("dragover", function (e) {
        e.preventDefault();
        $(this)
            .addClass("dragover")
            .css("box-shadow", "0 0 0 0.25rem rgba(102, 16, 242, 0.25)"); // Add subtle glow
    });

    $dragSelectZone.on("dragleave", function (e) {
        e.preventDefault();
        $(this).removeClass("dragover").css("box-shadow", "none");
    });

    $dragSelectZone.on("drop", function (e) {
        e.preventDefault();
        $(this).removeClass("dragover").css("box-shadow", "none");
        handleDragSelectFiles(e.originalEvent.dataTransfer.files);
    });

    $dragSelectInput.on("change", function () {
        handleDragSelectFiles(this.files);
    });

    $dragSelectZone.on("focus", function () {
        $(this).css("box-shadow", "0 0 0 0.25rem rgba(102, 16, 242, 0.25)");
    });

    $dragSelectZone.on("blur", function () {
        $(this).css("box-shadow", "none");
    });

    function handleDragSelectFiles(fileList) {
        Array.from(fileList).forEach((file) => {
            if (
                !dragSelectFiles.some(
                    (f) => f.name === file.name && f.size === file.size
                )
            ) {
                dragSelectFiles.push(file);
            }
        });
        renderDragSelectPreview();
    }

    function renderDragSelectPreview() {
        $dragSelectPreview.empty();
        dragSelectFiles.forEach((file, idx) => {
            let iconHtml = file.type.startsWith("image/")
                ? `<img src="" class="amd-preview-img" alt="Image">`
                : `<span class="amd-preview-icon"><i class="bi ${getFileIcon(
                      file.name
                  )}"></i></span>`;
            const $previewItem = $(`
                        <div class="amd-preview-item">
                            <button class="amd-remove-btn" type="button" title="Remove" data-index="${idx}"><i class="bi bi-x-lg"></i></button>
                            ${iconHtml}
                            <div class="amd-preview-info">
                                <div class="amd-preview-name">${file.name}</div>
                                <div class="amd-preview-size">${formatSize(
                                    file.size
                                )}</div>
                            </div>
                        </div>
                    `);

            if (file.type.startsWith("image/")) {
                const $img = $previewItem.find(".amd-preview-img");
                const reader = new FileReader();
                reader.onload = function (e) {
                    $img.attr("src", e.target.result);
                };
                reader.readAsDataURL(file);
            }

            $previewItem.find(".amd-remove-btn").on("click", function () {
                const indexToRemove = parseInt($(this).data("index"));
                dragSelectFiles.splice(indexToRemove, 1);
                renderDragSelectPreview();
            });

            $dragSelectPreview.append($previewItem);
        });
    }

    // --- 13. File Upload with Stepper Progress ---
    const $stepperInput = $("#stepperInput");
    const $stepperBtn = $("#stepperBtn");
    const $stepperBar = $("#stepperBar");
    const $stepperStatus = $("#stepperStatus");
    const $stepperProgressContainer = $stepperBar.closest(".progress");

    $stepperBtn.on("click", function () {
        const file = $stepperInput[0].files[0];
        if (!file) {
            $stepperStatus
                .text("Please select a file for stepper upload.")
                .css("color", "#dc3545");
            return;
        }

        $stepperProgressContainer.show();
        $stepperBar.css("width", "0%").attr("aria-valuenow", 0).text("0%");
        $stepperStatus.text("Step 1: Initializing...").css("color", "#6610f2");
        let step = 0;
        const totalSteps = 5; // Example: 5 steps for upload process

        const stepperInterval = setInterval(() => {
            step++;
            const progress = (step / totalSteps) * 100;
            $stepperBar
                .css("width", progress + "%")
                .attr("aria-valuenow", progress)
                .text(Math.round(progress) + "%");

            if (step === 1) $stepperStatus.text("Step 1: Preparing file...");
            else if (step === 2)
                $stepperStatus.text("Step 2: Uploading chunks...");
            else if (step === 3)
                $stepperStatus.text("Step 3: Processing on server...");
            else if (step === 4) $stepperStatus.text("Step 4: Finalizing...");
            else if (step >= totalSteps) {
                clearInterval(stepperInterval);
                $stepperStatus
                    .text("Stepper Upload Complete!")
                    .css("color", "#198754");
                setTimeout(() => {
                    $stepperProgressContainer.hide();
                    $stepperBar
                        .css("width", "0%")
                        .attr("aria-valuenow", 0)
                        .text("0%");
                    $stepperStatus.text("");
                    $stepperInput.val("");
                }, 2000);
            }
        }, 500); // Simulate steps every 0.5 seconds
    });

    // --- 14. File Upload with Preview Carousel ---
    let carouselFiles = [];
    const $carouselInput = $("#carouselInput");
    const $carouselInner = $("#carouselInner");
    const $carouselPreview = $("#carouselPreview"); // The main carousel container

    $carouselInput.on("change", function () {
        carouselFiles = []; // Clear previous files for a new selection
        Array.from(this.files).forEach((file) => {
            if (file.type.startsWith("image/")) {
                carouselFiles.push(file);
            } else {
                alert("Only image files can be added to the carousel!");
            }
        });
        renderCarouselPreview();
    });

    function renderCarouselPreview() {
        $carouselInner.empty();
        if (carouselFiles.length === 0) {
            $carouselPreview.hide();
            return;
        }
        $carouselPreview.show(); // Show the carousel if there are images

        carouselFiles.forEach((file, idx) => {
            const reader = new FileReader();
            reader.onload = function (e) {
                const $carouselItem = $(`
                            <div class="carousel-item ${
                                idx === 0 ? "active" : ""
                            }">
                                <img src="${
                                    e.target.result
                                }" class="d-block w-100" alt="${file.name}">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>${file.name}</h5>
                                    <p>${formatSize(file.size)}</p>
                                </div>
                            </div>
                        `);
                $carouselInner.append($carouselItem);
            };
            reader.readAsDataURL(file);
        });
    }

    // --- 15. File Upload with Dropzone Progress Circle ---
    const $circleDropzone = $("#circleDropzone");
    const $circleDropInput = $("#circleDropInput");
    const $progressCircle = $("#progressCircle");
    const $progressCircleBar = $("#progressCircleBar");
    const $circleDropStatus = $("#circleDropStatus");
    const $circleDropPercent = $("#circleDropPercent");
    const circumference = 2 * Math.PI * 26; // 2 * PI * radius (radius is 26)
    $progressCircleBar.css("stroke-dasharray", circumference);

    $circleDropzone.on("click", function () {
        $circleDropInput.trigger("click");
    });
    $circleDropzone.on("dragover", function (e) {
        e.preventDefault();
        $(this).addClass("dragover");
    });
    $circleDropzone.on("dragleave", function (e) {
        e.preventDefault();
        $(this).removeClass("dragover");
    });
    $circleDropzone.on("drop", function (e) {
        e.preventDefault();
        $(this).removeClass("dragover");
        handleCircleDropFiles(e.originalEvent.dataTransfer.files);
    });
    $circleDropInput.on("change", function () {
        handleCircleDropFiles(this.files);
    });

    function handleCircleDropFiles(fileList) {
        const file = fileList[0]; // Assuming single file for progress circle
        if (!file) {
            $circleDropStatus.text("No file selected.").css("color", "#dc3545");
            $progressCircle.hide();
            $circleDropPercent.hide();
            return;
        }

        $circleDropStatus.text("");
        $progressCircle.show();
        $circleDropPercent.show().text("0%");
        $progressCircleBar.css("stroke-dashoffset", circumference);

        let progress = 0;
        const uploadInterval = setInterval(() => {
            progress += 5; // Simulate progress
            if (progress > 100) progress = 100;

            const offset = circumference - (progress / 100) * circumference;
            $progressCircleBar.css("stroke-dashoffset", offset);
            $circleDropPercent.text(progress + "%");

            if (progress === 100) {
                clearInterval(uploadInterval);
                $circleDropStatus
                    .text(
                        `Upload complete: ${file.name} (${formatSize(
                            file.size
                        )})`
                    )
                    .css("color", "#198754");
                setTimeout(() => {
                    $progressCircle.hide();
                    $circleDropPercent.hide();
                    $circleDropStatus.text("");
                    $circleDropInput.val("");
                }, 2000);
            }
        }, 50); // Simulate upload speed
    }
});

let amdFiles = [];

function isImage(fileType) {
    return fileType.startsWith("image/");
}

function renderFile(file) {
    const idx = amdFiles.length;
    const reader = new FileReader();
    const $file = $(
        '<div class="amd-file-upload-spl-file" data-idx="' + idx + '"></div>'
    );

    let contentReady = function (thumbnail) {
        $file.append(thumbnail);
        $file.append(
            `<div class="amd-file-upload-spl-file-name">${file.name}</div>`
        );
        $file.append(
            `<button class="amd-file-upload-spl-file-remove"><i class="bi bi-trash"></i></button>`
        );
        $file.append(`
        <div class="amd-file-upload-spl-progress">
          <div class="amd-file-upload-spl-progress-bar"></div>
        </div>
      `);
        $("#amdUploadList").append($file);

        let $bar = $file.find(".amd-file-upload-spl-progress-bar");
        let percent = 0;
        let interval = setInterval(() => {
            percent += 5;
            $bar.css("width", percent + "%");
            if (percent >= 100) {
                clearInterval(interval);
                $bar.addClass("uploaded");
            }
        }, 60);
    };

    if (isImage(file.type)) {
        reader.onload = function (e) {
            contentReady(
                `<img src="${e.target.result}" class="amd-file-upload-spl-thumb" />`
            );
        };
        reader.readAsDataURL(file);
    } else {
        contentReady(
            `<div class="amd-file-upload-spl-thumb d-flex align-items-center justify-content-center" style="font-size:18px;">📄</div>`
        );
    }
}

function handleFiles(files) {
    Array.from(files).forEach((file) => {
        if (
            !amdFiles.some((f) => f.name === file.name && f.size === file.size)
        ) {
            amdFiles.push(file);
            renderFile(file);
        }
    });
}
// Browse
$("#amdBrowseBtn").on("click", function () {
    $("#amdFileInput").click();
});

// On file input
$("#amdFileInput").on("change", function () {
    handleFiles(this.files);
});

// Drag & drop
$("#amdDropzone")
    .on("dragover", function (e) {
        e.preventDefault();
        $(this).addClass("dragover");
    })
    .on("dragleave drop", function (e) {
        e.preventDefault();
        $(this).removeClass("dragover");
    })
    .on("drop", function (e) {
        const files = e.originalEvent.dataTransfer.files;
        handleFiles(files);
    });

// Remove
$("#amdUploadList").on(
    "click",
    ".amd-file-upload-spl-file-remove",
    function () {
        const $file = $(this).closest(".amd-file-upload-spl-file");
        const idx = $file.data("idx");
        amdFiles.splice(idx, 1);
        $file.remove();
    }
);

// fiel upload page end *************** */

// dropdown page js *************** */

$(function () {
    $('.amd-multi-select-person-tag-v2-container').each(function () {

        const $container = $(this);
        const $tags = $container.find('.amd-multi-select-person-tag-v2-tags');
        const $input = $tags.find('input');
        const $dropdown = $container.find('.amd-multi-select-person-tag-v2-dropdown');
        const $checkboxes = $dropdown.find('input.amd-multi-select-checkbox');
        const selected = new Map();

        // ===========================
        // DEFAULT SELECT USING CLASS
        // ===========================
        $dropdown.find("li.amd-default-selected").each(function () {
            const $li = $(this);
            const name = $li.data("value");
            const img = $li.data("img");

            selected.set(name, img);

            // Mark checkbox as checked
            $li.find("input.amd-multi-select-checkbox")
                .prop("checked", true);
        });

        updateUI();
        // ===========================


        // Toggle dropdown
        $tags.on('click', () => {
            $dropdown.toggle();
        });

        // Close dropdown on outside click
        $(document).on('click', (e) => {
            if (!$container.is(e.target) && $container.has(e.target).length === 0) {
                $dropdown.hide();
            }
        });

        // Checkbox change event
        $checkboxes.on('change', function () {
            const $cb = $(this);
            const $li = $cb.closest('li');
            const val = $li.data('value');
            const img = $li.data('img');

            if ($cb.is(':checked')) {
                selected.set(val, img);
            } else {
                selected.delete(val);
            }

            updateUI();
        });

        // -------------------
        // UPDATE TAGS UI
        // -------------------
        function updateUI() {
            $tags.find('.amd-multi-select-person-tag-v2-tag').remove();

            selected.forEach((img, name) => {
                const $tag = $(`
                    <div class="amd-multi-select-person-tag-v2-tag">
                        <span>${name}</span>
                        <span class="remove-tag" title="Remove">&times;</span>
                    </div>
                `);

                // Remove tag event
                $tag.find('.remove-tag').on('click', function () {
                    selected.delete(name);

                    // Uncheck corresponding checkbox
                    $checkboxes.filter(function () {
                        return $(this).closest('li').data('value') === name;
                    })
                    .prop('checked', false)
                    .trigger('change');

                    updateUI();
                });

                $tag.insertBefore($input);
            });

            $input.attr('placeholder', selected.size === 0 ? 'Select persons...' : '');
        }

    });
});

$(document).ready(function () {
    // --- Variant 13, 14, 15: Keep dropdown open on click inside ---
    // This is necessary for forms, checkboxes, and radio buttons.
    $("#checkbox-menu, #radio-menu, #form-menu, #search-menu").on(
        "click",
        function (e) {
            e.stopPropagation();
        }
    );

    // --- Variant 20: Hover Dropdown ---
    $("#hover-dropdown")
        .on("mouseenter", function () {
            $(this).find(".dropdown-menu").addClass("show");
        })
        .on("mouseleave", function () {
            $(this).find(".dropdown-menu").removeClass("show");
        });

    // --- Variant 22: Search Filter Dropdown ---
    $("#search-input").on("keyup", function () {
        const filter = $(this).val().toLowerCase();
        const items = $("#search-menu a.dropdown-item");

        items.each(function () {
            const text = $(this).text().toLowerCase();
            if (text.includes(filter)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});

$(document).ready(function () {
    // Keep dropdown open on click inside for forms and search menus
    $("#form-menu, #search-menu").on("click", function (e) {
        e.stopPropagation();
    });

    // Search Filter for Variant 11
    $("#search-input").on("keyup", function () {
        const filter = $(this).val().toLowerCase();
        const items = $("#search-menu a.dropdown-item");
        items.each(function () {
            $(this).toggle($(this).text().toLowerCase().includes(filter));
        });
    });
});

// dropdown page end *************** */

// carousel page js *************** */

document.addEventListener("DOMContentLoaded", function () {
    var carouselThumbs = document.getElementById("carouselThumbs");
    if (carouselThumbs) {
        carouselThumbs.addEventListener("slid.bs.carousel", function (e) {
            var newIndex = e.to; // Get the index of the new slide

            // Remove 'active' from all thumb items
            var thumbItems =
                carouselThumbs.nextElementSibling.querySelectorAll(
                    ".thumb-item"
                );
            thumbItems.forEach(function (item) {
                item.classList.remove("active");
            });

            // Add 'active' to the corresponding thumb item
            thumbItems[newIndex].classList.add("active");
        });
    }
});

// carousel end *************** */

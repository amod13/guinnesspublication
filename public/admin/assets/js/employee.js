// sidebar steps js
const steps = document.querySelectorAll(".amd-soft-empl-step-circle");
const forms = document.querySelectorAll(".amd-soft-empl-form-step");

steps.forEach((step) => {
  step.addEventListener("click", () => {
    const stepIndex = step.getAttribute("data-step");

    // Toggle active step circle
    steps.forEach((s) => s.classList.remove("active"));
    step.classList.add("active");

    // Show corresponding form step
    forms.forEach((form) => {
      if (form.getAttribute("data-step") === stepIndex) {
        form.classList.add("active");
      } else {
        form.classList.remove("active");
      }
    });
  });
});

//   img upladed jquerry or img preview
$(document).ready(function () {
  $(".certificate-input, .Experience").on("change", function () {
    debugger;
    const file = this.files[0];
    const container = $(this).closest(".certificate-upload-wrapper");
    const previewBox = container.find(".preview-box");
    const uploadBox = container.find(".certificate-upload-box");

    if (!file) {
      previewBox.hide().empty();
      uploadBox.removeClass("compact");
      container.removeClass("compact-container");
      return;
    }

    uploadBox.addClass("compact");
    container.addClass("compact-container");
    previewBox.show().html('<div class="loader"></div>');

    setTimeout(() => {
      previewBox.empty();
      if (file.type.startsWith("image/")) {
        const reader = new FileReader();
        reader.onload = function (e) {
          const img = $("<img>").attr("src", e.target.result);
          previewBox.append(img);
        };
        reader.readAsDataURL(file);
      } else if (file.type === "application/pdf") {
        const icon = $('<div style="font-size:32px;">📄</div>');
        previewBox.append(icon);
      }
    }, 800);
  });
});

// add more eucation and work

$(".btn-outline-primary").click(function (e) {
  e.preventDefault();
  const $container = $(this).closest(".tab-pane").find("> div[id$='-rows']");
  const $lastRow = $container.find(".education-row").last();
  const $newRow = $lastRow.clone();

  // Reset inputs
  $newRow.find("input, select").val("");
  $newRow.find(".preview-box").hide().empty();
  $newRow.find(".certificate-upload-box").removeClass("compact");
  $newRow.find(".certificate-upload-wrapper").removeClass("compact-container");

  $container.append($newRow);

  // Scroll smoothly to new row and focus first input inside it
  $("html, body").animate(
    {
      scrollTop: $newRow.offset().top - 100, // adjust offset as needed
    },
    400
  );

  $newRow.find("input, select").first().focus();
});

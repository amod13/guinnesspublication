
document.addEventListener("DOMContentLoaded", function () {

    // --- CORE SETUP ---
    const flipbookContainer = document.getElementById('flipbook');
    const loader = document.getElementById('loader');
    const loaderText = document.getElementById('loader-text');
    const iframe = document.querySelector('iframe');

    let pageFlip = null; // Keep track of the current flipbook instance

    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.worker.min.js';

    /**
     * Shows the loader and destroys any existing flipbook instance.
     * This is crucial for reloading.
     */
    function startLoading() {
        loader.classList.remove('hidden');
        if (pageFlip) {
            pageFlip.destroy();
            pageFlip = null;
        }
        flipbookContainer.innerHTML = ''; // Clear old pages
    }

    /**
     * This is the main function to load and render a PDF from a URL.
     */
    function loadPdfFromUrl(url) {
        if (!url) {
            console.error("No URL provided to load.");
            return;
        }

        startLoading();
        loaderText.textContent = 'Loading PDF...';

        const pdfDocPromise = pdfjsLib.getDocument(url).promise;
        pdfDocPromise.then(renderPdfToFlipbook).catch(error => {
            console.error("Failed to load or render PDF from URL:", url, error);
            loaderText.innerHTML = `<p>Error: Could not load PDF.</p>`;
        });
    }

    /**
     * Renders each page of a loaded PDF into the flipbook container.
     */
    async function renderPdfToFlipbook(pdf) {
        const frontCover = document.createElement('div');
        frontCover.classList.add('page', 'hard');
        flipbookContainer.appendChild(frontCover);

        for (let i = 1; i <= pdf.numPages; i++) {
            loaderText.textContent = `Rendering page ${i} of ${pdf.numPages}...`;
            const page = await pdf.getPage(i);
            const scale = 2.0;
            const viewport = page.getViewport({ scale });

            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            await page.render({ canvasContext: context, viewport: viewport }).promise;

            const pageElement = document.createElement('div');
            pageElement.classList.add('page');
            const img = document.createElement('img');
            img.src = canvas.toDataURL('image/jpeg', 0.8);
            pageElement.appendChild(img);
            flipbookContainer.appendChild(pageElement);
        }

        const backCover = document.createElement('div');
        backCover.classList.add('page', 'hard');
        flipbookContainer.appendChild(backCover);

        initializeFlipbook();
    }

    /**
     * Initializes the PageFlip library on our container.
     */
    function initializeFlipbook() {
        loader.classList.add('hidden');

        // Create a new instance and store it in the global 'pageFlip' variable
        pageFlip = new St.PageFlip(flipbookContainer, {

            width: 400,
            height: 600,
            showCover: true,
            drawShadow: true,
            flippingTime: 1000,
            maxShadowOpacity: 0.2
        });

        pageFlip.loadFromHTML(document.querySelectorAll('.page'));
    }


    // --- DYNAMIC LOADING LOGIC ---

    if (iframe) {
        // 1. Initial Load: Load the PDF from the iframe's starting URL.
        const initialUrl = iframe.src;
        loadPdfFromUrl(initialUrl);

        // 2. Setup the Observer: Create a MutationObserver to watch for changes.
        const observer = new MutationObserver((mutationsList) => {
            for (const mutation of mutationsList) {
                // We only care about changes to the 'src' attribute.
                if (mutation.type === 'attributes' && mutation.attributeName === 'src') {
                    const newUrl = mutation.target.src;
                    console.log(`iframe src changed to: ${newUrl}. Reloading book.`);
                    // Reload the book with the new URL.
                    loadPdfFromUrl(newUrl);
                }
            }
        });

        // 3. Start Observing: Tell the observer to watch the iframe for attribute changes.
        observer.observe(iframe, { attributes: true });

    } else {
        console.error("Could not find an iframe element on the page.");
        loaderText.innerHTML = `<p>Error: No iframe found.</p>`;
    }

});



// flipbook show by the clicking start reading btn**************************
document.getElementById("startReadingPdf").addEventListener("click", function () {
    const flipbookSection = document.querySelector(".amd-flipbook-section");
    const bookPartDiv = document.getElementById("bookPart");
    const readButton = document.getElementById("startReadingPdf");

    // Show flipbook smoothly
    flipbookSection.style.visibility = "visible";
    flipbookSection.style.height = "880px";
    flipbookSection.style.overflow = "visible";
    flipbookSection.scrollIntoView({ behavior: "smooth" });

    // Book part ko dheere se fade out karne ke liye:
    bookPartDiv.style.transition = "opacity 0.6s ease";
    bookPartDiv.style.opacity = 0;

    // Button bhi fade out karo
    readButton.style.transition = "opacity 0.6s ease";
    readButton.style.opacity = 0;

    // 600ms ke baad dono ko display none karo taaki interaction band ho jaye
    setTimeout(() => {
        bookPartDiv.style.display = "none";
        readButton.style.display = "none";
        bookPartDiv.style.opacity = 1;  // next time agar show karna ho toh reset
        readButton.style.opacity = 1;
    }, 600);
});

// flipbook show by the clicking start reading btn end**************************

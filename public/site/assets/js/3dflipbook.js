
document.addEventListener("DOMContentLoaded", function () {
    // This code runs only after the entire HTML page has fully loaded.

    // --- CORE SETUP ---
    const flipbookContainer = document.getElementById('flipbook'); 
    const loader = document.getElementById('loader');             
    const loaderText = document.getElementById('loader-text');    
    const iframe = document.querySelector('iframe');              

    let pageFlip = null; 
    
    // A Set to track which pages are currently being rendered or have been fully rendered.
    // This prevents the same page from being rendered multiple times simultaneously.
    const renderingPages = new Set(); 

    // Set the path for the PDF processing file (the 'worker'). This helps PDF.js handle heavy tasks.
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.worker.min.js';

    /**
     * startLoading(): Shows the loader screen and cleans up any old flipbook instance.
     * This is crucial before loading a new PDF.
     */
    function startLoading() {
        loader.classList.remove('hidden');
        if (pageFlip) {
            pageFlip.destroy();           
            pageFlip = null;
        }
        flipbookContainer.innerHTML = ''; 
        renderingPages.clear();           
    }

    /**
     * loadPdfFromUrl(url): The main function to start fetching the PDF from a URL.
     */
    function loadPdfFromUrl(url) {
        if (!url) {
            console.error("No URL provided to load.");
            return;
        }

        startLoading();
        loaderText.textContent = 'Loading PDF...';

        // Start the process of getting the PDF document using PDF.js.
        const pdfDocPromise = pdfjsLib.getDocument(url).promise;
        
        // If successful, proceed to render the pages. If it fails, show an error.
        pdfDocPromise.then(renderPdfToFlipbook).catch(error => {
            console.error("Failed to load or render PDF from URL:", url, error);
            loaderText.innerHTML = `<p>Error: Could not load PDF.</p>`;
        });
    }

    // --- HELPER FUNCTION: Renders a single page ---
    /**
     * renderPage(pdf, pageNum, pageElement): Takes one PDF page, converts it into an image 
     * using Canvas, and inserts it into the page element.
     */
    async function renderPage(pdf, pageNum, pageElement) {
        // If the page is already rendered or rendering, stop here.
        if (pageElement.getAttribute('data-rendered') === 'true' || renderingPages.has(pageNum)) {
            return; 
        }
        
        renderingPages.add(pageNum); // Mark this page as 'rendering now'.
        pageElement.classList.add('is-loading'); // Add a visual loading state (CSS needed).
        
        try {
            const page = await pdf.getPage(pageNum);
            const scale = 1.5; // Optimization: Lower scale means faster rendering but slightly lower quality.
            const viewport = page.getViewport({ scale });
            
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            // Wait for the page to be drawn onto the canvas.
            await page.render({ canvasContext: context, viewport: viewport }).promise;

            // Clear the element and add the final image.
            pageElement.innerHTML = '';
            const img = document.createElement('img');
            img.src = canvas.toDataURL('image/jpeg', 0.7); // Optimization: Lower JPEG quality (0.7) for smaller file size.
            pageElement.appendChild(img);
            
            pageElement.setAttribute('data-rendered', 'true'); // Mark as finished rendering.
        } catch (error) {
            console.error(`Failed to render page ${pageNum}:`, error);
            pageElement.innerHTML = `<div class="error-text">Failed to load Page ${pageNum}</div>`;
        } finally {
            pageElement.classList.remove('is-loading');
            renderingPages.delete(pageNum); // Remove from the set.
        }
    }


    // --- CORE LOGIC: SETUP FOR LAZY LOADING ---
    /**
     * renderPdfToFlipbook(pdf): Loops through all PDF pages and sets up the flipbook structure.
     */
    async function renderPdfToFlipbook(pdf) {
        // We only render the cover and the very first content page immediately for speed.
        const pagesToRenderImmediately = 1; 

        // 1. Add Front Cover (Hard Page)
        const frontCover = document.createElement('div');
        frontCover.classList.add('page', 'hard');
        flipbookContainer.appendChild(frontCover);

        // 2. Loop through all PDF pages
        for (let i = 1; i <= pdf.numPages; i++) {
            const pageElement = document.createElement('div');
            pageElement.classList.add('page');
            pageElement.setAttribute('data-page-num', i); // Store the actual PDF page number.

            if (i <= pagesToRenderImmediately) {
                // RENDER IMMEDIATELY: Wait for the first page to load.
                loaderText.textContent = `Rendering initial page ${i} of ${pdf.numPages}...`;
                await renderPage(pdf, i, pageElement);
            } else {
                // LAZY LOAD PLACEHOLDER: Insert an empty div for fast initial load.
            }

            flipbookContainer.appendChild(pageElement);
        }

        // 3. Add Back Cover (Hard Page)
        const backCover = document.createElement('div');
        backCover.classList.add('page', 'hard');
        flipbookContainer.appendChild(backCover);

        // 4. Start the flipbook and set up pre-loading.
        initializeFlipbook(pdf); 
    }

    /**
     * initializeFlipbook(pdf): Starts the flipbook and sets up the listener for lazy page loading.
     */
    function initializeFlipbook(pdf) {
        loader.classList.add('hidden'); // Hide the loader now that pages are structured.

        // Create the new PageFlip instance.
        pageFlip = new St.PageFlip(flipbookContainer, {
            width: 400,
            height: 600,
            showCover: true,
            drawShadow: true,
            flippingTime: 800, 
            maxShadowOpacity: 0.2
        });

        pageFlip.loadFromHTML(document.querySelectorAll('.page')); 

        // --- PRE-LOADING OF NEXT 2 PAGES LOGIC ---
        // Listen for the 'flip' event (when a page turn is complete).
        pageFlip.on('flip', (e) => {
            // e.data is the 0-based index of the current left page.
            const currentPageIndex = e.data; 
            
            // Calculate the 1-based PDF page numbers for the next two pages to preload:
            // 1. The page that will appear on the right side of the next view.
            const pageToPreload1 = currentPageIndex + 2; 
            // 2. The page right after that.
            const pageToPreload2 = currentPageIndex + 3;

            // Pre-load Page 1 (The next immediate page)
            const element1 = document.querySelector(`.page[data-page-num='${pageToPreload1}']`);
            if (element1) {
                console.log(`Pre-loading page ${pageToPreload1}...`);
                // Start rendering without waiting ('await') so it runs in the background.
                renderPage(pdf, pageToPreload1, element1)
                    .catch(err => console.error("Pre-load 1 failed:", err));
            }

            // Pre-load Page 2 (The page after the next one)
            const element2 = document.querySelector(`.page[data-page-num='${pageToPreload2}']`);
            if (element2) {
                console.log(`Pre-loading page ${pageToPreload2}...`);
                renderPage(pdf, pageToPreload2, element2)
                    .catch(err => console.error("Pre-load 2 failed:", err));
            }
        });
        
        // Bonus: Start pre-loading Page 2 and Page 3 immediately after the flipbook loads.
        // This makes sure the first page flip is very smooth.
        const initialPages = [2, 3];
        initialPages.forEach(pageNum => {
            const initialElement = document.querySelector(`.page[data-page-num='${pageNum}']`);
            if (initialElement) {
                 renderPage(pdf, pageNum, initialElement).catch(err => console.error(`Initial pre-load of page ${pageNum} failed:`, err));
            }
        });
    }

    // --- DYNAMIC LOADING LOGIC (Handling URL Changes) ---

    if (iframe) {
        // 1. Initial Load: Load the PDF from the iframe's starting URL.
        const initialUrl = iframe.src;
        loadPdfFromUrl(initialUrl);

        // 2. Setup the MutationObserver to watch for changes in the iframe's URL.
        const observer = new MutationObserver((mutationsList) => {
            for (const mutation of mutationsList) {
                // If the 'src' attribute changes...
                if (mutation.type === 'attributes' && mutation.attributeName === 'src') {
                    const newUrl = mutation.target.src;
                    console.log(`iframe src changed to: ${newUrl}. Reloading book.`);
                    // ...reload the flipbook with the new PDF URL.
                    loadPdfFromUrl(newUrl);
                }
            }
        });

        // 3. Start watching the iframe for attribute changes.
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



// zoom in out and grab draging js
 const flipbook = document.getElementById("flipbook");

let scale = 1;
let isDragging = false;
let startX, startY, scrollLeft, scrollTop;

// --- Apply Zoom ---
function applyZoom() {
    flipbook.style.transform = `scale(${scale})`;
}

// --- Zoom In Button ---
document.getElementById("zoomIn").addEventListener("click", function () {
    scale += 0.1;
    if (scale > 3) scale = 3; 
    applyZoom();
});

// --- Zoom Out Button ---
document.getElementById("zoomOut").addEventListener("click", function () {
    scale -= 0.1;
    if (scale < 1) scale = 1; 
    applyZoom();
});

// --- Mouse Wheel Zoom ---
flipbook.addEventListener("wheel", function (e) {
    e.preventDefault();
    if (e.deltaY < 0) scale += 0.05;
    else scale -= 0.05;

    if (scale < 1) scale = 1;
    if (scale > 3) scale = 3;

    applyZoom();
});

// --- Drag to Move when Zoomed ---
flipbook.addEventListener("mousedown", function (e) {
    if (scale === 1) return; // only draggable when zoomed

    isDragging = true;
    startX = e.pageX - flipbook.offsetLeft;
    startY = e.pageY - flipbook.offsetTop;

    scrollLeft = flipbook.parentElement.scrollLeft;
    scrollTop = flipbook.parentElement.scrollTop;
});

flipbook.addEventListener("mouseup", () => isDragging = false);
flipbook.addEventListener("mouseleave", () => isDragging = false);

flipbook.addEventListener("mousemove", function (e) {
    if (!isDragging) return;

    e.preventDefault();
    let x = e.pageX - flipbook.offsetLeft;
    let y = e.pageY - flipbook.offsetTop;

    let walkX = x - startX;
    let walkY = y - startY;

    flipbook.parentElement.scrollLeft = scrollLeft - walkX;
    flipbook.parentElement.scrollTop = scrollTop - walkY;
});

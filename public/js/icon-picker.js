// ✅ 10 Default icons to show initially
const defaultIcons = [
    'fas fa-home', 'fas fa-user', 'fas fa-star', 'fas fa-heart',
    'fas fa-check', 'fas fa-times', 'fas fa-plus', 'fas fa-edit',
    'fas fa-trash', 'fas fa-search'
];

// ✅ Fallback local list (if API fails)
const localIcons = [
    'fas fa-home', 'fas fa-user', 'fas fa-star', 'fas fa-heart', 'fas fa-check',
    'fas fa-times', 'fas fa-plus', 'fas fa-minus', 'fas fa-edit', 'fas fa-trash',
    'fas fa-search', 'fas fa-envelope', 'fas fa-phone', 'fas fa-map-marker-alt',
    'fas fa-calendar', 'fas fa-clock', 'fas fa-download', 'fas fa-upload',
    'fas fa-share', 'fas fa-print', 'fas fa-save', 'fas fa-copy', 'fas fa-cut',
    'fas fa-paste', 'fas fa-undo', 'fas fa-redo', 'fas fa-bold', 'fas fa-italic',
    'fas fa-underline', 'fas fa-align-left', 'fas fa-align-center', 'fas fa-align-right',
    'fas fa-list', 'fas fa-table', 'fas fa-image', 'fas fa-video', 'fas fa-music',
    'fas fa-database', 'fas fa-cog', 'fas fa-cogs', 'fas fa-layer-group', 'fas fa-sitemap'
];

let currentIconInput = null;

function initIconPicker() {
    if (!document.getElementById('iconPickerModal')) {
        const modalHTML = `
            <div class="modal fade" id="iconPickerModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Choose Icon</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <input type="text" class="form-control" id="iconSearch" placeholder="Search free FontAwesome icons...">
                            </div>
                            <div class="row" id="iconGrid"></div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', modalHTML);

        // 🔹 Show 10 default icons initially
        populateIcons(defaultIcons);

        // 🔍 Handle search
        document.getElementById('iconSearch').addEventListener('input', async function (e) {
            const term = e.target.value.trim();
            if (term === '') {
                populateIcons(defaultIcons);
            } else {
                try {
                    const icons = await searchIcons(term);
                    if (icons && icons.length > 0) {
                        populateIcons(icons);
                    } else {
                        const fallback = localIcons.filter(ic => ic.toLowerCase().includes(term.toLowerCase()));
                        populateIcons(fallback);
                    }
                } catch (err) {
                    console.error('Icon search failed:', err);
                    const fallback = localIcons.filter(ic => ic.toLowerCase().includes(term.toLowerCase()));
                    populateIcons(fallback);
                }
            }
        });
    }
}

function populateIcons(icons) {
    const iconGrid = document.getElementById('iconGrid');
    iconGrid.innerHTML = '';
    icons.forEach(icon => {
        const iconDiv = document.createElement('div');
        iconDiv.className = 'col-2 mb-3 text-center';
        iconDiv.innerHTML = `
            <div class="icon-item p-2 border rounded" onclick="selectIcon('${icon}')" title="${icon}" style="cursor: pointer;">
                <i class="${icon} fa-lg"></i>
                <small class="d-block mt-1">${icon.split(' ')[1]}</small>
            </div>
        `;
        iconGrid.appendChild(iconDiv);
    });
}

function selectIcon(iconClass) {
    if (currentIconInput) {
        currentIconInput.value = iconClass;
        currentIconInput.dispatchEvent(new Event('change'));
    }
    const modalEl = document.getElementById('iconPickerModal');
    const modal = bootstrap.Modal.getInstance(modalEl);
    modal.hide();
}

function openIconPicker(inputElement) {
    currentIconInput = inputElement;
    initIconPicker();
    const modal = new bootstrap.Modal(document.getElementById('iconPickerModal'));
    modal.show();
}

// 🔎 Fetch only FREE FontAwesome icons
async function searchIcons(term) {
    const query = `
        query {
            search(version: "latest", query: "${term}", first: 20) {
                id
                styles
                membership {
                    free
                    pro
                }
            }
        }
    `;

    const response = await fetch('https://api.fontawesome.com/graphql', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            // Add your FontAwesome API key here if required:
            // 'Authorization': 'Bearer YOUR_FA_API_TOKEN'
        },
        body: JSON.stringify({ query }),
    });

    if (!response.ok) throw new Error('Network error fetching icons');
    const data = await response.json();

    if (data.data && data.data.search) {
        // Filter to FREE icons only
        const freeIcons = data.data.search.filter(icon => icon.membership.free.length > 0);

        // Map to usable class names
        return freeIcons.map(icon => {
            const style = icon.membership.free[0]; // pick first free style
            const prefix = style === 'solid' ? 'fas' : `fa-${style}`;
            return `${prefix} fa-${icon.id}`;
        });
    }

    return [];
}

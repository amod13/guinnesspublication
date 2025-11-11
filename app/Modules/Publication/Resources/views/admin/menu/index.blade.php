@extends('admin.main.app')
@section('content')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        /* CSS Variables for easier theming */
        :root {
            --primary-color: #0d6efd;
            --light-primary: #e6f0ff;
            --border-color: #dee2e6;
            --bg-light: #f8f9fa;
            --text-muted: #6c757d;
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            --shadow-sm: 0 2px 6px rgba(0, 0, 0, 0.06);
        }

        .menu-builder-container {
            display: flex;
            gap: 2rem;
        }

        .menu-sources,
        .menu-structure {
            flex-grow: 1;
        }

        .menu-sources {
            flex-basis: 35%;
            max-width: 400px;
        }

        .menu-structure {
            flex-basis: 65%;
        }

        .card.menu-card {
            border: none;
            box-shadow: var(--shadow);
            border-radius: 12px;
            overflow: hidden;
        }

        .card-header.menu-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: 600;
            border-bottom: 0;
            padding: 1rem 1.5rem;
        }

        .card-header.menu-header h5 {
            margin: 0;
            font-size: 1.1rem;
        }

        #menu-container {
            padding: 1rem;
            background: #fff;
            min-height: 400px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .menu-item {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 6px;
            margin: 4px 0;
            padding: 12px 15px;
            transition: all 0.2s;
            position: relative;
        }

        .menu-item:hover,
        .menu-item-hover {
            background: #f8f9fa;
            border-color: #007bff;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 123, 255, 0.1);
        }

        .menu-item:hover .drag-handle {
            color: #007bff;
            background: #e3f2fd;
        }

        .menu-item .menu-item-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .menu-item-title {
            font-weight: normal;
            color: #333;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }

        .menu-item-title .drag-handle {
            color: #666;
            cursor: grab;
            font-size: 14px;
            padding: 4px;
            margin-right: 8px;
            border-radius: 3px;
            transition: all 0.2s;
        }

        .menu-item-title .drag-handle:hover {
            background: #f0f0f0;
            color: #333;
        }

        .menu-item-title .drag-handle:active {
            cursor: grabbing;
            background: #e0e0e0;
        }

        .menu-item-title .menu-icon {
            color: #666;
            font-size: 12px;
        }

        .menu-item-actions {
            display: flex;
            gap: 4px;
        }

        .menu-item-actions .btn {
            padding: 2px 6px;
            font-size: 11px;
            border-radius: 2px;
        }

        .sub-menu {
            margin-left: 25px;
            padding-left: 20px;
            margin-top: 8px;
            border-left: 3px solid #e0e0e0;
            min-height: 40px;
            border-radius: 0 0 0 8px;
            position: relative;
        }

        .sub-menu::before {
            content: '';
            position: absolute;
            left: -3px;
            top: 0;
            bottom: 0;
            width: 3px;
            background: linear-gradient(to bottom, #007bff, #0056b3);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .sub-menu:hover::before {
            opacity: 1;
        }

        .sub-menu.drag-over {
            border-left-color: #007bff;
            background: linear-gradient(90deg, #f0f8ff 0%, transparent 100%);
            box-shadow: inset 3px 0 0 #007bff;
        }

        .menu-item.drag-over {
            background: #e3f2fd;
            border-color: #2196f3;
            transform: scale(1.02);
        }

        .sub-menu .menu-item {
            background: #fafafa;
            border-color: #e5e5e5;
        }

        /* Drag and Drop Styles */
        .ui-sortable-placeholder {
            background: linear-gradient(45deg, #f0f8ff 25%, transparent 25%, transparent 75%, #f0f8ff 75%),
                linear-gradient(45deg, #f0f8ff 25%, transparent 25%, transparent 75%, #f0f8ff 75%);
            background-size: 20px 20px;
            background-position: 0 0, 10px 10px;
            border: 2px dashed #007bff;
            border-radius: 8px;
            height: 50px;
            margin: 4px 0;
            visibility: visible !important;
            animation: pulse 1s infinite;
        }

        @keyframes pulse {
            0% {
                opacity: 0.6;
            }

            50% {
                opacity: 1;
            }

            100% {
                opacity: 0.6;
            }
        }

        .ui-sortable-helper {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            opacity: 0.9;
            transform: rotate(2deg);
            z-index: 1000;
        }

        .empty-menu-placeholder {
            text-align: center;
            padding: 3rem 2rem;
            border: 2px dashed #ddd;
            border-radius: 4px;
            color: #666;
            background: #fafafa;
        }

        .empty-menu-placeholder i {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #999;
        }

        .empty-menu-placeholder h5 {
            color: #333;
            font-weight: normal;
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }

        .empty-menu-placeholder p {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 0;
        }

        .unassigned-item {
            background: #f8f9fa;
            border: 1px dashed #dee2e6;
            margin: 5px 0;
        }

        .unassigned-item:hover {
            border-color: #007bff;
            background: #fff;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 123, 255, 0.15);
        }

        .dragging-item {
            opacity: 0.5 !important;
            transform: rotate(3deg) !important;
        }

        body.dragging {
            cursor: grabbing !important;
        }

        body.dragging * {
            cursor: grabbing !important;
        }

        .menu-item-actions .btn {
            opacity: 0;
            transition: opacity 0.2s;
        }

        .menu-item:hover .menu-item-actions .btn {
            opacity: 1;
        }

        .sortable-unassigned {
            min-height: 60px;
            padding: 15px;
            border-radius: 8px;
            border: 2px dashed #e0e0e0;
            transition: all 0.3s;
        }

        .sortable-unassigned:empty::after {
            content: 'Drag menu items here or create new ones above';
            color: #999;
            font-style: italic;
            text-align: center;
            display: block;
            padding: 20px;
        }

        .sortable-unassigned.ui-sortable-over {
            border-color: #007bff;
            background: #f8f9ff;
        }

        /* Pages Section Styles */
        .page-item {
            background: #e8f4fd;
            border: 1px solid #b3d9f2;
            cursor: grab;
        }

        .page-item:hover {
            background: #d1ecf1;
            border-color: #17a2b8;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(23, 162, 184, 0.15);
        }

        .page-item .menu-icon {
            color: #17a2b8 !important;
        }

        .sortable-pages {
            min-height: 100px;
            max-height: 300px;
            overflow-y: auto;
        }

        .empty-pages-placeholder {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            background: #f8f9fa;
        }
    </style>

     <style>
        .menu-placeholder {
            height: 50px;
            background: #f8f9fa;
            border: 2px dashed #dee2e6;
            border-radius: 4px;
            margin: 5px 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
        }

        .menu-placeholder:before {
            content: 'Drop menu item here';
            font-size: 14px;
        }

        .menu-item.ui-sortable-helper {
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transform: rotate(2deg);
        }

        .sortable-submenu {
            min-height: 40px;
            padding: 10px;
            border: 1px dashed transparent;
            border-radius: 4px;
        }

        .sortable-submenu:empty {
            border-color: #dee2e6;
            background: #f8f9fa;
        }

        .sortable-submenu:empty:after {
            content: 'Drop items here to create sub-menu';
            color: #6c757d;
            font-size: 12px;
            text-align: center;
            display: block;
            padding: 10px;
        }

        .ui-droppable-hover {
            background: #fff3cd !important;
            border-color: #ffc107 !important;
            transform: scale(1.02);
            box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);
        }

        /* Level-based styling */
        .menu-item-content.level-0 {
            background: #f8f9fa;
            border-left: 4px solid #007bff;
        }

        .menu-item-content.level-1 {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            margin-left: 20px;
        }

        .menu-item-content.level-2 {
            background: #d1ecf1;
            border-left: 4px solid #17a2b8;
            margin-left: 40px;
        }

        .menu-item-content.level-3 {
            background: #d4edda;
            border-left: 4px solid #28a745;
            margin-left: 60px;
        }
    </style>

    <div class="container-fluid">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1"><i class="fas fa-sitemap me-2"></i>{{ __('admin/form.builder_title') }}</h4>
                        <p class="text-muted mb-0">{{ __('admin/form.builder_subtitle') }}</p>
                    </div>
                    <div>
                        <span class="badge bg-success">
                            <i class="fas fa-check me-1"></i>{{ __('admin/form.auto_save') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('menu.search') }}" method="POST" class="row g-3 align-items-end">
                            @csrf
                            <div class="col-md-5">
                                <label class="form-label">{{ __('admin/form.filter_menu_location') }}</label>
                                <select name="menu_type_id" class="form-select">
                                    <option value="">{{ __('admin/form.filter_select_location') }}</option>
                                    @foreach ($menuTypes as $item)
                                        <option value="{{ $item['id'] }}"
                                            {{ $selected_menu_type_id == $item['id'] ? 'selected' : '' }}>
                                            {{ $item['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-filter me-2"></i>{{ __('admin/form.filter_load') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if ($selected_menu_type_id)
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <!-- Add New Menu Item Panel -->
                    <div class="card menu-card">
                        <div class="card-header menu-header" data-bs-toggle="collapse" data-bs-target="#addMenuForm"
                            style="cursor: pointer;">
                            <h5><i class="fas fa-plus-circle me-2"></i>{{ __('admin/form.add_menu_item') }}<i
                                    class="fas fa-chevron-down float-end"></i></h5>
                        </div>
                        <div class="collapse show" id="addMenuForm">
                            <div class="card-body">
                                <form id="add-menu-item-form" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="menu_type_id" value="{{ $selected_menu_type_id }}">

                                    <div class="mb-3">
                                        <label for="new-menu-title" class="form-label">{{ __('admin/form.title') }}</label>
                                        <input type="text" class="form-control" id="new-menu-title" name="title"
                                            placeholder="e.g., About Us" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="new-menu-url" class="form-label">{{ __('admin/form.url') }}</label>
                                        <input type="text" class="form-control" id="new-menu-url" name="url"
                                            placeholder="e.g., /about-us">
                                    </div>


                                    <div class="mb-3">
                                        <label for="new-menu-status"
                                            class="form-label">{{ __('admin/form.status') }}</label>
                                        <select class="form-select" id="new-menu-status" name="status">
                                            <option value="1" selected>{{ __('admin/form.active') }}</option>
                                            <option value="0">{{ __('admin/form.inactive') }}</option>
                                        </select>
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>{{ __('admin/form.add_button') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Pages Section -->
                    <div class="card menu-card mt-4">
                        <div class="card-header menu-header" data-bs-toggle="collapse" data-bs-target="#pagesSection"
                            style="cursor: pointer;">
                            <h5><i class="fas fa-file-alt me-2"></i>Available Pages<i
                                    class="fas fa-chevron-down float-end"></i></h5>
                        </div>
                        <div class="collapse show" id="pagesSection">
                            <div class="card-body">
                                <p class="text-muted small mb-3">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Drag pages to the menu structure to create menu items automatically.
                                </p>
                                <div id="pages-container" class="sortable-pages">
                                    @if(isset($pages) && $pages->count() > 0)
                                        @foreach($pages as $page)
                                            <div class="page-item menu-item"
                                                 data-page-id="{{ $page->id }}"
                                                 data-page-title="{{ htmlspecialchars($page->title, ENT_QUOTES, 'UTF-8') }}"
                                                 data-page-slug="{{ $page->slug ?? '' }}">
                                                <div class="menu-item-content">
                                                    <div class="menu-item-title">
                                                        <span class="drag-handle">
                                                            <i class="fas fa-grip-vertical"></i>
                                                        </span>
                                                        <i class="fas fa-file-alt menu-icon text-info"></i>
                                                        <span class="menu-item-title-text">{{ $page->title }}</span>
                                                        @if($page->slug)
                                                            <small class="text-muted">({{ $page->slug }})</small>
                                                        @endif
                                                    </div>
                                                    <div class="menu-item-actions">
                                                        <span class="badge bg-light text-dark">Page</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="empty-pages-placeholder text-center py-4">
                                            <i class="fas fa-file-alt fa-2x text-muted mb-2"></i>
                                            <p class="text-muted mb-0">No pages available</p>
                                            <small class="text-muted">Create pages first to add them to menu</small>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <!-- Menu Structure Panel -->
                    <div class="card menu-card">
                        <div class="card-header menu-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5><i class="fas fa-bars me-2"></i>{{ __('admin/form.menu_structure') }}</h5>
                                <small>{{ __('admin/form.total_items') }}: <span
                                        class="badge bg-light text-dark">{{ isset($menus) ? $menus->count() : 0 }}</span></small>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="menu-container" class="sortable-menu">
                                @if (isset($menus) && $menus->count() > 0)
                                    @foreach ($menus->where('parent_id', null) as $menu)
                                        @include('publication::admin.menu.menu_item', [
                                            'menu' => $menu,
                                            'level' => 0,
                                        ])
                                    @endforeach
                                @else
                                    <div class="empty-menu-placeholder">
                                        <i class="fas fa-sitemap"></i>
                                        <h5>{{ __('admin/form.empty_structure') }}</h5>
                                        <p>{{ __('admin/form.empty_tip') }}</p>
                                        <small class="text-muted mt-2 d-block">
                                            <i class="fas fa-lightbulb me-1"></i>
                                            {{ __('admin/form.hint') }}
                                        </small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">{{ __('admin/form.no_menu_loaded') }}</h5>
                        <p class="text-muted">{{ __('admin/form.select_sector_location') }}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>


@endsection

@push('scripts')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).ready(function() {

            const saveButton = $('#saveMenuOrder');
            const menuContainer = $('#menu-container');

            // --- Helper Functions ---
            let saveTimeout;

            // Initialize sortable functionality
            function initializeSortable() {
                // Function to get container level
                function getContainerLevel(container) {
                    if (container.attr('id') === 'menu-container') return 0;
                    let level = 0;
                    let parent = container.closest('.menu-item');
                    while (parent.length > 0) {
                        level++;
                        parent = parent.parent().closest('.menu-item');
                    }
                    return level;
                }

                // Make all containers sortable
                function makeSortable(selector) {
                    $(selector).sortable({
                        items: '> .menu-item',
                        handle: '.drag-handle',
                        placeholder: 'menu-placeholder',
                        tolerance: 'pointer',
                        connectWith: '.sortable-submenu, #menu-container',
                        receive: function(event, ui) {
                            const draggedItem = ui.item;
                            const targetContainer = $(this);
                            const targetLevel = getContainerLevel(targetContainer);

                            // Allow up to 4 levels (0, 1, 2, 3)
                            if (targetLevel >= 4) {
                                $(this).sortable('cancel');
                                toastr.error('Maximum 4 levels allowed', 'Invalid Action');
                                return false;
                            }

                            // Update level and visual indicators
                            updateItemLevel(draggedItem, targetLevel);

                            // Re-initialize sortable for any new containers
                            setTimeout(() => {
                                initializeSortable();
                            }, 100);
                        },
                        update: function(event, ui) {
                            autoSaveMenuOrder();
                        }
                    });
                }

                // Initialize main container and all sub-containers
                makeSortable('#menu-container');
                makeSortable('.sortable-submenu');

                // Make menu items droppable to create nested structure
                $('.menu-item').droppable({
                    accept: '.menu-item',
                    tolerance: 'pointer',
                    hoverClass: 'ui-droppable-hover',
                    drop: function(event, ui) {
                        const droppedItem = ui.draggable;
                        const targetItem = $(this);
                        const targetId = targetItem.data('id');

                        // Don't allow dropping on itself
                        if (droppedItem.data('id') === targetId) return;

                        // Create or find submenu container
                        let submenu = targetItem.find('> .sub-menu');
                        if (submenu.length === 0) {
                            submenu = $(`<div class="sub-menu sortable-submenu" data-parent-id="${targetId}"></div>`);
                            targetItem.append(submenu);
                            makeSortable(submenu);
                        }

                        // Move item to submenu
                        droppedItem.detach().appendTo(submenu);

                        // Update parent relationship
                        updateParentId(droppedItem, targetId);
                        updateItemLevel(droppedItem, 1);

                        autoSaveMenuOrder();
                    }
                });
            }

            // Update parent_id via AJAX
            const updateParentId = (item, parentId) => {
                const menuId = item.data('id');
                if (!menuId) return;

                $.ajax({
                    url: '{{ route('menu.update', ':id') }}'.replace(':id', menuId),
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'PUT',
                        parent_id: parentId,
                        menu_type_id: '{{ $selected_menu_type_id }}'
                    },
                    success: function(response) {
                        console.log('Parent updated successfully');
                    },
                    error: function() {
                        toastr.error('Failed to update menu structure', 'Error');
                    }
                });
            };

            // Update item level and all its children recursively
            function updateItemLevel(menuItem, newLevel) {
                menuItem.attr('data-level', newLevel).data('level', newLevel);
                updateMenuItemVisuals(menuItem, newLevel);

                // Update all children recursively
                menuItem.find('.sortable-submenu > .menu-item').each(function() {
                    updateItemLevel($(this), newLevel + 1);
                });
            }

            // Update menu item visual indicators based on level
            function updateMenuItemVisuals(menuItem, level) {
                const icon = menuItem.find('> .menu-item-content .menu-icon');
                const content = menuItem.find('> .menu-item-content');

                // Remove existing level classes
                content.removeClass('level-0 level-1 level-2 level-3');

                // Add new level class
                content.addClass('level-' + level);

                // Update icon based on level
                icon.removeClass(
                    'fa-folder fa-file fa-sitemap fa-list text-primary text-warning text-info text-success');

                switch (level) {
                    case 0:
                        icon.addClass('fa-folder text-primary');
                        break;
                    case 1:
                        icon.addClass('fa-file text-warning');
                        break;
                    case 2:
                        icon.addClass('fa-sitemap text-info');
                        break;
                    case 3:
                        icon.addClass('fa-list text-success');
                        break;
                }
            }

            // Initialize on page load
            initializeSortable();

            // Make pages sortable
            $('#pages-container').sortable({
                items: '> .page-item',
                handle: '.drag-handle',
                helper: 'clone',
                connectWith: '#menu-container, .sortable-submenu',
                tolerance: 'pointer',
                cursor: 'grabbing',
                opacity: 0.8
            });

            // Make menu container accept pages
            $('#menu-container').droppable({
                accept: '.page-item',
                tolerance: 'pointer',
                drop: function(event, ui) {
                    if (ui.draggable.hasClass('page-item')) {
                        createMenuFromPage(ui.draggable, null);
                    }
                }
            });

            // Update droppable to accept pages
            $('.menu-item').droppable('option', 'accept', '.menu-item, .page-item');
            $('.menu-item').on('drop', function(event, ui) {
                if (ui.draggable.hasClass('page-item')) {
                    const targetId = $(this).data('id');
                    createMenuFromPage(ui.draggable, targetId);
                }
            });

            const autoSaveMenuOrder = () => {
                clearTimeout(saveTimeout);
                saveTimeout = setTimeout(() => {
                    const menuOrder = [];

                    function processMenuItems(container, parentId = null) {
                        let position = 1;
                        container.children('.menu-item').each(function() {
                            const menuId = $(this).data('id');

                            menuOrder.push({
                                id: menuId,
                                parent_id: parentId,
                                position: position++
                            });

                            const subContainer = $(this).find('> .sub-menu');
                            if (subContainer.length > 0) {
                                processMenuItems(subContainer, menuId);
                            }
                        });
                    }

                    processMenuItems($('#menu-container'));

                    $.ajax({
                        url: '{{ route('menu.updateOrder') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            menuOrder: JSON.stringify(menuOrder)
                        },
                        success: function(response) {
                            console.log('Menu order saved');
                        },
                        error: function() {
                            console.log('Failed to save menu order');
                        }
                    });
                }, 500);
            };

            // Create menu item from page
            const createMenuFromPage = (pageItem, parentId) => {
                const pageId = pageItem.data('page-id');
                let pageTitle = pageItem.data('page-title');

                if (!pageTitle) {
                    pageTitle = pageItem.find('.menu-item-title-text').text().trim();
                }

                const pageSlug = pageItem.data('page-slug') || pageTitle;

                if (!pageTitle) {
                    toastr.error('Page title not found', 'Error');
                    return;
                }

                $.ajax({
                    url: '{{ route('menu.store') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        title: pageTitle,
                        url: '',
                        slug: pageSlug,
                        page_id: pageId,
                        parent_id: parentId,
                        menu_type_id: '{{ $selected_menu_type_id }}',
                        status: 1,
                        position: 1,
                        is_display_web: 1
                    },
                    success: function(response) {
                        toastr.success(`Menu item created for "${pageTitle}"`, 'Success');
                        setTimeout(() => location.reload(), 1000);
                    },
                    error: function(xhr) {
                        toastr.error('Failed to create menu item from page', 'Error');
                        console.error(xhr.responseJSON);
                    }
                });
            };


            // Add visual feedback for better UX
            $(document).on('mouseenter', '.menu-item', function() {
                $(this).addClass('menu-item-hover');
            }).on('mouseleave', '.menu-item', function() {
                $(this).removeClass('menu-item-hover');
            });

            // Show helpful tooltips
            $('.drag-handle').attr('title', 'Drag to reorder or nest menu items');
            $('.menu-item').attr('title', 'Drop other items here to create sub-menus');

            // Auto-save is now handled in the autoSaveMenuOrder function

            // 3. Edit Menu Item (Use Add Form)
            let isEditMode = false;
            let editingMenuId = null;

            $(document).on('click', '.edit-menu-btn', function() {
                debugger;
                const button = $(this);
                const menuId = button.data('id');

                // Switch to edit mode
                isEditMode = true;
                editingMenuId = menuId;

                // Open the Add Menu form
                $('#addMenuForm').collapse('show');

                // Populate form fields
                $('#new-menu-title').val(button.data('title'));
                $('#new-menu-url').val(button.data('url'));
                $('#new_menu_icon').val(button.data('menu-icon'));
                $('#new-menu-status').val(button.data('status'));
                $('#new-menu-position').val(button.data('position'));
                $('#new-menu-themetic').val(button.data('is-thematic')).trigger('change');

                // Change form title and button text
                $('.card-header h5').html(
                    '<i class="fas fa-edit me-2"></i>Edit Menu Item <i class="fas fa-chevron-down float-end"></i>'
                    );
                $('#add-menu-item-form button[type="submit"]').html(
                    '<i class="fas fa-save me-2"></i>Update Menu Item');

                // Scroll to form
                $('#addMenuForm')[0].scrollIntoView({
                    behavior: 'smooth'
                });
            });

            // Reset form to add mode
            const resetFormToAddMode = () => {
                isEditMode = false;
                editingMenuId = null;
                $('.card-header h5').html(
                    '<i class="fas fa-plus-circle me-2"></i>Add Menu Item <i class="fas fa-chevron-down float-end"></i>'
                    );
                $('#add-menu-item-form button[type="submit"]').html(
                    '<i class="fas fa-plus me-2"></i>Add Menu Item');
                $('#add-menu-item-form')[0].reset();
            };

            // 4. Delete Menu Item
            $(document).on('click', '.delete-menu-btn', function() {
                const menuId = $(this).data('id');
                const menuTitle = $(this).closest('.menu-item').find('.menu-item-title-text').text();

                Swal.fire({
                    title: 'Are you sure?',
                    text: `You are about to delete "${menuTitle}". This cannot be undone!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('menu.destroy', ':id') }}'.replace(':id',
                                menuId),
                            method: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                $(`.menu-item[data-id="${menuId}"]`).fadeOut(300,
                                    function() {
                                        $(this).remove();
                                        autoSaveMenuOrder();
                                    });
                                toastr.success('Menu item deleted.', 'Deleted');
                            },
                            error: function() {
                                toastr.error('Failed to delete menu item.', 'Error');
                            }
                        });
                    }
                });
            });

            // 5. Add/Edit Menu Item (Enhanced Form)
            $('#add-menu-item-form').on('submit', function(e) {
                e.preventDefault();

                const form = $(this);
                const submitBtn = form.find('button[type="submit"]');

                // Prevent double submission
                if (submitBtn.prop('disabled')) {
                    return false;
                }

                // Disable submit button
                const loadingText = isEditMode ?
                    '<i class="fas fa-spinner fa-spin me-2"></i>Updating...' :
                    '<i class="fas fa-spinner fa-spin me-2"></i>Adding...';
                submitBtn.prop('disabled', true).html(loadingText);

                const formData = new FormData(this);

                // Determine URL and method based on mode
                let url, method;
                if (isEditMode) {
                    url = '{{ route('menu.update', ':id') }}'.replace(':id', editingMenuId);
                    method = 'POST';
                    formData.append('_method', 'PUT');
                } else {
                    url = '{{ route('menu.store') }}';
                    method = 'POST';
                }

                $.ajax({
                    url: url,
                    method: method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        const successMsg = isEditMode ? 'Menu item updated successfully!' :
                            'Menu item added successfully!';
                        toastr.success(successMsg, 'Success');

                        // Reset form and close accordion
                        resetFormToAddMode();
                        $('#addMenuForm').collapse('hide');

                        // Reload page to show changes
                        setTimeout(() => location.reload(), 1000);
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON?.errors;
                        let errorMsg = isEditMode ? 'Failed to update menu item.' :
                            'Failed to add menu item.';
                        if (errors) {
                            errorMsg = Object.values(errors).flat().join('<br>');
                        }
                        toastr.error(errorMsg, 'Error');
                    },
                    complete: function() {
                        // Re-enable submit button
                        const defaultText = isEditMode ?
                            '<i class="fas fa-save me-2"></i>Update Menu Item' :
                            '<i class="fas fa-plus me-2"></i>Add Menu Item';
                        submitBtn.prop('disabled', false).html(defaultText);
                    }
                });
            });

            // Add cancel button functionality for edit mode
            $(document).on('click', '.cancel-edit-btn', function() {
                resetFormToAddMode();
                $('#addMenuForm').collapse('hide');
            });
        });
    </script>
@endpush

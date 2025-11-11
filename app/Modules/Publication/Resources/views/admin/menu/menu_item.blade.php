<div class="menu-item" data-id="{{ $menu->id }}" data-level="{{ $level }}" data-parent-id="{{ $menu->parent_id }}">
    <div class="menu-item-content">
        <div class="menu-item-title">
            <i class="fas fa-grip-vertical drag-handle"></i>
            <i class="fas {{ $level == 0 ? 'fa-folder text-primary' : 'fa-file text-warning' }} menu-icon"></i>
            <span class="menu-item-title-text">{{ $menu->title }}</span>
            @if($menu->url)
                <small class="text-muted">({{ $menu->url }})</small>
            @endif
            @if($menu->is_mega_menu)
                <span class="badge bg-info ms-2">Mega</span>
            @endif
        </div>

        <div class="menu-item-type">
            {{ $menu->status ? 'Active' : 'Inactive' }}
            @if($menu->image)
                <i class="fas fa-image text-success ms-2" title="Has Image"></i>
            @endif
        </div>

        <div class="menu-item-actions">
            <button class="btn btn-sm btn-outline-secondary p-1 edit-menu-btn" title="Edit"
                    data-id="{{ $menu->id }}"
                    data-title="{{ $menu->title }}"
                    data-url="{{ $menu->url }}"
                    data-menu-icon="{{ $menu->menu_icon }}"
                    data-status="{{ $menu->status }}"
                    data-position="{{ $menu->position }}"
                    data-page-id="{{ $menu->page_id }}"
                    data-is-thematic="{{ $menu->is_thematic }}"
                    >
                <i class="fas fa-pencil-alt"></i>
            </button>
            <button class="btn btn-sm btn-outline-danger p-1 delete-menu-btn" title="Delete"
                    data-id="{{ $menu->id }}">
                <i class="fas fa-trash-alt"></i>
            </button>
        </div>
    </div>

    @if($menu->children->isNotEmpty())
    <div class="sub-menu sortable-submenu" data-parent-id="{{ $menu->id }}">
        @foreach($menu->children as $child)
            @include('publication::admin.menu.menu_item', ['menu' => $child, 'level' => $level + 1])
        @endforeach
    </div>
    @else
    <div class="sub-menu sortable-submenu" data-parent-id="{{ $menu->id }}">
        {{-- This container is necessary for dropping items to create a new sub-menu --}}
    </div>
    @endif
</div>

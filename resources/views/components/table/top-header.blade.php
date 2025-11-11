<div class="amd-soft-table-header {{ $class ?? '' }}">
    <h4 class="amd-soft-table-title">{{ $title ?? 'List' }}</h4>

    <div class="amd-soft-header-right">
        {{-- 👇 Show dashboard button if enabled --}}
        @if($isDashboard)
            <button class="amd-btn amd-btn-light amd-btn-sm me-2" id="dashboardBtnForToggleDashboard" type="button">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </button>
        @endif

        {{-- 👇 Show search button if enabled --}}
        @if($isSearch)
            <button class="amd-btn amd-btn-light amd-btn-sm me-2" id="searchBtnForToggleForm" type="button">
                <i class="fas fa-search"></i> 
            </button>
        @endif

        {{-- 👇 Column button --}}
        @if ($column)
            <button class="amd-btn amd-btn-secondary amd-btn-sm me-2 columnsBtn" type="button" data-table-id="{{ $tableId }}">
                <i class="fas fa-columns"></i> 
                {{ $columnLabel }}
            </button>
        @endif

        {{-- 👇 Create button --}}
        @if (isset($createRoute))
            <a href="{{ $createRoute }}" class="amd-btn amd-btn-primary amd-btn-sm">
                <i class="fa-solid fa-plus"></i> {{ $createLabel ?? 'Add New' }}
            </a>
        @endif
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Column manager functionality
            document.querySelectorAll('.columnsBtn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const tableId = this.dataset.tableId;
                    if (tableId && typeof openColumnModal === 'function') {
                        openColumnModal(tableId);
                    } else {
                        console.warn('Table ID not found or openColumnModal not defined');
                    }
                });
            });
        });

    </script>
@endpush

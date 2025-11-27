<div class="amd-manage-column-overlay" id="columnModal" style="display:none;">
    <div class="amd-manage-column-modal">
        <div class="amd-manage-column-header">
            <h3 class="amd-manage-column-title">Manage Columns</h3>
            <button type="button" class="amd-manage-column-close" onclick="closeColumnModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="amd-manage-column-body">
            <p style="color: #6b7280; font-size: 14px; margin-bottom: 16px;">
                Drag and drop to reorder columns. Uncheck to hide columns.
            </p>
            <ul class="amd-manage-column-list" id="columnList">
                {{-- JS will dynamically generate column items here --}}
            </ul>
        </div>
        <div class="amd-manage-column-footer">
            <button type="button" class="amd-manage-column-reset-btn" onclick="resetColumns()">
                Reset to Default
            </button>
            <div class="amd-manage-column-actions">
                <button type="button" class="amd-manage-column-btn secondary" onclick="closeColumnModal()">
                    Cancel
                </button>
                <button type="button" class="amd-manage-column-btn primary" onclick="applyColumnChanges()">
                    Apply Changes
                </button>
            </div>
        </div>
    </div>
</div>

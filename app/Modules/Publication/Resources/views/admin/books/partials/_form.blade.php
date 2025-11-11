<form class="row g-4"
    action="{{ isset($data['record']->id) ? route('books.update', $data['record']->id) : route('books.store') }}"
    method="POST" enctype="multipart/form-data">
    @csrf
    @isset($data['record']->id)
        @method('PUT')
    @endisset

    <!-- Main Content Area -->
    <div class="col-8">

        <!-- Category Section Section -->
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0">Category Information</h5>
            </div>
            <div class="card-body">
           <x-form.select-input :id="'category_id'" :label="'Category Type'" :name="'category_id'" :options="$data['bookCategories']->pluck('name', 'id')"
                    :value="old('category_id', $data['record']->category_id ?? '')" />
            </div>
        </div>

        {{-- Title Section --}}
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0">Book Information</h5>
            </div>
            <div class="card-body">
                <x-form.text-input :id="'title'" :label="'Title'" :name="'title'" :value="old('title', $data['record']->title ?? '')" />
            </div>
        </div>

        <!-- Content Editor -->
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0">Content</h5>
            </div>
            <div class="card-body">
                <x-form.textarea :id="'content'" :editor="true" :label="''" :name="'content'"
                    :value="old('content', $data['record']->content ?? '')" />
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-4">
        <!-- Publish Box -->
        @isset($data['record']->id)
            <div class="card mb-4 border-primary">
                <div class="card-header amd-bg-primary text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-paper-plane me-2"></i>Publish
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <x-form.select-input :id="'status'" :label="'Status'" :name="'status'" :options="['active' => 'Published', 'inactive' => 'Draft']"
                            :value="(string) old('status', $data['record']->status ?? 'active')" />
                    </div>
                </div>
            </div>
        @endisset
        <!-- Featured Image -->
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h6 class="card-title mb-0">
                    <i class="fas fa-image me-2"></i>Featured Image
                </h6>
            </div>
            <div class="card-body">
                <x-form.file-upload :id="'thumbnail_image'" :label="''" :name="'thumbnail_image'" :value="isset($data['record']) ? $data['record']->getMediaUrl('thumbnail_image') : null" />
                @isset($data['record']->id)
                    <small class="form-text text-muted">Leave blank to keep current image</small>
                @endisset
            </div>
        </div>

        <!-- PDF File -->
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h6 class="card-title mb-0">
                    <i class="fas fa-file-pdf me-2 text-danger"></i>PDF File
                </h6>
            </div>
            <div class="card-body">
                <x-form.file-upload :id="'pdfFile'" :label="''" :name="'pdf_file'" :value="isset($data['record']) ? $data['record']->getMediaUrl('pdf_file') : null" />
                @isset($data['record']->id)
                    <small class="form-text text-muted">Leave blank to keep current PDF</small>
                @endisset
            </div>
        </div>
        {{-- Page Allowed Publication --}}
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h6 class="card-title mb-0">
                    <i class="fas fa-file-pdf me-2 text-danger"></i>Allowed Public Pages
                </h6>
            </div>
            <div class="card-body">
                <x-form.text-input :id="'public_pdf_pages'" :label="''" :name="'public_pdf_pages'" :value="old('public_pdf_pages', $data['record']->public_pdf_pages ?? '')" />
            </div>
        </div>

           <div class="card">
            <div class="card-header bg-light">
                <h6 class="card-title mb-0">
                    <i class="fas fa-file-pdf me-2 text-danger"></i>highlights
                </h6>
            </div>
            <div class="card-body">
                <x-form.select-input :id="'highlights'" :label="'Highlight Type'" :name="'highlights'" :options="array_column($data['highlights'], 'name', 'id')"
                    :value="old('highlights', $data['record']->highlights ?? 'normal')" />
            </div>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-end">
        <x-form.submit-button :label="'Submit'" />
        <a href="{{ route('books.index') }}" class="btn btn-secondary btn-sm ms-2">Cancel</a>
    </div>

</form>


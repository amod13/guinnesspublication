<form class="row g-4"
    action="{{ isset($data['record']->id) ? route('about-us.update', $data['record']->id) : route('about-us.store') }}"
    method="POST" enctype="multipart/form-data">
    @csrf
    @isset($data['record']->id)
        @method('PUT')
    @endisset

    <!-- Main Content Area -->
    <div class="col-8">
        {{-- Title Section --}}
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0">About Us Information</h5>
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
                <x-form.textarea :id="'description'" :editor="true" :label="''" :name="'description'"
                    :value="old('description', $data['record']->description ?? '')" />
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
                            :value="old('status', $data['record']->status ?? 'active')" />
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
              <div class="col-12 mb-3">
        <x-form.file-upload :id="'image_media_id'" :label="'Thumbnail Image'" :name="'image_media_id'" :value="isset($data['record']) ? $data['record']->getMediaUrl('image_media_id') : null" />
        @isset($data['record']->id)
            <small class="form-text text-muted">Leave blank to keep the current image.</small>
        @endisset
    </div>
            </div>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-end">
        <x-form.submit-button :label="'Submit'" />
        <a href="{{ route('about-us.index') }}" class="btn btn-secondary btn-sm ms-2">Cancel</a>
    </div>

</form>



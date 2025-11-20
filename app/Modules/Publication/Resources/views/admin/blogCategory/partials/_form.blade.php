<form class="row g-3"
    action="{{ isset($data['record']->id) ? route('blog-category.update', $data['record']->id) : route('blog-category.store') }}"
    method="POST" enctype="multipart/form-data">
    @csrf
    @isset($data['record']->id)
        @method('PUT')
    @endisset

    <div class="col-md-6 mb-3">
        <x-form.text-input :id="'title'" :label="'Title'" :name="'title'" :value="old('title', $data['record']->title ?? '')" />
    </div>

    <div class="col-md-6 mb-3">
        <x-form.select-input :id="'parent_id'" :label="'Parent Category'" :name="'parent_id'" 
            :options="$data['parentCategories']->pluck('title', 'id')->toArray()" 
            :value="old('parent_id', $data['record']->parent_id ?? '')" />
    </div>


    @isset($data['record']->id)
        <div class="col-md-6 mb-3">
            <x-form.select-input :id="'status'" :label="'Status'" :name="'status'" :options="['1' => 'Active', '0' => 'Inactive']"
                :value="(string) old('status', $data['record']->status ?? '1')" />
        </div>
    @endisset

    <div class="col-12">
        <x-form.file-upload :id="'thumbnail_image'" :label="'Thumbnail Image'" :name="'thumbnail_image'" :value="isset($data['record']) ? $data['record']->getMediaUrl('thumbnail_image') : null" />
        <small class="form-text text-muted">Leave blank to keep the current image.</small>
    </div>

    <div class="col-12 col-lg-12 button_submit pt-20 d-flex justify-content-end">
        <x-form.submit-button :label="'Submit'" />
    </div>

</form>
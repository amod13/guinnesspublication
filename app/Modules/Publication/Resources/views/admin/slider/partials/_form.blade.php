<form class="row g-3"
    action="{{ isset($data['record']->id) ? route('slider.update', $data['record']->id) : route('slider.store') }}"
    method="POST" enctype="multipart/form-data">
    @csrf
    @isset($data['record']->id)
        @method('PUT')
    @endisset

    <div class="col-md-12 mb-3">
        <x-form.text-input :id="'title'" :label="'Title'" :name="'title'" :value="old('title', $data['record']->title ?? '')" />
    </div>

    <div class="col-md-12 mb-3">
        <x-form.textarea :id="'description'" :label="'Description'" :name="'description'" :value="old('description', $data['record']->description ?? '')" />
    </div>

    @isset($data['record']->id)
        <div class="col-md-12 mb-3">
            <x-form.select-input :id="'status'" :label="'Status'" :name="'status'" :options="['1' => 'Active', '0' => 'Inactive']"
                :value="(string) old('status', $data['record']->status ?? '1')" />
        </div>
    @endisset

    <div class="col-4">
        <x-form.file-upload :id="'background_image'" :label="'First Featured Image'" :name="'background_image'" :value="isset($data['record']) ? $data['record']->getMediaUrl('background_image') : null" />
        <small class="form-text text-muted">Leave blank to keep the current image.</small>
    </div>

    <div class="col-4">
        <x-form.file-upload :id="'background_image_1'" :label="'Second Featured Image'" :name="'background_image_1'" :value="isset($data['record']) ? $data['record']->getMediaUrl('background_image_1') : null" />
        <small class="form-text text-muted">Leave blank to keep the current image.</small>
    </div>

    <div class="col-4">
        <x-form.file-upload :id="'background_image_2'" :label="'Third Featured Image'" :name="'background_image_2'" :value="isset($data['record']) ? $data['record']->getMediaUrl('background_image_2') : null" />
        <small class="form-text text-muted">Leave blank to keep the current image.</small>
    </div>

    <div class="col-12 col-lg-12 button_submit pt-20 d-flex justify-content-end">
        <x-form.submit-button :label="'Submit'" />
    </div>

</form>

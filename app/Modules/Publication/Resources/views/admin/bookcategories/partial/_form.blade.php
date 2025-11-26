<form
    action="{{ isset($data['record']->id) ? route('bookcategories.update', $data['record']->id) : route('bookcategories.store') }}"
    method="POST">
    @csrf
    @if (isset($data['record']->id))
        @method('PUT')
    @endif

    <div class="row">
        <div class="col-md-12 mb-3">
            <x-form.text-input name="name" label="Name" :value="old('name', $data['record']->name ?? '')" required />
        </div>

        <div class="col-md-12 mb-3">
          <x-form.select-input :id="'parent_id'" :label="'Parent Category'" :name="'parent_id'" :options="$data['parents']->pluck('name', 'id')"
                    :value="old('parent_id', $data['record']->parent_id ?? '')" />
        </div>

        <div class="col-md-12 mb-3">
            <x-form.file-upload :id="'thumbnail_image'" :label="''" :name="'thumbnail_image'" :value="isset($data['record']) ? $data['record']->getMediaUrl('thumbnail_image') : null" />
            @isset($data['record']->id)
                <small class="form-text text-muted">Leave blank to keep current image</small>
            @endisset
        </div>


        @isset($data['record']->id)
            <div class="col-md-12 mb-3">
                <x-form.select-input name="status" label="Status" :options="[
                    'active' => 'Active',
                    'inactive' => 'Inactive',
                ]" :value="old('status', $data['record']->status ?? 'active')" required />
            </div>
        @endisset

    </div>

    <div class="mt-4 d-flex justify-content-end">
        <x-form.submit-button :text="isset($data['record']->id) ? 'Update BookCategories' : 'Create BookCategories'" />
        <a href="{{ route('bookcategories.index') }}" class="btn btn-secondary btn-sm ms-2">Cancel</a>
    </div>
</form>

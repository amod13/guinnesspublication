<form action="{{ isset($data['record']->id) ? route('authors.update', $data['record']->id) : route('authors.store') }}"
    method="POST">
    @csrf
    @if (isset($data['record']->id))
        @method('PUT')
    @endif


    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <x-form.text-input name="name" label="Author Name" :value="old('name', $data['record']->name ?? '')" :required="true" />
                </div>

                <div class="col-md-6 mb-3">
                    <x-form.email-input name="email" label="Email Address" :value="old('email', $data['record']->email ?? '')" />
                </div>

                <div class="col-md-6 mb-3">
                    <x-form.text-input name="address" label="Address" :value="old('address', $data['record']->address ?? '')" />
                </div>

                <div class="col-md-12 mb-3">
                    <x-form.file-upload :id="'image'" :label="''" :name="'image'" :value="isset($data['record']) ? $data['record']->getMediaUrl('image') : null" />
                    @isset($data['record']->id)
                        <small class="form-text text-muted">Leave blank to keep current image</small>
                    @endisset
                </div>

                @isset($data['record']->id)
                    <div class="col-md-6 mb-3">
                        <x-form.select-input name="status" label="Status" :options="[
                            'active' => 'Active',
                            'inactive' => 'Inactive',
                        ]" :value="old('status', $data['record']->status ?? 'active')" />
                    </div>
                @endisset

                <div class="col-md-12 mb-3">
                    <x-form.textarea name="content" :editor="true" label="Bio/Content" :value="old('content', $data['record']->content ?? '')" />
                </div>
            </div>
        </div>
    </div>




    <div class="mt-4 d-flex justify-content-end">
        <a href="{{ route('authors.index') }}" class="amd-btn amd-btn-danger amd-btn-sm mt-2 ">Cancel</a>
        <x-form.submit-button :text="isset($data['record']->id) ? 'Update Author' : 'Create Author'" :class="' ms-2'" />

    </div>
</form>

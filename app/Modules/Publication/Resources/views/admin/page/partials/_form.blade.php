<form class="row g-3"
    action="{{ isset($data['record']->id) ? route('page.update', $data['record']->id) : route('page.store') }}"
    method="POST" enctype="multipart/form-data">
    @csrf
    @isset($data['record']->id)
        @method('PUT')
    @endisset

    <div class="col-lg-8">
        {{-- Card for Main Content and Details --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header amd-bg-primary text-white">
                <h5 class="mb-0">Page Details</h5>
            </div>
            <div class="card-body">
                <div class="row">

                    {{-- Title Input --}}
                    <div class="col-md-12 mb-3">
                        <x-form.text-input :id="'title'" :label="'Title'" :name="'title'" :value="old('title', $data['record']->title ?? '')" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        {{-- Card for Media Uploads --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header amd-bg-primary text-white">
                <h5 class="mb-0">Page Status</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    {{-- Status Select (Only for Edit) --}}
                    <div class="col-md-12 mb-3">
                        <x-form.select-input :id="'status'" :label="'Status'" :name="'status'" :options="['1' => 'Publish', '0' => 'Draft']"
                            :value="(string) old('status', $data['record']->status ?? '1')" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        {{-- Card for Content Editor --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">Content Body</h5>
            </div>
            <div class="card-body">
                <div class="col-12">
                    <x-form.textarea :id="'content'" :editor="true" :label="'Content'" :name="'content'"
                        :value="old('content', $data['record']->content ?? '')" :rows="10" />
                </div>
            </div>
        </div>
</div>
    {{-- Submit Button --}}
    <div class="col-12 d-flex justify-content-end pt-3">
        <x-form.submit-button :label="'Save Page'" class="btn btn-success btn-lg" />
    </div>

</form>

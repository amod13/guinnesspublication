<form class="row g-3"
    action="{{ isset($data['record']->id) ? route('role.update', $data['record']->id) : route('role.store') }}"
    method="POST" enctype="multipart/form-data">
    @csrf
    @isset($data['record']->id)
        @method('PUT')
    @endisset

    <div class="col-md-6 mb-3">
        <x-form.text-input :id="'name'" :label="'Name'" :name="'name'" :value="old('name', $data['record']->name ?? '')" />
    </div>


    <div class="col-md-6 mb-3">
        <x-form.select-input :id="'is_superadmin'" :label="'Is Superadmin'" :name="'is_superadmin'" :options="['1' => 'Yes', '0' => 'No']"
            :value="old('is_superadmin', $data['record']->is_superadmin ?? '0')" />
    </div>

    <div class="col-12 col-lg-12 button_submit pt-20 d-flex justify-content-end">
        <x-form.submit-button :label="'Submit'" />
    </div>
    
</form>

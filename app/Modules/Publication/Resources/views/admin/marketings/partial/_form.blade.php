<form
    action="{{ isset($data['record']->id) ? route('marketings.update', $data['record']->id) : route('marketings.store') }}"
    method="POST">
    @csrf
    @if (isset($data['record']->id))
        @method('PUT')
    @endif

    <div class="row">
        <div class="col-md-6">
            <x-form.text-input name="school_name" label="Name" :value="old('school_name', $data['record']->school_name ?? '')" />
        </div>
        <div class="col-md-6">
            <x-form.text-input name="school_address" label="Address" :value="old('school_address', $data['record']->school_address ?? '')" />
        </div>
        <div class="col-md-6">
            <x-form.number-input name="school_phone" label="Phone Number" :value="old('school_phone', $data['record']->school_phone ?? '')" />
        </div>
        <div class="col-md-6">
            <x-form.email-input name="school_email" label="Email" :value="old('school_email', $data['record']->school_email ?? '')" />
        </div>
        <div class="col-md-6">
            <x-form.date-input name="visit_date" label="Visit Date" :value="old('visit_date', $data['record']->visit_date ?? '')" />
        </div>

        @isset($data['record']->id)
            <div class="col-md-6">
                <x-form.select-input name="status" label="Status" :options="[
                    'active' => 'Active',
                    'inactive' => 'Inactive',
                ]" :value="old('status', $data['record']->status ?? 'active')" required />
            </div>
        @endisset

        <div class="col-md-12">
            <x-form.textarea name="remarks" label="Remarks" :value="old('remarks', $data['record']->remarks ?? '')" />
        </div>

    </div>

    <div class="mt-4 mt-4 d-flex justify-content-end">
        <x-form.submit-button :text="isset($data['record']->id) ? 'Update Marketings' : 'Create Marketings'" :class="'ms-2'" />
        <a href="{{ route('marketings.index') }}" class="btn btn-secondary btn-sm ms-2">Cancel</a>
    </div>
</form>

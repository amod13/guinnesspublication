<form action="{{ isset($data['record']->id) ? route('dealers.update', $data['record']->id) : route('dealers.store') }}"
    method="POST">
    @csrf
    @if (isset($data['record']->id))
        @method('PUT')
    @endif

    <!-- Tab Navigation -->
    <ul class="nav nav-tabs mb-4" id="dealerTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="dealer-info-tab" data-bs-toggle="tab" data-bs-target="#dealer-info" type="button" role="tab">
                <i class="fas fa-store me-2"></i>Dealer Information
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="user-account-tab" data-bs-toggle="tab" data-bs-target="#user-account" type="button" role="tab">
                <i class="fas fa-user-plus me-2"></i>User Account
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="dealerTabsContent">
        <!-- Dealer Information Tab -->
        <div class="tab-pane fade show active" id="dealer-info" role="tabpanel">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-store me-2"></i>Dealer Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <x-form.text-input name="name" label="Dealer Name" :value="old('name', $data['record']->name ?? '')" :required="true" />
                        </div>

                        <div class="col-md-6 mb-3">
                            <x-form.number-input name="phone_number" label="Phone Number" :value="old('phone_number', $data['record']->phone_number ?? '')"/>
                        </div>

                        <div class="col-md-6 mb-3">
                            <x-form.text-input name="address" label="Address" :value="old('address', $data['record']->address ?? '')" :required="true" />
                        </div>

                        <div class="col-md-6 mb-3">
                            <x-form.text-input name="contact_person" label="Contact Person" :value="old('contact_person', $data['record']->contact_person ?? '')" />
                        </div>

                        <div class="col-md-6 mb-3">
                            <x-form.email-input name="email" label="Email Address" :value="old('email', $data['record']->email ?? '')" />
                        </div>

                        @isset($data['record']->id)
                            <div class="col-md-6 mb-3">
                                <x-form.select-input name="status" label="Status" :options="[
                                    'active' => 'Active',
                                    'inactive' => 'Inactive',
                                ]" :value="old('status', $data['record']->status ?? 'active')" />
                            </div>
                        @endisset
                    </div>
                </div>
            </div>
        </div>

        <!-- User Account Tab -->
        <div class="tab-pane fade" id="user-account" role="tabpanel">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-user-plus me-2"></i>Create User Account</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Optional:</strong> Create a user account for this dealer to access the system.
                    </div>
                    
                    @php
                        $hasUser = isset($data['record']->id) && isset($data['user']);
                        $userChecked = old('create_user', $hasUser ? '1' : '');
                    @endphp
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="create_user" name="create_user" value="1" {{ $userChecked ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="create_user">
                            {{ $hasUser ? 'Update user account for this dealer' : 'Create user account for this dealer' }}
                        </label>
                    </div>

                    <div id="user-fields" style="{{ $userChecked ? 'display: block;' : 'display: none;' }}">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <x-form.text-input name="username" label="Username" :value="old('username', $data['user']->name ?? '')" placeholder="Enter username" />
                            </div>

                            <div class="col-md-6 mb-3">
                                <x-form.email-input name="user_email" label="User Email" :value="old('user_email', $data['user']->email ?? '')" placeholder="Enter email for login" />
                            </div>

                            @if($hasUser)
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">New Password (Leave blank to keep current)</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           name="password" placeholder="Enter new password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                           name="password_confirmation" placeholder="Confirm new password">
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @else
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           name="password" placeholder="Enter password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                           name="password_confirmation" placeholder="Confirm password">
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif
                            
                            <div class="col-md-12 mb-3">
                                <x-form.select-input name="user_status" label="User Status" :options="[
                                    'active' => 'Active',
                                    'inactive' => 'Inactive',
                                ]" :value="old('user_status', ($data['user']->status ?? 1) == 1 ? 'active' : 'inactive')" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-end">
        <x-form.submit-button :text="isset($data['record']->id) ? 'Update Dealer' : 'Create Dealer'" :class="'ms-2'" />
        <a href="{{ route('dealers.index') }}" class="btn btn-secondary btn-sm ms-2">Cancel</a>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const createUserCheckbox = document.getElementById('create_user');
    const userFields = document.getElementById('user-fields');
    const usernameField = document.querySelector('input[name="username"]');
    const userEmailField = document.querySelector('input[name="user_email"]');
    const dealerNameField = document.querySelector('input[name="name"]');
    const dealerEmailField = document.querySelector('input[name="email"]');

    // Toggle user fields visibility
    createUserCheckbox.addEventListener('change', function() {
        if (this.checked) {
            userFields.style.display = 'block';
            // Auto-fill username and email from dealer info
            if (dealerNameField.value && !usernameField.value) {
                usernameField.value = dealerNameField.value.toLowerCase().replace(/\s+/g, '');
            }
            if (dealerEmailField.value && !userEmailField.value) {
                userEmailField.value = dealerEmailField.value;
            }
        } else {
            userFields.style.display = 'none';
        }
    });

    // Auto-update username when dealer name changes
    dealerNameField.addEventListener('input', function() {
        if (createUserCheckbox.checked && !usernameField.value) {
            usernameField.value = this.value.toLowerCase().replace(/\s+/g, '');
        }
    });

    // Auto-update user email when dealer email changes
    dealerEmailField.addEventListener('input', function() {
        if (createUserCheckbox.checked && !userEmailField.value) {
            userEmailField.value = this.value;
        }
    });
});
</script>

@extends('admin.main.app')
@section('content')
    <form action="{{ route('setting.update', $data['setting']->id ?? 0) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body p-4">
                        <ul class="nav nav-pills nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#general-tab" role="tab">
                                    <i class="ri-settings-line me-1 align-bottom"></i>
                                    General Settings
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#social-tab" role="tab">
                                    <i class="ri-share-fill me-1 align-bottom"></i> Social Media
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#branding-tab" role="tab">
                                    <i class="ri-paint-line me-1 align-bottom"></i> Branding
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content pt-4 text-muted">
                            <div class="tab-pane active" id="general-tab" role="tabpanel">
                                <div class="row g-3">
                                    <div class="col-lg-6">
                                        <x-form.text-input :id="'site_name'" label="Site Name"
                                            :name="'site_name'" :value="old('site_name', $data['setting']->site_name ?? '')" />
                                    </div>
                                    <div class="col-lg-6">
                                        <x-form.text-input :id="'email'" label="Email"
                                            :name="'email'" :value="old('email', $data['global_setting']->email ?? '')" />
                                    </div>
                                    <div class="col-lg-6">
                                        <x-form.text-input :id="'phone'" label="Phone Number"
                                            :name="'phone'" :value="old('phone', $data['setting']->phone ?? '')" />
                                    </div>

                                    <div class="col-lg-6">
                                        <x-form.text-input :id="'helpline'" label="Helpline"
                                            :name="'helpline'" :value="old('helpline', $data['setting']->helpline ?? '')" />
                                    </div>
                                    <div class="col-lg-6">
                                        <x-form.text-input :id="'address'" label="Address"
                                            :name="'address'" :value="old('address', $data['setting']->address ?? '')" />
                                    </div>
                                    <div class="col-lg-12">
                                        <label for="google_map" class="form-label">Google Map</label>
                                        <textarea class="form-control" id="google_map" name="google_map" rows="3"
                                            placeholder="Paste your Google Map embed code here">{{ old('google_map', $data['global_setting']->google_map ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="social-tab" role="tabpanel">
                                <div class="row g-3">
                                    <div class="col-lg-6">
                                        <x-form.text-input :id="'facebook'" :label="'Facebook'" :name="'facebook'"
                                            :value="old('facebook', $data['global_setting']->facebook ?? '')" />
                                    </div>
                                    <div class="col-lg-6">
                                        <x-form.text-input :id="'twitter'" :label="'Twitter'" :name="'twitter'"
                                            :value="old('twitter', $data['global_setting']->twitter ?? '')" />
                                    </div>
                                    <div class="col-lg-6">
                                        <x-form.text-input :id="'instagram'" :label="'Instagram'" :name="'instagram'"
                                            :value="old('instagram', $data['global_setting']->instagram ?? '')" />
                                    </div>
                                    <div class="col-lg-6">
                                        <x-form.text-input :id="'youtube'" :label="'YouTube'" :name="'youtube'"
                                            :value="old('youtube', $data['global_setting']->youtube ?? '')" />
                                    </div>
                                    <div class="col-lg-6">
                                        <x-form.text-input :id="'tiktok'" :label="'Tiktok'" :name="'tiktok'"
                                            :value="old('tiktok', $data['global_setting']->tiktok ?? '')" />

                                    </div>
                                    <div class="col-lg-6">
                                        <x-form.text-input :id="'whatsapp'" :label="'Whatsapp'" :name="'whatsapp'"
                                            :value="old('whatsapp', $data['global_setting']->whatsapp ?? '')" />
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="branding-tab" role="tabpanel">
                                <div class="row g-4">
                                    <div class="col-lg-4">
                                        <label class="form-label">Site Logo</label>
                                        <input type="file" class="form-control" name="logo" id="logoInput">
                                        <div class="mt-3 text-center">
                                            @if (!empty($data['global_setting']->logo ?? ''))
                                                <img id="logoPreview" class="img-fluid rounded"
                                                    src="{{ asset('uploads/images/site/' . $data['global_setting']->logo) }}"
                                                    alt="Site Logo" style="max-height: 120px;">
                                            @else
                                                <img id="logoPreview" class="img-fluid rounded"
                                                    style="display: none; max-height: 120px;">
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <label class="form-label">Favicon</label>
                                        <input type="file" class="form-control" name="favicon" id="faviconInput">
                                        <div class="mt-3 text-center">
                                            @if (!empty($data['global_setting']->favicon ?? ''))
                                                <img id="faviconPreview" class="rounded"
                                                    src="{{ asset('uploads/images/site/' . $data['global_setting']->favicon) }}"
                                                    alt="Favicon" style="max-height: 120px;">
                                            @else
                                                <img id="faviconPreview" class="rounded"
                                                    style="display: none; max-height: 120px;">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="form-label">Default Image</label>
                                        <input type="file" class="form-control" name="default_image"
                                            id="defaultImageInput">
                                        <div class="mt-3 text-center">
                                            @if (!empty($data['global_setting']->default_image ?? ''))
                                                <img id="defaultImagePreview" class="img-fluid rounded"
                                                    src="{{ asset('uploads/images/site/' . $data['global_setting']->default_image) }}"
                                                    alt="Default Image" style="max-height: 120px;">
                                            @else
                                                <img id="defaultImagePreview" class="img-fluid rounded"
                                                    style="display: none; max-height: 120px;">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-end mt-3">
            <button type="submit" class="amd-btn amd-btn-primary amd-btn-sm">Update Settings</button>
        </div>
    </form>

@endsection

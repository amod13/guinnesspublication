<form class="row g-3"
    action="{{ isset($data['record']->id) ? route('vmg.update', $data['record']->id) : route('vmg.store') }}"
    method="POST" enctype="multipart/form-data">
    @csrf
    @isset($data['record']->id)
        @method('PUT')
    @endisset

    <div class="col-md-12 mb-3">
        <x-form.text-input :id="'title'" :label="'Title'" :name="'title'" :value="old('title', $data['record']->title ?? '')" />
    </div>

    @isset($data['record']->id)
        <div class="col-md-12 mb-3">
            <x-form.select-input :id="'status'" :label="'Status'" :name="'status'" :options="['1' => 'Active', '0' => 'Inactive']"
                :value="(string) old('status', $data['record']->status ?? '1')" />
        </div>
    @endisset

    <div class="col-12 mb-3">
        <div class="card">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="fas fa-list me-2"></i>Features Management</h6>
            </div>
            <div class="card-body">
                @php
                    $features = old('features', $data['record']->features ?? []);
                    if (is_string($features)) {
                        $features = json_decode($features, true) ?? [];
                    }
                    $featuresList = $features['features'] ?? [];
                @endphp

                <div class="mb-3">
                    <label class="form-label fw-bold">Features List</label>
                    <div id="features-container">
                        @foreach($featuresList as $index => $feature)
                        <div class="feature-item mb-2">
                            <div class="row g-2">
                                <div class="col-md-11">
                                    <input type="text" class="form-control" name="features[features][{{ $index }}]"
                                           placeholder="Feature description" value="{{ old('features.features.' . $index, $feature) }}">
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-danger btn-sm" onclick="removeFeature(this)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @if(empty($featuresList))
                        <div class="feature-item mb-2">
                            <div class="row g-2">
                                <div class="col-md-11">
                                    <input type="text" class="form-control" name="features[features][0]"
                                           placeholder="Feature description" value="{{ old('features.features.0') }}">
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-danger btn-sm" onclick="removeFeature(this)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <button type="button" class="btn btn-success btn-sm" onclick="addFeature()">
                        <i class="fas fa-plus me-1"></i>Add Feature
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-12 button_submit pt-20 d-flex justify-content-end">
        <x-form.submit-button :label="'Submit'" />
    </div>

</form>

<script>
let featureIndex = {{ empty($featuresList) ? 1 : count($featuresList) }};

function addFeature() {
    const container = document.getElementById('features-container');
    const featureHtml = `
        <div class="feature-item mb-2">
            <div class="row g-2">
                <div class="col-md-11">
                    <input type="text" class="form-control" name="features[features][${featureIndex}]"
                           placeholder="Feature description">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeFeature(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', featureHtml);
    featureIndex++;
}

function removeFeature(button) {
    const featureItem = button.closest('.feature-item');
    featureItem.remove();
}
</script>

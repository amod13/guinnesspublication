<?php

namespace App\Core\Traits;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

// Trait: HandlesTempImageUploads.php
trait HandlesTempImageUploads
{
    // Remove property declaration here
    protected function failedValidation(Validator $validator)
    {
        $tempImageFields = property_exists($this, 'tempImageFields') ? $this->tempImageFields : [];
        
        foreach ($tempImageFields as $field) {
            if ($this->hasFile($field)) {
                $tempPath = $this->file($field)->store('temp', 'public');
                session()->flash($field . '_temp_path', $tempPath);
            }
        }

        throw new HttpResponseException(
            redirect()->back()
                ->withErrors($validator)
                ->withInput($this->except($this->tempImageFields))
        );
    }
}


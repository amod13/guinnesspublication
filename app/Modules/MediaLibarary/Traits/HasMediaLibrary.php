<?php

namespace App\Modules\MediaLibarary\Traits;

use App\Modules\MediaLibarary\Models\MediaLibrary;

trait HasMediaLibrary
{
    public function getMediaUrl($fieldName)
    {
        $mediaId = $this->{$fieldName};
        if (!$mediaId) return null;

        $media = MediaLibrary::find($mediaId);
        return $media ? $media->url : null;
    }

    public function getMedia($fieldName)
    {
        $mediaId = $this->{$fieldName};
        if (!$mediaId) return null;

        return MediaLibrary::find($mediaId);
    }

    public function setMedia($fieldName, $mediaId)
    {
        $this->{$fieldName} = $mediaId;
        return $this;
    }
}

<?php

namespace App\Modules\Publication\Repositories\Implementations;

use App\Core\Repositories\Implementation\BaseRepository;
use App\Modules\Publication\Models\AboutUs;
use App\Modules\Publication\Repositories\Interfaces\AboutUsRepositoryInterface;
use Illuminate\Support\Str;

class AboutUsRepository extends BaseRepository implements AboutUsRepositoryInterface
{
    public function __construct(AboutUs $model)
    {
        parent::__construct($model);
    }
    public function getActiveAboutUs()
    {
        return $this->model
            ->where('language', session('language', 'en'))
            ->select('id', 'title', 'slug', 'image_media_id', 'display_order', 'description')
            ->where('status', 'active')
            ->first();
    }


    public function getAboutTagline()
    {
        $data = $this->model
            ->where('language', session('language', 'en'))
            ->select('slug', 'title', 'description')
            ->where('status', 'active')
            ->first();

        if ($data && $data->description) {
            $data->description = Str::words(strip_tags($data->description), 15, '...');
        }

        return $data;
    }

    public function hasBaseDataForLanguage($language, $excludeId = null)
    {
        return $this->model->where('language', $language)
            ->where('id', '!=', $excludeId)
            ->exists();
    }

}

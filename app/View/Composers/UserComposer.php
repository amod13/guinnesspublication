<?php

namespace App\View\Composers;

use App\Core\Helpers\FilePathHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserComposer
{
    public function compose(View $view)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user->profile_image_url = $user->getMediaUrl('profile_image_id') ?? FilePathHelper::getUrl($user->profile_image, 'PROFILE_IMAGE_PATH');
            $view->with('global_user', $user);
        }
    }
}

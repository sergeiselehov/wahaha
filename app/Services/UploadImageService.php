<?php


namespace App\Services;

use App\Models\User;

class UploadImageService
{
    static public function upload(User $user, $image)
    {
        if(!empty($user->avatar)) {
            unlink($user->avatar);
        }
        $image->store('avatars', 'upload');
        return $image->hashName();
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAvatarRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use App\Services\UploadImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class ProfileController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user)
    {
        return $this->sendResponse($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProfileRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(UpdateProfileRequest $request, User $user)
    {
        $user->update($request->toArray());
        return $this->sendResponse();
    }

    /**
     * Update avatar.
     *
     * @param UpdateAvatarRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function updateAvatar(UpdateAvatarRequest $request, User $user)
    {
        $avatar = UploadImageService::upload($user, $request->avatar);
        $user->update(['avatar' => $avatar]);
        return $this->sendResponse($avatar);
    }

    /**
     * Update password.
     *
     * @param UpdatePasswordRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function updatePassword(UpdatePasswordRequest $request, User $user)
    {
        if(Hash::check($request->current, $user->password)) {
            $user->update($request->toArray());
        } else {
            $error = ["current" => "Incorrect current password."];
            return $this->sendError($error);
        }
        return $this->sendResponse();
    }

    /**
     * Update phone.
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function updatePhone(Request $request, User $user)
    {
        return $this->sendResponse([$request, $user]);
    }
}

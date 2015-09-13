<?php

namespace App\Http\Controllers\Api;

use App\Ccu\Image\Upload\Avatar;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function updateNickname(Requests\Member\NicknameRequest $request)
    {
        $request->user()->user()->update($request->only(['nickname']));

        return response()->json();
    }

    public function updateProfilePicture(Requests\Member\ProfilePictureRequest $request)
    {
        (new Avatar($request->file('file'), $request->user()))->handler();

        return response()->json();
    }
}

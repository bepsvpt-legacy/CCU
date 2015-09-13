<?php

namespace App\Http\Controllers\Api;

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
}

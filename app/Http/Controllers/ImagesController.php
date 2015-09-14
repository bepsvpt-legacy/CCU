<?php

namespace App\Http\Controllers;

use App\Ccu\Member\User;
use App\Ccu\Image\Image;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use File;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ImagesController extends Controller
{
    public function profilePicture($nickname = null)
    {
        $user = User::with(['profilePicture'])->where('nickname', '=', $nickname)->first();

        if ((null === $user) || (null === ($image = $user->getRelation('profilePicture')))) {
            $path = default_avatar_path();
            $mimeType = 'image/jpeg';
        } else {
            $path = image_path($image->getAttribute('hash'), $image->getAttribute('uploaded_at')->timestamp);
            $mimeType = $image->getAttribute('mime_type');
        }

        return $this->imageResponse($path, $mimeType);
    }

    public function show($hash, $time, $small = false)
    {
        $image = Image::where('hash' ,'=', $hash)
            ->where('uploaded_at', '=', Carbon::createFromTimestamp($time))
            ->first();

        if (null === $image) {
            throw new NotFoundHttpException;
        }

        return $this->imageResponse(image_path($hash, $time, $small), $image->getAttribute('mime_type'));
    }

    public function show_s($hash, $time)
    {
        return $this->show($hash, $time, true);
    }

    public function imageResponse($path, $mimeType)
    {
        if ( ! File::exists($path)) {
            throw new NotFoundHttpException;
        }

        session()->flash('requestImagePath', $path);

        return response(File::get($path), 200, ['Content-Type' => $mimeType]);
    }
}

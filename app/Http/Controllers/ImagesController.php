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
        if (null !== $nickname) {
            $user = User::with(['profilePicture'])->where('nickname', '=', $nickname)->first();

            if (null === $user) {
                throw new NotFoundHttpException;
            }
        }

        if ((null === $nickname) || (null === ($image = $user->getRelation('profilePicture')))) {
            return response(File::get(default_avatar_path()), 200, ['Content-Type' => 'image/jpeg']);
        }

        $path = image_path($image->getAttribute('hash'), $image->getAttribute('uploaded_at')->timestamp);

        if ( ! File::exists($path)) {
            throw new NotFoundHttpException;
        }

        return response(File::get($path), 200, ['Content-Type' => $image->getAttribute('mime_type')]);
    }

    public function show($hash, $time, $small = false)
    {
        $image = Image::where('hash' ,'=', $hash)->where('uploaded_at', '=', Carbon::createFromTimestamp($time))->first();

        $path = image_path($hash, $time, $small);

        if ((null === $image) || ( ! File::exists($path))) {
            throw new NotFoundHttpException;
        }

        return response(File::get($path), 200, ['Content-Type' => $image->getAttribute('mime_type')]);
    }

    public function show_s($hash, $time)
    {
        return $this->show($hash, $time, true);
    }
}

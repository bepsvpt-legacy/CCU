<?php

namespace App\Ccu\Image\Upload;

use App\Ccu\Image\Image;

class Avatar extends  ImageAbstract
{
    /**
     * @var \App\Ccu\Member\Account
     */
    protected $account;

    /**
     * Create a new UploadAvatar instance
     *
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @param \App\Ccu\Member\Account $account
     */
    public function __construct($file, $account)
    {
        parent::__construct($file);

        $this->account = $account->load(['user', 'user.profilePicture']);
    }

    /**
     * Handle the avatar upload process.
     *
     * @return bool
     */
    public function handler()
    {
        $this->resizeImage(64, 64, false)->saveImage($this->getPath())
            ->resizeImage(32, 32, false)->saveImage($this->getPath(true));

        $this->updateProfilePicture($this->createDatabaseRecord());

        return true;
    }

    /**
     * Update user's profile picture path;
     *
     * @param \App\Ccu\Image\Image $image
     */
    protected function updateProfilePicture($image)
    {
        $oldId = $this->account->getRelation('user')->getAttribute('profile_picture_id');

        $this->account->getRelation('user')->update(['profile_picture_id' => $image->getAttribute('id')]);

        $this->deleteOldProfilePicture($oldId);
    }

    /**
     * Delete the profile picture.
     *
     * @param $id
     */
    protected function deleteOldProfilePicture($id)
    {
        $image = Image::find($id);

        if (null !== $image)
        {
            unlink(image_path($image->getAttribute('hash'), $image->getAttribute('uploaded_at')->timestamp));

            unlink(image_path($image->getAttribute('hash'), $image->getAttribute('uploaded_at')->timestamp, true));

            $image->delete();
        }
    }
}
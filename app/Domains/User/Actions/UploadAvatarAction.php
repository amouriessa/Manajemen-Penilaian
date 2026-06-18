<?php

namespace App\Domains\User\Actions;

use DragonCode\Support\Facades\Helpers\Str;
use Illuminate\Http\UploadedFile;

class UploadAvatarAction
{
    public function execute(UploadedFile $file): string
    {
        $filename =
            'avatar_' . Str::uuid() . '.' . $file->extension();

        return $file->storeAs(
            'avatars',
            $filename,
            'private'
        );
    }
}

<?php

namespace Jestevezrod\Initar\Traits;


trait HasInitar
{
    private $initarInstance;

    public function generateAvatar()
    {
        if (!isset($this->initarInstance)) {
            $this->initarInstance = app(\Jestevezrod\Initar\InitarGenerator::class);
        }


        $avatarUrl = storage_path('app/public/' . $this->id . '.png');

        $avatar = $this->initarInstance
            ->generate($this)
            ->save($avatarUrl, 90, 'png');

        $this->image_profile_path = $avatarUrl;
        $this->save();

    }


    protected static function booted()
    {
        static::created(function ($user) {
            $user->generateAvatar();
        });
    }
}

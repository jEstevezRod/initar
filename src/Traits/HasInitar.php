<?php

namespace Jestevezrod\Initar\Traits;


use Jestevezrod\Initar\Exceptions\InvalidProfileAvatarColumnException;

trait HasInitar
{
    private $initarInstance;

    private $initarAvatar;

    private $initarAvatarPath;

    protected static function booted()
    {
        static::created(function ($user) {
            $user->initarGenerate()->initarSaveFile()->initarUpdateModel();
        });
    }

    protected function initarGenerate()
    {
        if (!isset($this->initarInstance)) {
            $this->initarInstance = app(\Jestevezrod\Initar\InitarGenerator::class, ['user' => $this]);
        }

        [$this->initarAvatar, $this->initarAvatarPath] = $this->initarInstance->generate();

        return $this->initarAvatar;
    }

    protected function initarSaveFile()
    {
        $this->initarAvatar->save($this->initarAvatarPath, 90, 'png');
        return $this->initarAvatar;
    }

    protected function initarUpdateModel()
    {
        $configUserProfileAvatarColumn = config('initar.user_profile_avatar_column');

        if (
            !is_string($configUserProfileAvatarColumn) ||
            !array_key_exists($configUserProfileAvatarColumn, $this->getAttributes())
        ) {
            throw new InvalidProfileAvatarColumnException();
        }

        $this[$configUserProfileAvatarColumn] = $this->initarAvatarPath;
        $this->save();

        return $this->initarAvatar;
    }


}

<?php

namespace Jestevezrod\Initar;

use Image;
use Jestevezrod\Initar\Exceptions\InitialsAreInvalidException;
use Jestevezrod\Initar\Exceptions\UserColumnNameNotFoundException;

class InitarGenerator
{

    private $canvas;

    private $defaultBackgroundColor = '#37c0da';

    private $backgroundColor;

    private $initials;

    private $width = 300;

    private $height = 300;

    private $fourByThreeRatio = 3 / 4;

    private $fontSize = 120;

    private $fontColor;

    private $defaultFontColor = '#ffffff';

    private $defaultStoragePath = 'app/public';

    private $storagePath;

    private $user;


    public function __construct($user)
    {
        $this->user = $user;
    }

    public function generate()
    {
        $this->drawCanvas();

        $this->writeInitialsInMiddle();

        $this->defineAvatarPath();

        return ['avatar' => $this->canvas, 'path' => $this->storagePath];
    }

    private function drawCanvas()
    {
        $this->defineBackgroundColor();
        $this->canvas = Image::canvas($this->width, $this->height);
        $this->canvas->circle(
            $this->width * $this->fourByThreeRatio,
            $this->width / 2,
            $this->width / 2,
            function ($draw) {
                $draw->background($this->backgroundColor);
            });
    }

    private function writeInitialsInMiddle()
    {
        $this->defineInitials();
        $this->defineFontColor();
        $this->canvas->text(
            $this->initials,
            $this->width / 2,
            $this->width / 2,
            function ($text) {
                $text->file(public_path('vendor/initar/fonts/Cousine.ttf'));
                $text->size($this->fontSize);
                $text->color($this->fontColor);
                $text->valign('middle');
                $text->align('center');
                $text->angle('360');
            });

    }

    private function defineBackgroundColor()
    {
        $configBackgroundColorsList = config('initar.background_colors_list');

        if (is_null($configBackgroundColorsList)) {
            $this->backgroundColor = $this->defaultBackgroundColor;
        }
        if (is_iterable($configBackgroundColorsList)) {
            $randomColor = collect($configBackgroundColorsList)->random();
            $this->backgroundColor = $this->isHex($randomColor) ? $randomColor : $this->defaultBackgroundColor;
        }
        if (is_string($configBackgroundColorsList)) {
            $this->backgroundColor = $this->isHex($configBackgroundColorsList)
                ? $configBackgroundColorsList
                : $this->defaultBackgroundColor;
        }
    }

    private function defineInitials()
    {

        $configUserColumnName = config('initar.user_column_name');

        if (is_null($configUserColumnName)) {
            throw new UserColumnNameNotFoundException();
        }

        if (is_iterable($configUserColumnName)) {
            $firstLetter = $this->user[$configUserColumnName[0]][0];
            $secondLetter = $this->user[$configUserColumnName[1]][0];
        }
        if (is_string($configUserColumnName)) {
            $firstLetter = $this->user[$configUserColumnName][0];
            $secondLetter = $this->user[$configUserColumnName][1];
        }

        if (!isset($firstLetter) || !isset($secondLetter) || !is_string($firstLetter) || !is_string($secondLetter)) {
            throw new InitialsAreInvalidException();
        }

        $this->initials = $firstLetter . $secondLetter;
    }

    private function defineFontColor()
    {
        $configFontColor = config('initar.font_colors_list');
        if (is_null($configFontColor)) {
            $this->fontColor = $this->defaultFontColor;
        }
        if (is_iterable($configFontColor)) {
            $randomColor = collect($configFontColor)->random();
            $this->fontColor = $this->isHex($randomColor) ? $randomColor : $this->defaultFontColor;
        }
        if (is_string($configFontColor)) {
            $this->fontColor = $this->isHex($configFontColor)
                ? $configFontColor
                : $this->defaultFontColor;
        }
    }

    private function defineAvatarPath()
    {
        // Base path
        $configStoragePathForAvatar = config('initar.storage_path_for_avatar');

        if (is_null($configStoragePathForAvatar)) {
            $this->storagePath = $this->defaultStoragePath;
        }

        if (is_string($configStoragePathForAvatar)) {
            $this->storagePath = $configStoragePathForAvatar;
        }

        $this->storagePath = rtrim($this->storagePath, '/') . '/';

        // Base path + Avatar name + extension
        $primaryKey = $this->user->primaryKey;

        $this->storagePath .= $this->user[$primaryKey] . '.png';
    }

    private function isHex($color)
    {
        return preg_match('/^#[0-9A-F]{6}$/i', $color);
    }
}

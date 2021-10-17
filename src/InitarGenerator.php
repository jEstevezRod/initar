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


    public function __construct()
    {
        $this->defineBackgroundColor();
    }

    /**
     * @throws UserColumnNameNotFoundException
     * @throws InitialsAreInvalidException
     */
    public function generate($user)
    {
        $this->drawCanvas();

        $this->writeInitialsInMiddle($user);

        return $this->canvas;
    }

    private function drawCanvas()
    {
        $this->canvas = Image::canvas($this->width, $this->height);
        $this->canvas->circle(
            $this->width * $this->fourByThreeRatio,
            $this->width / 2,
            $this->width / 2,
            function ($draw) {
                $draw->background($this->backgroundColor);
            });
    }

    /**
     * @throws UserColumnNameNotFoundException
     * @throws InitialsAreInvalidException
     */
    private function writeInitialsInMiddle($user)
    {
        $this->defineInitials($user);
        $this->defineFontColor();
        $this->canvas->text($this->initials, 150, 150, function ($text) {
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

    private function isHex($color)
    {
        return preg_match('/^#[0-9A-F]{6}$/i', $color);
    }

    /**
     * @throws UserColumnNameNotFoundException
     * @throws InitialsAreInvalidException
     */
    private function defineInitials($user)
    {
        $configUserColumnName = config('initar.user_column_name');

        if (is_null($configUserColumnName)) {
            throw new UserColumnNameNotFoundException();
        }

        if (is_iterable($configUserColumnName)) {
            $firstLetter = $user[$configUserColumnName[0]][0];
            $secondLetter = $user[$configUserColumnName[1]][0];
        }
        if (is_string($configUserColumnName)) {
            $firstLetter = $user[$configUserColumnName][0];
            $secondLetter = $user[$configUserColumnName][1];
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
}

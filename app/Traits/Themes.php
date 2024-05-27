<?php

namespace App\Traits;

trait Themes
{
    //fetch store theme view
    public function fetchThemeViewLocation($theme)
    {
        switch ($theme){
            default:
                $location = 'theme1';
        }

        return $location;
    }
}

<?php

use Symfony\Config\TwigConfig;

return static function (TwigConfig $twigConfig): void {
    $twigConfig
        ->path('%kernel.project_dir%/src/AcMarche/Patrimoine/templates', 'AcMarchePatrimoine')
        ->formThemes(['bootstrap_5_layout.html.twig'])
        ->global('g_latitude' , "%env(PATRIMOINE_LATITUDE)%")
        ->global('g_longitude' , "%env(PATRIMOINE_LONGITUDE)%");
};

<?php

use Symfony\Config\DoctrineConfig;

return static function (DoctrineConfig $doctrine) {
    $em = $doctrine->orm()->entityManager('default');

    $em->mapping('AcMarchePatrimoine')
        ->isBundle(false)
        ->type('attribute')
        ->dir('%kernel.project_dir%/src/AcMarche/Patrimoine/src/Entity')
        ->prefix('AcMarche\Patrimoine')
        ->alias('AcMarchePatrimoine');
};

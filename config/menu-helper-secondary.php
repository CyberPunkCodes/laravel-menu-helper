<?php

$demoMode = env('MH_DEMOMODE', false);

$mhSecondaryConfig = [];

if ( $demoMode === true ) {
    $mhSecondaryConfig['tailwind-basic'] = \CyberPunkCodes\MenuHelper\Services\DemoContent::tailwindFaq();
    $mhSecondaryConfig['bootstrap-basic'] = \CyberPunkCodes\MenuHelper\Services\DemoContent::bootstrapFaq();
}

return $mhSecondaryConfig;

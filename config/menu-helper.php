<?php

$demoMode = env('MH_DEMOMODE', false);

$mhConfig = [
    'demoMode' => $demoMode,
];

if ( $demoMode === true ) {
    $mhConfig['tailwind-advanced'] = \CyberPunkCodes\MenuHelper\Services\DemoContent::tailwindSidebar();
    $mhConfig['bootstrap-advanced'] = \CyberPunkCodes\MenuHelper\Services\DemoContent::bootstrapSidebar();
}

return $mhConfig;

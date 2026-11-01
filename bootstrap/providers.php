<?php

use App\Providers\AppServiceProvider;
use App\Providers\Filament\AdminPanelProvider;
use App\Providers\Filament\PanelUserProvider;

return [
    AppServiceProvider::class,
    AdminPanelProvider::class,
    PanelUserProvider::class,
];

<?php

use App\Modules\Admin\AdminServiceProvider;
use App\Modules\Match\MatchServiceProvider;
use App\Modules\Payment\PaymentServiceProvider;
use App\Modules\Registration\RegistrationServiceProvider;
use App\Modules\Tournament\TournamentServiceProvider;
use App\Providers\AppServiceProvider;
use App\Providers\FortifyServiceProvider;

return [
    AppServiceProvider::class,
    FortifyServiceProvider::class,

    // Modular monolith — satu provider per modul (Modul 2).
    AdminServiceProvider::class,
    TournamentServiceProvider::class,
    RegistrationServiceProvider::class,
    PaymentServiceProvider::class,
    MatchServiceProvider::class,
];

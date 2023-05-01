<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Http\Repositories\BasketInterface;
use App\Http\Repositories\BasketSession;

class PanierService extends ServiceProvider
{
    
    public function register()
    {
        $this->app->bind(BasketInterface::class, BasketSession::class);
    }
}
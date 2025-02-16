<?php

namespace App\Providers;

use App\Config\EnvPlugin;
use App\Domain\Repositories\DonkiRepositoryInterface;
use App\Domain\UseCases\GetDonkiInstrumentsUseCaseInterface;
use App\Infrastructure\Repositories\DonkiRepository;
use App\Infrastructure\UseCases\GetDonkiInstrumentsUseCase;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(EnvPlugin::class, EnvPlugin::class);
        $this->app->bind(ClientInterface::class, Client::class);

        $this->app->bind(GetDonkiInstrumentsUseCaseInterface::class, GetDonkiInstrumentsUseCase::class);
        $this->app->bind(DonkiRepositoryInterface::class, DonkiRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

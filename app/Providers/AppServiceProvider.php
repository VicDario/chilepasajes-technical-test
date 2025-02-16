<?php

namespace App\Providers;

use App\Config\EnvPlugin;
use App\Domain\Repositories\DonkiRepositoryInterface;
use App\Domain\UseCases\GetDonkiActivityIdsUseCaseInterface;
use App\Domain\UseCases\GetDonkiInstrumentsUsageUseCaseInterface;
use App\Domain\UseCases\GetDonkiInstrumentsUseCaseInterface;
use App\Domain\UseCases\GetDonkiInstrumentUsageUseCaseInterface;
use App\Infrastructure\Repositories\DonkiRepository;
use App\Infrastructure\UseCases\GetDonkiActivityIdsUseCase;
use App\Infrastructure\UseCases\GetDonkiInstrumentsUsageUseCase;
use App\Infrastructure\UseCases\GetDonkiInstrumentsUseCase;
use App\Infrastructure\UseCases\GetDonkiInstrumentUsageUseCase;
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
        $this->app->singleton(EnvPlugin::class, EnvPlugin::class);
        $this->app->singleton(ClientInterface::class, Client::class);

        $this->app->bind(GetDonkiInstrumentsUseCaseInterface::class, GetDonkiInstrumentsUseCase::class);
        $this->app->bind(GetDonkiActivityIdsUseCaseInterface::class, GetDonkiActivityIdsUseCase::class);
        $this->app->bind(GetDonkiInstrumentsUsageUseCaseInterface::class, GetDonkiInstrumentsUsageUseCase::class);
        $this->app->bind(GetDonkiInstrumentUsageUseCaseInterface::class, GetDonkiInstrumentUsageUseCase::class);

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

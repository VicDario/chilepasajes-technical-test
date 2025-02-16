<?php

namespace App\Infrastructure\UseCases;

use App\Domain\Repositories\DonkiRepositoryInterface;
use App\Domain\UseCases\GetDonkiInstrumentsUseCaseInterface;

class GetDonkiInstrumentsUseCase implements GetDonkiInstrumentsUseCaseInterface
{
    public function __construct(private DonkiRepositoryInterface $donkiRepository)
    {
        $this->donkiRepository = $donkiRepository;
    }

    public function execute(): array
    {
        $measurementsApis = ['CME', 'GST', 'IPS', 'FLR', 'SEP', 'MPC', 'RBE'];
        $instruments = [];

        foreach ($measurementsApis as $api) {
            $instrumentsUsedInMeasurement = $this->donkiRepository->getInstrumentsFromMeasurement($api);
            $instruments = array_merge($instruments, $instrumentsUsedInMeasurement);
        }

        return ['instruments' => array_values(array_unique($instruments))];
    }
}

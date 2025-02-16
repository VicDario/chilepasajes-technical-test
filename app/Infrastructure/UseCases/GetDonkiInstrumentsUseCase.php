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
        $measurements = ['CME', 'GST', 'IPS', 'FLR', 'SEP', 'MPC', 'RBE'];
        $instruments = [];

        foreach ($measurements as $measurement) {
            $instrumentsUsedInMeasurement = $this->donkiRepository->getInstrumentsFromMeasurement($measurement);
            $instruments = array_merge($instruments, $instrumentsUsedInMeasurement);
        }

        return ['instruments' => array_values($instruments)];
    }
}

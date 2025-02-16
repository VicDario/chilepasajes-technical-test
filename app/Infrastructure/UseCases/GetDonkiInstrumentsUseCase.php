<?php

namespace App\Infrastructure\UseCases;

use App\Domain\Repositories\DonkiRepositoryInterface;
use App\Domain\UseCases\GetDonkiInstrumentsUseCaseInterface;

class GetDonkiInstrumentsUseCase implements GetDonkiInstrumentsUseCaseInterface
{
    public function __construct(private DonkiRepositoryInterface $donkiRepository) {}

    public function execute(): array
    {
        $measurementsApis = ['CME', 'GST', 'IPS', 'FLR', 'SEP', 'MPC', 'RBE'];
        $instrumentsUsedInMeasurements = $this->donkiRepository->getInstrumentsFromMeasurements($measurementsApis);
        return ['instruments' => array_values(array_unique($instrumentsUsedInMeasurements))];
    }
}

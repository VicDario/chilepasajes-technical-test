<?php

namespace App\Infrastructure\UseCases;

use App\Domain\Repositories\DonkiRepositoryInterface;
use App\Domain\UseCases\GetDonkiInstrumentsUsageUseCaseInterface;

class GetDonkiInstrumentsUsageUseCase implements GetDonkiInstrumentsUsageUseCaseInterface
{
    public function __construct(private DonkiRepositoryInterface $donkiRepository) {}

    public function execute(): array
    {
        $measurementsApis = ['CME', 'IPS', 'FLR', 'SEP', 'MPC', 'RBE'];

        $instruments = $this->donkiRepository->getInstrumentsFromMeasurements($measurementsApis);
        $totalOccurrences = count($instruments);

        $instrumentCounts = [];
        foreach ($instruments as $instrument)
            $instrumentCounts[$instrument] = ($instrumentCounts[$instrument] ?? 0) + 1;

        $instrumentUsage = [];
        foreach ($instrumentCounts as $instrument => $count)
            $instrumentUsage[$instrument] = round($count / $totalOccurrences, 3);


        return ['instruments_use' => $instrumentUsage];
    }
}

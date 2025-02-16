<?php

namespace App\Infrastructure\UseCases;

use App\Domain\Repositories\DonkiRepositoryInterface;
use App\Domain\UseCases\GetDonkiInstrumentUsageUseCaseInterface;

class GetDonkiInstrumentUsageUseCase implements GetDonkiInstrumentUsageUseCaseInterface
{
    public function __construct(private DonkiRepositoryInterface $donkiRepository) {}

    public function execute(string $instrument): array
    {
        $measurementsApis = [
            ['type' => 'CME', 'idFieldName' => 'activityID'],
            ['type' => 'IPS', 'idFieldName' => 'activityID'],
            ['type' => 'FLR', 'idFieldName' => 'flrID'],
            ['type' => 'SEP', 'idFieldName' => 'sepID'],
            ['type' => 'MPC', 'idFieldName' => 'mpcID'],
            ['type' => 'RBE', 'idFieldName' => 'rbeID']
        ];
        $measurementsData = $this->donkiRepository->getMeasurementsData($measurementsApis);
        $totalAppearances = 0;
        $appearancesInActivity = [];

        foreach ($measurementsData as $measurement) {
            if (in_array($instrument, $measurement['instruments'])) {
                $totalAppearances++;
                $appearancesInActivity[$measurement['id']] = ($appearancesInActivity[$measurement['id']] ?? 0) + 1;
            }
        }

        $result = [];
        foreach ($appearancesInActivity as $activityId => $count)
            $result[$activityId] = round($count / $totalAppearances, 2);

        return ['instrument_activity' => [$instrument => $result]];
    }
}

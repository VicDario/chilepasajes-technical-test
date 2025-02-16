<?php

namespace App\Infrastructure\UseCases;

use App\Domain\Repositories\DonkiRepositoryInterface;
use App\Domain\UseCases\GetDonkiActivityIdsUseCaseInterface;

class GetDonkiActivityIdsUseCase implements GetDonkiActivityIdsUseCaseInterface
{
    public function __construct(private DonkiRepositoryInterface $donkiRepository) {}

    public function execute(): array
    {
        $measurementsApis = [
            ['type' => 'CME', 'idFieldName' => 'activityID'],
            ['type' => 'GST', 'idFieldName' => 'gstID'],
            ['type' => 'IPS', 'idFieldName' => 'activityID'],
            ['type' => 'FLR', 'idFieldName' => 'flrID'],
            ['type' => 'SEP', 'idFieldName' => 'sepID'],
            ['type' => 'MPC', 'idFieldName' => 'mpcID'],
            ['type' => 'RBE', 'idFieldName' => 'rbeID']
        ];

        $activityIdsInMeasurement = $this->donkiRepository->getActivityIdsFromMeasurements($measurementsApis);

        return ['activityIDs' => array_values(array_unique($activityIdsInMeasurement))];
    }
}

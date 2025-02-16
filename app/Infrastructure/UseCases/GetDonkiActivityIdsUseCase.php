<?php

namespace App\Infrastructure\UseCases;

use App\Domain\Repositories\DonkiRepositoryInterface;
use App\Domain\UseCases\GetDonkiActivityIdsUseCaseInterface;

class GetDonkiActivityIdsUseCase implements GetDonkiActivityIdsUseCaseInterface
{
    public function __construct(private DonkiRepositoryInterface $donkiRepository)
    {
        $this->donkiRepository = $donkiRepository;
    }

    public function execute(): array
    {
        $measurements = [
            ['type' => 'CME', 'idFieldName' => 'activityID'],
            ['type' => 'GST', 'idFieldName' => 'gstID'],
            ['type' => 'IPS', 'idFieldName' => 'activityID'],
            ['type' => 'FLR', 'idFieldName' => 'flrID'],
            ['type' => 'SEP', 'idFieldName' => 'sepID'],
            ['type' => 'MPC', 'idFieldName' => 'mpcID'],
            ['type' => 'RBE', 'idFieldName' => 'rbeID']
        ];
        $activityIds = [];

        foreach ($measurements as $measurement) {
            $activityIdsInMeasurement = $this->donkiRepository->getActivityIdsFromMeasurement($measurement['type'], $measurement['idFieldName']);
            $activityIds = array_merge($activityIds, $activityIdsInMeasurement);
        }

        return ['activityIDs' => array_values($activityIds)];
    }
}

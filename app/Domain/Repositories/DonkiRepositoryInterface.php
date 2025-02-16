<?php

namespace App\Domain\Repositories;

interface DonkiRepositoryInterface
{
    public function getInstrumentsFromMeasurements(array $measurementApis): array;
    public function getActivityIdsFromMeasurement(string $measurementType, string $idFieldName): array;
}

<?php

namespace App\Domain\Repositories;

interface DonkiRepositoryInterface
{
    public function getInstrumentsFromMeasurements(array $measurementApis): array;
    public function getActivityIdsFromMeasurements(array $measurementApisInfo): array;
    public function getMeasurementsData(array $measurementApisInfo): array;
}

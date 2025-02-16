<?php

namespace App\Domain\Repositories;

interface DonkiRepositoryInterface
{
    public function getInstrumentsFromMeasurement(string $measurementType): array;
    public function getActivityIdsFromMeasurement(string $measurementType, string $idFieldName): array;
}

<?php

namespace App\Domain\Repositories;

interface DonkiRepositoryInterface
{
    public function getInstrumentsFromMeasurement(string $measurement): array;
}

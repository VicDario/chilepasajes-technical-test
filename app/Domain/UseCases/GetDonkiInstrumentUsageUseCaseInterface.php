<?php

namespace App\Domain\UseCases;

interface GetDonkiInstrumentUsageUseCaseInterface
{
    public function execute(string $instrument): array;
}

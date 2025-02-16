<?php

namespace App\Presentation\Http\Controllers;

use App\Domain\UseCases\GetDonkiInstrumentsUseCaseInterface;
use App\Infrastructure\UseCases\GetDonkiActivityIdsUseCase;
use Illuminate\Http\JsonResponse;

class DonkiController extends Controller
{
    public function __construct(
        private GetDonkiInstrumentsUseCaseInterface $getDonkiInstrumentsUseCase,
        private GetDonkiActivityIdsUseCase $getDonkiActivityIdsUseCase
    ) {}

    public function getInstrumentsFromMeasurements(): JsonResponse
    {
        $response = $this->getDonkiInstrumentsUseCase->execute();
        return response()->json($response);
    }

    public function getActivityIdsFromMeasurements(): JsonResponse
    {
        $response = $this->getDonkiActivityIdsUseCase->execute();
        return response()->json($response);
    }
}

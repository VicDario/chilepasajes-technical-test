<?php

namespace App\Presentation\Http\Controllers;

use App\Domain\UseCases\GetDonkiInstrumentsUsageUseCaseInterface;
use App\Domain\UseCases\GetDonkiInstrumentsUseCaseInterface;
use App\Domain\UseCases\GetDonkiInstrumentUsageUseCaseInterface;
use App\Infrastructure\UseCases\GetDonkiActivityIdsUseCase;
use Illuminate\Http\JsonResponse;
use App\Presentation\Http\Requests\InstrumentUsageRequest;

class DonkiController extends Controller
{
    public function __construct(
        private GetDonkiInstrumentsUseCaseInterface $getDonkiInstrumentsUseCase,
        private GetDonkiActivityIdsUseCase $getDonkiActivityIdsUseCase,
        private GetDonkiInstrumentsUsageUseCaseInterface $getDonkiInstrumentsUsageUseCase,
        private GetDonkiInstrumentUsageUseCaseInterface $getDonkiInstrumentUsageUseCase
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

    public function getInstrumentsUsage(): JsonResponse
    {
        $response = $this->getDonkiInstrumentsUsageUseCase->execute();
        return response()->json($response);
    }

    public function getInstrumentUsage(InstrumentUsageRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $response = $this->getDonkiInstrumentUsageUseCase->execute($validated['instrument']);
        return response()->json($response);
    }
}

<?php

namespace App\Presentation\Http\Controllers;

use App\Domain\UseCases\GetDonkiInstrumentsUseCaseInterface;
use Illuminate\Http\JsonResponse;

class InstrumentController extends Controller
{
    public function __construct(private GetDonkiInstrumentsUseCaseInterface $getDonkiInstrumentsUseCase) {}

    public function getInstrumentsFromDonki(): JsonResponse
    {
        $instruments = $this->getDonkiInstrumentsUseCase->execute();
        return response()->json($instruments);
    }
}

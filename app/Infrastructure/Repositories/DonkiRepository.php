<?php

namespace App\Infrastructure\Repositories;

use App\Config\EnvPlugin;
use App\Domain\Repositories\DonkiRepositoryInterface;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\Facades\Log;

class DonkiRepository implements DonkiRepositoryInterface
{
    private string $baseUrl;
    private string $apiKey;

    public function __construct(private ClientInterface $client, private EnvPlugin $envPlugin)
    {
        $this->baseUrl = $this->envPlugin->get('NASA_API_URL');
        $this->apiKey =  $this->envPlugin->get('DONKI_API_KEY');
    }

    public function getInstrumentsFromMeasurement(string $measurementType): array
    {
        $response = $this->getDataFromDonkiAPI($measurementType);

        $instruments = array_merge(...array_map(function ($measurement) {
            return array_map(function ($instrument) {
                return $instrument['displayName'];
            }, $measurement['instruments']);
        }, $$response ?? []));

        return array_unique($instruments);
    }

    private function getDataFromDonkiAPI(string $measurement): array
    {
        $response = $this->client->request(
            'GET',
            $this->baseUrl . '/DONKI/' . $measurement,
            [
                'query' => [
                    'api_key' => $this->apiKey
                ],
            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }
}

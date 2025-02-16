<?php

namespace App\Infrastructure\Repositories;

use App\Config\EnvPlugin;
use App\Domain\Repositories\DonkiRepositoryInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Promise\Utils;
use GuzzleHttp\Promise\PromiseInterface;

class DonkiRepository implements DonkiRepositoryInterface
{
    private string $baseUrl;
    private string $apiKey;

    public function __construct(private ClientInterface $client, private EnvPlugin $envPlugin)
    {
        $this->baseUrl = $this->envPlugin->get('NASA_API_URL');
        $this->apiKey =  $this->envPlugin->get('DONKI_API_KEY');
    }

    public function getInstrumentsFromMeasurements(array $measurementsApis): array
    {
        $promises = array_map(function ($api) {
            return $this->getDataFromDonkiAPI($api);
        }, $measurementsApis);
        $responses = Utils::unwrap($promises);

        $instruments = array_merge(...array_map(function ($measurementJson) {
            $measurement = json_decode($measurementJson->getBody()->getContents(), true);
            return array_merge(...array_map(
                fn($measurement) =>
                array_map(fn($instrument) => $instrument['displayName'], $measurement['instruments']),
                $measurement
            ));
        }, $responses ?? []));

        return $instruments;
    }

    public function getActivityIdsFromMeasurement(string $measurementType, string $idFieldName): array
    {
        $response = $this->getDataFromDonkiAPI($measurementType);

        $activitiesIDs = array_map(function ($measurement) use ($idFieldName) {
            $parts = explode("-", $measurement[$idFieldName]);
            $id = $parts[count($parts) - 2] . "-" . $parts[count($parts) - 1];
            return $id;
        }, $response ?? []);

        return array_unique($activitiesIDs);
    }

    private function getDataFromDonkiAPI(string $measurement): PromiseInterface
    {
        return $this->client->requestAsync(
            'GET',
            $this->baseUrl . '/DONKI/' . $measurement,
            [
                'query' => [
                    'api_key' => $this->apiKey
                ],
            ]
        );
    }
}

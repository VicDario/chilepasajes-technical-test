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

    public function getActivityIdsFromMeasurements(array $measurementApisInfo): array
    {
        $promises = array_map(fn($api) => $this->getDataFromDonkiAPI($api['type']), $measurementApisInfo);
        $responses = Utils::unwrap($promises);

        $activitiesIDs = array_map(function (Object $measurementsJson, int $index) use ($measurementApisInfo) {
            $measurements = json_decode($measurementsJson->getBody()->getContents(), true);
            return array_map(
                function ($measurement) use ($index, $measurementApisInfo) {
                    $idFieldName = $measurementApisInfo[$index]['idFieldName'];
                    $parts = explode("-", $measurement[$idFieldName]);
                    $id = $parts[count($parts) - 2] . "-" . $parts[count($parts) - 1];
                    return $id;
                },
                $measurements
            );
        }, $responses, array_keys($responses));

        return array_unique(array_merge(...$activitiesIDs));
    }

    public function getMeasurementsData(array $measurementApisInfo): array
    {
        $promises = array_map(fn($api) => $this->getDataFromDonkiAPI($api['type']), $measurementApisInfo);
        $responses = Utils::unwrap($promises);

        $measurementsData = array_map(function (Object $measurementsJson, int $index) use ($measurementApisInfo) {
            $measurements = json_decode($measurementsJson->getBody()->getContents(), true);
            return array_map(
                function ($measurement) use ($index, $measurementApisInfo) {
                    $idFieldName = $measurementApisInfo[$index]['idFieldName'];
                    $parts = explode("-", $measurement[$idFieldName]);
                    $id = $parts[count($parts) - 2] . "-" . $parts[count($parts) - 1];
                    return [
                        'id' => $id,
                        'instruments' => array_map(fn($instrument) => $instrument['displayName'], $measurement['instruments']),
                    ];
                },
                $measurements
            );
        }, $responses, array_keys($responses));

        return array_merge(...$measurementsData);
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

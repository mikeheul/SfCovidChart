<?php

namespace App\HttpClient;

use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Class CovidHttpClient
 * @package App\Client
 */
class CovidHttpClient
{
    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    /**
     * CovidHttpClient constructor.
     *
     * @param HttpClientInterface $covid
     */
    public function __construct(HttpClientInterface $covid)
    {
        $this->httpClient = $covid;
    }

    /**
     * Get total number of cases and deaths by the given country.
     * 
     * @param string $country
     * 
     * @return array
     */
    public function getTotalByCountry(string $country): array
    {
        $response = $this->httpClient->request('GET', "/total/country/$country", [
            'verify_peer' => false,
        ]);
        $data = json_decode($response->getContent(), true);

        $total = [];

        foreach ($data as $dailyData) {
            $date = (new \DateTime($dailyData['Date']))->format('Y-m-d');
            $total[$date] = $dailyData;
        }

        return $total;
    }
}
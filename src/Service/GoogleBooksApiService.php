<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GoogleBooksApiService
{
    public function __construct(
        private readonly HttpClientInterface $googlebooksClient,
    ) {
    }

    public function get(string $id): array
    {
        return $this->makeRequest('GET', 'volumes/'.$id);
    }

    public function search(string $search): array
    {
        if (strlen($search) < 3) {
            return [];
        }

        return $this->makeRequest('GET', 'volumes', [
            'query' => [
                'q' => $search,
            ],
        ]);
    }

    private function makeRequest(string $method, string $url, array $options = []): array
    {
        $response = $this->googlebooksClient->request($method, $url, $options);

        return $response->toArray();
    }
}

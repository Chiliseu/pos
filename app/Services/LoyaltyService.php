<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class LoyaltyService
{
    protected $baseUrl;
    protected $token;

    public function __construct()
    {
        //$this->baseUrl = config('http://localhost:8080/Loyalty/public/api/generate-token');
        //$this->token = config('3|hjqMnQbUPLEJozCDDqj8JYnZSuLtHpyBoqVWtbkUea1419bd');
        $this->baseUrl = config('services.loyalty_system.url');
        $this->token = config('services.loyalty_system.token');
    }

    /**
     * Fetch customers from the Loyalty System API.
     */
    public function getCustomers()
    {
        return $this->makeRequest('GET', '/customers');
    }

    /**
     * Fetch loyalty cards from the Loyalty System API.
     */
    public function getTransactions($filters = [])
    {
        return $this->makeRequest('GET', '/transactions', $filters);
    }

    public function getLoyaltyCards($filters = [])
    {
        return $this->makeRequest('GET', '/loyaltycards', $filters);
    }

    public function getProductPerformance($filters = [])
    {
        return $this->makeRequest('GET', '/product-performance', $filters);
    }

    public function getLoyaltyCustomerHistory($filters = [])
    {
        return $this->makeRequest('GET', '/loyalty-customer-history', $filters);
    }

    private function makeRequest($method, $endpoint, $queryParams = [])
    {
        $response = Http::withToken($this->token)
            ->$method($this->baseUrl . $endpoint, $queryParams);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('API Request failed: ' . $response->body());
    }

}

<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ApiService
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('api.base_url');
    }

    protected function initInstance($headers = [])
    {
        return Http::withHeaders(array_merge([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ], $headers))->baseUrl($this->baseUrl);
    }

    public function get($endpoint, $params = [], $authToken = null, $headers = [])
    {
        if (isset($authToken)) {
            $headers['Authorization'] = 'Bearer ' . $authToken;
        }
        return $this->initInstance(
            headers: $headers
        )->get($endpoint, $params);
    }
    public function post($endpoint, $data = [], $authToken = null, $headers = [])
    {
        if (isset($authToken)) {
            $headers['Authorization'] = 'Bearer ' . $authToken;
        }
        return $this->initInstance(
            headers: $headers
        )->post($endpoint, $data);
    }
    public function put($endpoint, $data = [], $authToken = null, $headers = [])
    {
        if (isset($authToken)) {
            $headers['Authorization'] = 'Bearer ' . $authToken;
        }
        return $this->initInstance(
            headers: $headers
        )->put($endpoint, $data);
    }
    public function delete($endpoint, $data = [], $authToken = null, $headers = [])
    {
        if (isset($authToken)) {
            $headers['Authorization'] = 'Bearer ' . $authToken;
        }
        return $this->initInstance(
            headers: $headers
        )->delete($endpoint, $data);
    }
}

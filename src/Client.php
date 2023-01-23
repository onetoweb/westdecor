<?php

namespace Onetoweb\Westdecor;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\RequestOptions;

/**
 * Westdecor Client.
 */
class Client
{
    /**
     * Base Href.
     */
    public const BASE_HREF = 'https://www.westdecor.be/rest/V1/webservice';
    
    /**
     * Methods.
     */
    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';
    
    /**
     * @var string
     */
    private $apiKey;
    
    /**
     * @var string
     */
    private $token;
    
    /**
     * @param string $apiKey
     * @param string $token
     */
    public function __construct(string $apiKey, string $token)
    {
        $this->apiKey = $apiKey;
        $this->token = $token;
    }
    
    /**
     * @return string[]
     */
    public static function getMethods()
    {
        return [
            self::METHOD_GET,
            self::METHOD_POST
        ];
    }
    
    /**
     * @param string $endpoint
     * @param array $data = []
     * 
     * @param array $query = []
     */
    public function get(string $endpoint, array $data = []): ?array
    {
        return $this->request(self::METHOD_GET, $endpoint, $data);
    }
    
    /**
     * @param string $endpoint
     * @param array $data = []
     *
     * @param array $query = []
     */
    public function post(string $endpoint, array $data = []): ?array
    {
        return $this->request(self::METHOD_POST, $endpoint, $data);
    }
    
    /**
     * @param array $data = []
     *
     * @return array|null
     */
    public function getProducts(array $data = []): ?array
    {
        return $this->post('/products/', $data);
    }
    
    /**
     * @param string $sku
     *
     * @return array|null
     */
    public function getProduct(string $sku): ?array
    {
        return $this->post("/products/$sku");
    }
    
    /**
     * @param string $method
     * @param string $endpoint
     * @param array $data = []
     * 
     * @return array|null
     */
    public function request(string $method, string $endpoint, array $data = []): ?array
    {
        // merge json body with default values
        $json = array_merge([
            'api_key' => $this->apiKey,
            'language' => 'nl'
        ], $data);
        
        // build options
        $options = [
            RequestOptions::HTTP_ERRORS => false,
            RequestOptions::JSON => $json,
            RequestOptions::HEADERS => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer {$this->token}"
            ]
        ];
        
        // request
        $response = (new GuzzleClient())->request($method, self::BASE_HREF.$endpoint, $options);
        
        // get contents
        $contents = $response->getBody()->getContents();
        
        // return decoded
        return json_decode($contents, true);
    }
}
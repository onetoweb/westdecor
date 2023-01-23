<?php

require 'vendor/autoload.php';

use Onetoweb\Westdecor\Client as WestdecorClient;

// params
$apiKey = 'api_key';
$bearer = 'bearer';

// setup client
$westdecorClient = new WestdecorClient($apiKey, $bearer);

// get products
$products = $westdecorClient->getProducts([
    'page_num' => 1,
    'page_size' => 20
]);

// get product
$sku = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';
$product = $westdecorClient->getProduct($sku);

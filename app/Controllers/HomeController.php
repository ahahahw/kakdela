<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Services\InvoiceService;
use App\View;
use App\App;
use App\Container;
use Symfony\Component\HttpClient\HttpClient;
class HomeController
{
    public function __construct(private InvoiceService $invoiceService ){}
    public function index(): View
    {   
        $user = $_SERVER['REMOTE_ADDR'];
        
        $requestData = [    
            'debug' => true,
            'query' => [
                'content_type' => 1,
                'format' => 'php_serial',
                'media' => 'photos',
                'method' => 'GET',
                'per_page' => 10,
                'safe_search' => 1,
                'text' => '',
            ],
        ];
        
        $client = HttpClient::create([
            'max_redirects' => 3,
        ]);

        $response = $client->request(
            'GET',
            'https://2domains.ru/api/web-tools/geoip?ip='.$user,
            [
                'query' => $requestData['query']
            ]
        );

        exit;
        // echo $statusCode = $response->getStatusCode();
        // echo $contentType = $response->getHeaders()['content-type'][0];

        // print_r(json_decode($response->getContent()));
        return View::make('home/index', array(json_decode($response->getContent())));
        exit;
    }
}

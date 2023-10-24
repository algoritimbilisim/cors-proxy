<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ProxyController extends Controller
{
    public function forwardRequest(Request $request, $all)
    {
        $client = new Client();
        // Hedef URL
        $url = 'http://192.168.1.102:14277/api/' . $all . '?' . $request->getQueryString();

        //dd($request->get());

        $response = $client->request($request->method(), $url, [
            'headers' => array_merge($request->header(), ['Content-Type' => 'application/json']),
            'body' => json_encode($request->input())

        ]);

        return response($response->getBody()->getContents())
            ->setStatusCode($response->getStatusCode())
            ->withHeaders($response->getHeaders());
    }
}

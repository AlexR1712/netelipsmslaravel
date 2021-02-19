<?php

namespace AlexR1712\NetelipLaravel;

use GuzzleHttp\Client;

const API_ENDPOINT = 'https://api.netelip.com';

class NetelipLaravel
{
    protected $client;
    public $from;
    protected $debug_mode;

    public function __construct(Client $client = null, string $from = null, bool $debug_mode = false) {

        $this->client = $client ?: new Client();
        $this->from = $from ?: 'anonymous';
        $this->debug_mode = $debug_mode;

    }

    public function send(string $destination, string $message) : array {
        try {
            $response = $this->client->post('/v1/sms/api.php', [
                'debug' => $this->debug_mode,
                'base_uri' => API_ENDPOINT,
                'multipart' => [
                    [
                        'name'     => 'token',
                        'contents' => config('netelip-laravel.token')
                    ],
                    [
                        'name'     => 'destination',
                        'contents' => $destination
                    ],
                    [
                        'name'     => 'from',
                        'contents' => $this->from
                    ],
                    [
                        'name'     => 'message',
                        'contents' => $message
                    ]
                ]
            ]);
        } catch (\Exception $th) {
            dd($th->getMessage());
        }
         
        $xml = simplexml_load_string($response->getBody()->getContents());
        $code = (int) $xml->xpath('//status')[0];
        $is_sent = $code === 200;

        return [
            'is_sent' => $is_sent,
            'sms_id' => (string) $xml->xpath('//ID-SMS')[0],
            'statusCode' => $code,
            'remainingBalance' => (double) $xml->xpath('//remainingbalance')[0]
        ];
        
    }
} 
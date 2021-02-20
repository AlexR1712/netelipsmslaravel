<?php

namespace AlexR1712\NetelipLaravel;

use GuzzleHttp\Client;

class NetelipLaravel
{
    const BASE_URI = 'https://api.netelip.com';
    const RESPONSE_CODE_SUCCESS = 200;
    const RESPONSE_CODE_UNAUTHORIZED = 401;
    const RESPONSE_CODE_PAYMENT_REQUIRED = 402;
    const RESPONSE_CODE_PRECONDITION_FAILED = 412;
    const RESPONSE_CODE_PARAMETERS_ERROR = 103;
    const RESPONSE_CODE_REQUIRED_PARAMETERS_ERROR = 109;

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
                'base_uri' => self::BASE_URI,
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
            throw new Exception('Netelip: ' . $th->getMessage(), 1);
        }
         
        $xml = simplexml_load_string($response->getBody()->getContents());
        $statusCode = (int) $xml->xpath('//status')[0];
        
        $validation = $this->validateResponse($statusCode);
                
        return array_merge($validation, [
            'sms_id' => (string) $xml->xpath('//ID-SMS')[0],
            'remainingBalance' => (double) $xml->xpath('//remainingbalance')[0]
        ]);
        
    }

    public function validateResponse(int $statusCode): array {

        $is_sent = $statusCode === self::RESPONSE_CODE_SUCCESS;

        switch ($statusCode) {
            case self::RESPONSE_CODE_SUCCESS:
                $message = "Message sent succesfully";
                break;
            case self::RESPONSE_CODE_UNAUTHORIZED:
                $message("Unauthorized request");
                break;
            case self::RESPONSE_CODE_PAYMENT_REQUIRED:
                $message = "Out of credit";
                break;
            case self::RESPONSE_CODE_PRECONDITION_FAILED:
                $message = "Request malformed";
                break;
            case self::RESPONSE_CODE_PARAMETERS_ERROR:
                $message = "Parameters error";
                break;
            case self::RESPONSE_CODE_REQUIRED_PARAMETERS_ERROR:
                $message = "Required parameters missed";
                break;
        }

        return [
            'is_sent' => $is_sent,
            'statusCode' => $statusCode, 
            'message' => $message
        ];

    }
} 
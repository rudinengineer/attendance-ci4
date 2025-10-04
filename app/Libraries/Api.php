<?php

namespace App\Libraries;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Api
{
    protected static $client;

    public static function init()
    {
        if (!self::$client) {
            self::$client = new Client([
                'base_uri' => getenv('API_BASEURL'),
                'timeout'  => 10,
            ]);
        }
    }

    public static function send($method, $endpoint, $options = [])
    {
        self::init();

        try {
            $options['headers'] = [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . session('access_token')
            ];
            $response = self::$client->request($method, $endpoint, $options);

            return [
                'status'  => true,
                'code'    => $response->getStatusCode(),
                'data'    => json_decode($response->getBody(), true),
            ];
        } catch (RequestException $e) {
            $body = $e->hasResponse()
                ? json_decode($e->getResponse()->getBody(), true)
                : null;

            // Destory Session
            if (isset($body['status_code']) && $body['status_code'] === "07") {
                session()->destroy();
            }

            return [
                'status'  => false,
                'code'    => $e->getCode(),
                'error'   => $e->getMessage(),
                'data'    => $body
            ];
        } catch (Exception $e) {
            session()->remove('access_token');
            return [
                'status'  => false,
                'code'    => 500,
                'error'   => "server not ready",
                'data'    => []
            ];
        }
    }
}

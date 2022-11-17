<?php

namespace App\BogPay;

use GuzzleHttp\Client;

class BogPay
{
    private $api_url = 'https://ipay.ge/opay/api/v1';

    private $intent = [
        'CAPTURE',  //0
        'AUTHORIZE' //1
    ];

    private $locale = [
        'ka',  //0
        'en-US' //1
    ];

    private $capture_method = [
        'AUTOMATIC',  //0
        'MANUAL'  //1
    ];

    private $token;

    private $client_id;

    private $secret_key;

    private $http_client;

    /**
     * @param $client_id
     * @param $secret_key
     * @throws \GuzzleHttp\Exception\GuzzleException
     */

    public function __construct($client_id,$secret_key){
        $this->client_id = $client_id;
        $this->secret_key = $secret_key;
        $this->http_client = new Client();

        $this->token = $this->get_token();
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */

    private function get_token(){

        //dd(base64_encode($this->client_id . ':' . $this->secret_key));
        $response = $this->http_client->request('POST', $this->api_url . '/oauth2/token', [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => 'Basic '.base64_encode($this->client_id . ':' . $this->secret_key)
            ],

            'form_params' => [
                'grant_type' => 'client_credentials'
            ]
        ]);

        $body = $response->getBody()->getContents();

        $body = json_decode($body,true);

        return $body['access_token'];

    }

    /**
     * @param int $intent 0|1 CAPTURE|AUTHORIZE
     * @param string $redirect_url
     * @param array $purchase_units ['currency_code' => $cur_code, 'value' => $total]
     * @param int $capture_method 0|1 AUTOMATIC|MANUAL
     * @param array $items [
                                {
                                "amount": "10.50",
                                "description": "test_product",
                                "quantity": "1",
                                "product_id": "123456"
                                }
                            ]
     * @param int $locale 0|1 ka|en-US
     * @param $shop_order_id
     * @param bool $show_shop_order_id_on_extract
     * @return \Psr\Http\Message\StreamInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */

    public function make_order(
        $intent,
        $redirect_url,
        array $purchase_units,
        $capture_method = null,
        $items = null,
        $locale = null,
        $shop_order_id = null,
        $show_shop_order_id_on_extract = null
    ){

        $json = [];

        $json['intent'] = $this->intent[(int)$intent];



        $json['redirect_url'] = $redirect_url;

        $_purchase_units = [];

        $n = 0;

        foreach ($purchase_units as $item){
            $_purchase_units[$n]['amount'] = $item;
            $n++;
        }

        $json['purchase_units'] = $_purchase_units;

        if(is_array($items)) $json['items'] = $items;

        if($locale !== null) $json['locale'] = $this->locale[(int)$locale];

        if($shop_order_id !== null) $json['shop_order_id'] = $shop_order_id;

        if($show_shop_order_id_on_extract !== null) $json['show_shop_order_id_on_extract'] = (bool)$show_shop_order_id_on_extract;

        if($capture_method !== null) $json['capture_method'] = $this->capture_method[(int)$capture_method];

        //dd($json);

        $response = $this->http_client->request('POST', $this->api_url . '/checkout/orders', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$this->token
            ],

            'json' => $json
        ]);

        return $response->getBody();

    }

    /**
     * @param $order_id
     * @param $amount
     * @return int
     * @throws \GuzzleHttp\Exception\GuzzleException
     */

    public function refund($order_id, $amount){
        $response = $this->http_client->request('POST', $this->api_url . '/checkout/refund', [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => 'Bearer '.$this->token
            ],

            'form_params' => [
                'order_id' => $order_id,
                'amount' => $amount
            ]
        ]);

        return $response->getStatusCode();
    }


    /**
     * @param $order_id
     * @return \Psr\Http\Message\StreamInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get_payment_details($order_id){
        $response = $this->http_client->request('GET', $this->api_url . '/checkout/payment/'.$order_id, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$this->token
            ]
        ]);

        return $response->getBody();
    }


    /**
     * @param $order_id
     * @param int $auth_type 0|1|2  FULL_COMPLETE|PARTIAL_COMPLETE|CANCEL
     * @param float|int $amount
     * @return int
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function pre_auth_comletion($order_id,int $auth_type,$amount = null){

        $_auth_type = [
            'FULL_COMPLETE',
            'PARTIAL_COMPLETE',
            'CANCEL'
        ];

        $json = [];

        $json['auth_type'] = $_auth_type[$auth_type];

        if($auth_type == 1) $json['amount'] = $amount;

        $response = $this->http_client->request('POST', $this->api_url . '/checkout/payment/' . $order_id . '/pre-auth/completion', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$this->token
            ],

            'json' => $json
        ]);

        return $response->getStatusCode();
    }
}

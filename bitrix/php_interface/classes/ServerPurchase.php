<?

class AnalyticsServerSide
{
    private $fb_pixel_id       = '727255070184437';
    private $fb_access_token   = 'EAAPPKWAFg4kBS3GMu6OylOH4xydnnVat1QVSJB6WsI6ZA7qlRwnBf7TPJZCoLQomeKzUZCBww1MN0hJGtPpKOxUH8lVFAEN7hy1WtbmNCyGEXfl3jknZCZAejUNRfEifOAjmZBU0iCB2PfPpBWt7kpZCTOgadZAqtvjxxMUdooJS2siy0ZA0m4K2huvITvYssjSnqZCgZDZD';
    private $ga_measurement_id = 'G-T0Q9YGZFLZ';
    private $ga_api_secret     = 'XC4UkbAAS0u8RLFjwM9EGQ';

    /**
     * Хеширование данных для Facebook (SHA256)
     */
    private function hashData($data)
    {
        return hash('sha256', strtolower(trim($data)));
    }

    /**
     * Отправка события в Facebook Conversions API
     */
    public function sendFacebookPurchase($orderData)
    {
        $url = "https://graph.facebook.com/v18.0/{$this->fb_pixel_id}/events";
        $event = [
            'event_name'  => 'Purchase',
            'event_time'  => time(),
            'user_data'   => [
                'em'                => $this->hashData($orderData['email']),
                'ph'                => $this->hashData($orderData['phone']),
                'fbc'               => $orderData['fbc'],
                'fbp'               => $orderData['fbp'],
                'client_ip_address' => $orderData['ip'],
                'client_user_agent' => $orderData['user_agent'],
            ],
            'custom_data' => [
                'value'    => $orderData['total_amount'],
                'currency' => 'UAH',
                'order_id' => $orderData['order_id'],
            ],
        ];

        return $this->curlRequest($url, [
            'access_token' => $this->fb_access_token,
            'data'         => [$event]
        ]);
    }

    /**
     * Отправка события в Google Analytics 4 (Measurement Protocol)
     */
    public function sendGooglePurchase($orderData)
    {
        $url = "https://www.google-analytics.com/mp/collect?measurement_id={$this->ga_measurement_id}&api_secret={$this->ga_api_secret}";
        $payload = [
            'client_id' => $orderData['ga_client_id'],
            'events'    => [
                [
                    'name'   => 'purchase',
                    'params' => [
                        'transaction_id' => $orderData['order_id'],
                        'value'          => $orderData['total_amount'],
                        'currency'       => 'UAH',
                        'items'          => $orderData['items'],
                        // Массив товаров: [['item_id' => '123', 'price' => 10], ...]
                    ],
                ]
            ],
        ];

        return $this->curlRequest($url, $payload);
    }

    private function curlRequest($url, $data)
    {
        $ch = curl_init($url);
        $payload = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}

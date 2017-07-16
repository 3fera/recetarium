<?php

namespace App\Libraries\Providers\Carritus;

use Curl\Curl;

/**
 * Carritus Provider API Class
 */
class API
{
    /**
     * cURL class.
     *
     * @var \Curl\Curl;
     */
    private $curl;

    /**
     * API URL.
     *
     * @var string
     */
    const URL = 'http://www.carritus.com/tienda_api/';

    const DEFAULT_SUPER = 'mercadona';

    const DEFAULT_CP = 43002;

    public function __construct()
    {
        $this->curl = new Curl();
    }

    public function search($product, $super = null, $cp = null)
    {
        $super = $super ?: self::DEFAULT_SUPER;
        $cp = $cp ?: self::DEFAULT_CP;
        $uri = 'buscar/'.$product . '/super/' . $super . '/cp/' . $cp;

        $result = $this->request($uri);
        if (isset($result->productos)) {
            return $result->productos;
        }
    }

    private function request($uri)
    {
        $this->curl->get(self::URL . $uri);
        return $this->curl->response;
    }

    public function getAVGPrice($products)
    {
        if (!is_array($products) || empty($products)) {
            return;
        }

        $prices = [];
        foreach ($products as $product) {
            $prices[] = $product->precio_producto;
        }

        return round(array_sum($prices) / count($prices), 2);
    }
}

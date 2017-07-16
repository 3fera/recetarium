<?php

namespace App\Libraries\Providers\Carritus\Repositories;

/**
 * Carritus Provider Products Repository Class
 */
class Products
{
    /**
     * Products
     *
     * @var array
     */
    private $products;

    /**
     * @param array $products
     */
    public function __construct(array $products)
    {
        $this->products = $products;
    }

    public function getAVGPricePerUnit()
    {
        $prices = [];
        foreach ($this->products as $product) {
            $prices[] = $product->precio_producto;
        }

        return !empty($prices) ? round(array_sum($prices) / count($prices), 2) : false;
    }

    public function getAVGPricePerKg()
    {
        $prices = [];
        foreach ($this->products as $product) {
            $price = $this->parseQuantityPrice($product->precio_cantidad_str);
            if ($price !== false) {
                $prices[] = $price;
            }
        }

        return !empty($prices) ? round(array_sum($prices) / count($prices), 2) : false;
    }

    private function parseQuantityPrice($string)
    {
        if (strpos($string, '€/kg.')) {
            $string = str_replace(' €/kg.', '', $string);
        } elseif (strpos($string, '€/l.')) {
            $string = str_replace(' €/l.', '', $string);
        } else {
            return false;
        }

        return str_replace(',', '.', $string);
    }
}

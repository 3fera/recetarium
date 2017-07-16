<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\Supermarket;
use App\Models\FoodCategory;
use App\Models\Ingredient;
use Illuminate\Console\Command;
use App\Libraries\Providers\Carritus\API;
use App\Libraries\Providers\Carritus\Repositories\Products;

class ImportCarritus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:carritus';

    const SUPERMARKETS = [
        'mercadona',
        'elcorteingles',
        'eroski',
        'caprabo',
        'carrefour',
    ];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->importCarritus();
    }

    private function importCarritus()
    {
        $items = Ingredient::inRandomOrder()->get();
        $provider = new API();

        foreach ($items as $item) {
            foreach (self::SUPERMARKETS as $super) {
                $supermarket = Supermarket::firstOrCreate(['name' => $super]);
                $results = $provider->search($item->name, $super);
                if (!$results) {
                    continue;
                }
                dd($results);
                foreach ($results as $result) {

                    echo $result->nombre_categoria;
                    echo PHP_EOL;
                    continue;

                    $brand = null;
                    if ($result->nombre_marca && $result->nombre_marca != 'Sin Marca') {
                        $brand = ProductBrand::firstOrCreate(['name' => $result->nombre_marca]);
                    }
                    $product = Product::firstOrCreate([
                        'name' => $result->nombre,
                        'brand_id' => $brand ? $brand->id : null,
                    ]);
                    $product->description = $result->descripcion;
                    $product->save();
                    $supermarket->products()->attach($product->id, [
                        'price' => $this->cleanPrice($result->precio_producto),
                        'price_quantity' => $this->cleanPriceQuantity($result->precio_cantidad_str),
                    ]);
                }
            }
        }
    }

    private function cleanPrice($price)
    {
        return round(str_replace(',', '.', $price), 2);
    }

    private function cleanPriceQuantity($string)
    {
        if (strpos($string, '€/kg.')) {
            $string = str_replace(' €/kg.', '', $string);
        } elseif (strpos($string, '€/l.')) {
            $string = str_replace(' €/l.', '', $string);
        } else {
            return null;
        }

        return $this->cleanPrice($string);
    }

    private function getAVG()
    {
        $items = FoodCategory::inRandomOrder()->take(3)->get();
        $items = Ingredient::inRandomOrder()->take(3)->get();
        $provider = new API();

        foreach ($items as $item) {
            echo 'Product: '. $item->name;
            echo PHP_EOL;
            $result = $provider->search($item->name);

            if (!$result) {
                echo 'NO RESULTS FOUND!';
                echo PHP_EOL;
                echo PHP_EOL;
                continue;
            }

            dd($result);

            $repository = new Products($result);
            echo 'Price: '. $repository->getAVGPricePerUnit();
            echo PHP_EOL;
            echo 'Price Kg: '. $repository->getAVGPricePerKg();
            echo PHP_EOL;
            echo PHP_EOL;
        }
    }
}

<?php

namespace App\Console\Commands;

use App\Models\FoodCategory;
use App\Models\Ingredient;
use App\Models\Product;
use Illuminate\Console\Command;
use Searchy;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

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
        //$items = FoodCategory::inRandomOrder()->take(1)->get();
        $items = Ingredient::inRandomOrder()->get();
        $items = Ingredient::where('name', 'sal')->get();
        foreach ($items as $item) {
            echo 'Product: '. $item->name;
            echo PHP_EOL;
            echo PHP_EOL;
            echo PHP_EOL;

            //$products = Product::where('description', 'like', '%'.$item->name.'%')->get();
            $products = $this->search($item->name);
            if (!empty($products)) {
                foreach ($products as $product) {
                    echo $product->name;
                    echo PHP_EOL;
                    echo $product->description;
                    echo PHP_EOL;
                    echo PHP_EOL;
                }
            }
        }
    }

    private function search($string)
    {
        $products = Searchy::products('name', 'description')->query($string)->getQuery()->having('relevance', '>', 50)->take(3)->get();

        return $products;
    }
}

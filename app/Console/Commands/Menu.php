<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Recipe;

class Menu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'menu';

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
        for ($day = 1; $day <= 7; $day++) {
            $this->info('Day '.$day);
            $lunch = $this->getLunch();
            $dinner = $this->getDinner();
            $this->getPrice($lunch);
            $this->getPrice($lunch);
        }
    }

    private function getPrice($recipe)
    {
        $this->info($recipe->name);
        $total = 0;
        $ingredients = $recipe->ingredients()->with('ingredient', 'unit')->get();
        foreach ($ingredients as $ingredient) {
            $product = $ingredient->ingredient->product();
            if ($product) {
                $price = $product->getAVGPrice();
                $productPriceQuantity = $product->getAVGPriceQuantity();
                $productPrice = $price;
                if ($ingredient->unit) {
                    if ($productPriceQuantity) {
                        if ($ingredient->unit->name == 'gramo' && is_numeric($ingredient->quantity)) {
                            $price = ((($productPriceQuantity / 100) * $ingredient->quantity) / 100);
                        }
                    }
                }
                $unit = $ingredient->unit ? $ingredient->unit->name : '?';
                $this->line('<comment>Ingredient:</comment> '.$ingredient->ingredient->name);
                $this->line('<comment>Quantity:</comment> '.$ingredient->quantity . ' ' . $unit);
                $this->line('<comment>Product:</comment> '.$product->name);
                $this->line('<comment>Unit Price:</comment> '.$productPrice);
                $this->line('<comment>Kg Price:</comment> '.$productPriceQuantity);
                $this->line('<comment>Total Price:</comment> '.$price);
                $this->line('');
                $total += $price;
            }
        }

        return $total;
    }

    private function getLunch()
    {
        return Recipe::whereIn('category_id', [4, 5, 8, 15, 18])->inRandomOrder()->first();
    }

    private function getDinner()
    {
        return Recipe::whereIn('category_id', [5, 15, 18, 9])->inRandomOrder()->first();
    }
}

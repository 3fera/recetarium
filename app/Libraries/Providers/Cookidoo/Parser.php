<?php

namespace App\Libraries\Providers\Cookidoo;

use Illuminate\Support\Facades\File;
use App\Libraries\Providers\Cookidoo\Models\Recipe as CookidooRecipe;
use App\Models\Category;
use App\Models\Recipe;
use App\Models\Unit;
use App\Models\Ingredient;
use App\Models\FoodCategory;
use App\Models\ShoppingCategory;
use App\Models\RecipeImage;
use App\Models\Tool;
use Image;

/**
 * Cookido Provider Parser Class
 */
class Parser
{
    public function __construct()
    {
        $path = realpath(dirname(__FILE__)) . '/examples/';
        $path = '/home/vagrant/Code/personal/cookidoo/recipes/';
        $files = File::allFiles($path);

        foreach ($files as $file) {
            $path = $file->getRealPath();
            $id = basename($path, '.json');
            $recipe = new CookidooRecipe($id, $path);

            // Ignore non-spanish ones
            if (strpos($recipe->v1Id, 'locale-es-ES')) {
                continue;
            }

            // Create the Recipe
            $recipeModel = Recipe::where('name', $recipe->name)->first();
            if ($recipeModel) {
                $recipeModel->kilojoules = $recipe->kilojoules;
                $recipeModel->kilocalories = $recipe->kilocalories;
                $recipeModel->protein = $recipe->protein;
                $recipeModel->carbohydrates = $recipe->carbohydrates;
                $recipeModel->fat = $recipe->fat;
                $recipeModel->cholesterol = $recipe->cholesterol;
                $recipeModel->dietaryFibre = $recipe->dietaryFibre;
                $recipeModel->save();
            }

            //$this->importRecipe($recipe);
        }

        foreach (glob(storage_path('app/temp/').'*.jpeg') as $file) {
            if (is_file($file)) {
                @unlink($file);
            }
        }
    }

    private function test()
    {
        $path = realpath(dirname(__FILE__)) . '/examples/';
        $path = '/home/vagrant/Code/personal/cookidoo/recipes/8830369710710.json';
        $id = basename($path, '.json');
        $recipe = new CookidooRecipe($id, $path);
        dd($recipe);
    }

    private function importRecipe(CookidooRecipe $recipe)
    {
        // Create the Categories
        if ($recipe->category) {
            $category = Category::firstOrCreate([
                'name' => $recipe->category,
            ]);
        }
        if ($recipe->subCategory) {
            $subCategory = Category::firstOrCreate([
                'name' => $recipe->subCategory,
            ]);
            $subCategory->parent()->associate($category);
            $subCategory->save();
        }

        // Create the Recipe
        $recipeModel = Recipe::where('name', $recipe->name)->first();

        if ($recipeModel) {
            $recipeModel->delete();
            $recipeModel = null;
        }

        $create = false;
        if (!$recipeModel) {
            $create = true;
            $recipeModel = Recipe::create([
                'name' => $recipe->name,
                'portions' => $recipe->portions,
                'cookidoo_id' => $recipe->id,
                'cookidoo_fav_count' => $recipe->favCount,
                'time_total' => $recipe->timeTotal,
                'time_active' => $recipe->timeActive,
                'time_waiting' => $recipe->timeWaiting,
                'kilojoules' => $recipe->kilojoules,
                'kilocalories' => $recipe->kilocalories,
                'protein' => $recipe->protein,
                'carbohydrates' => $recipe->carbohydrates,
                'fat' => $recipe->fat,
                'cholesterol' => $recipe->cholesterol,
                'dietaryFibre' => $recipe->dietaryFibre,
                'difficulty_level' => $this->parseLevel($recipe->difficulty),
                'price_level' => $this->parseLevel($recipe->priceLevel),
                'info' => implode('\n', $recipe->info),
                'source' => 'https://cookidoo.es/vorwerkWebapp/app#/recipe/' . $recipe->id,
            ]);
            $recipeModel->category()->associate($category);
            if (isset($subCategory)) {
                $recipeModel->subcategory()->associate($subCategory);
            }
            $recipeModel->save();

            // Create the Recipe steps
            foreach ($recipe->steps as $number => $step) {
                $recipeModel->steps()->create([
                    'number' => $number,
                    'text' => $step,
                ]);
            }

            // Recipe Image
            $path = storage_path('app/temp/' . $recipe->id .'.jpeg');
            Image::make($recipe->image)->save($path);
            $image = new RecipeImage();
            $image->cover = 1;
            $image->recipe()->associate($recipeModel);
            $image->image = $path;
            $image->save();
        }

        // Ingredients
        $ingredients = [];
        foreach ($recipe->ingredients as $ing) {

            // Create the Units
            $unit = null;
            if (isset($ing->unit)) {
                $unit = Unit::firstOrCreate([
                    'name' => $ing->unit,
                ]);
            }

            // Create the Ingredients
            if ($ing->name) {
                $ingredient = Ingredient::where('name', $ing->name)->first();
                if (!$ingredient) {
                    $ingredient = Ingredient::create([
                        'name' => $ing->name,
                    ]);

                    // Create the Ingredients Food Categories
                    foreach ($ing->foodCategories as $name) {
                        $cat = FoodCategory::firstOrCreate([
                            'name' => $name
                        ]);
                        $ingredient->foodCategories()->attach($cat->id);
                    }

                    // Create the Ingredients Shopping Categories
                    foreach ($ing->shoppingCategories as $name) {
                        $cat = ShoppingCategory::firstOrCreate([
                            'name' => $name
                        ]);
                        $ingredient->shoppingCategories()->attach($cat->id);
                    }
                    $ingredient->save();
                }
            }

            if ($create) {

                // Create the RecipeIngredients
                $recipeModel->ingredients()->create([
                    'recipe_id' => $recipeModel->id,
                    'quantity' => $ing->quantity,
                    'unit_id' => isset($unit) ? $unit->id : null,
                    'ingredient_id' => isset($ingredient) && $ingredient ? $ingredient->id : null,
                    'notation' => $ing->notation,
                    'preparation' => $ing->preparation,
                    'optional' => $ing->optional,
                ]);

                // Create the RecipeTool
                $tool = Tool::where('name', 'Thermomix')->first();
                $recipeModel->tools()->attach($tool->id);
                $recipeModel->save();
            }
        }
    }

    private function parseLevel($level)
    {
        $level = strtolower($level);
        switch ($level) {
            case 'easy':
            case 'low': return 1;
            case 'medium':  return 2;
            case 'advance':
            case 'high': return 3;
            default: return null;
        }
    }
}

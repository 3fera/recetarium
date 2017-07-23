<?php

namespace App\Repositories;

use App\Models\Recipe;
use App\Models\FoodCategory;
use Illuminate\Http\Request;
use DB;

class Recipes
{
    /**
     * Search recipes.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public static function search(Request $request)
    {
        $query = Recipe::with('cover');

        $search = $request->input('search');
        if ($search) {
            $query->search($search);
        }

        $category = $request->input('category');
        if ($category) {
            $query->where('category_id', $category);
        }

        $withIngredients = $request->input('with-ingredients');
        if (is_array($withIngredients) && !empty($withIngredients)) {
            if ($request->input('with-ingredients-rule') == 1) {
                $query->withFoodCategories($withIngredients);
            } elseif ($request->input('with-ingredients-rule') == 2) {
                $query->withSomeFoodCategories($withIngredients);
            }
        }

        $withoutIngredients = $request->input('without-ingredients');
        if (is_array($withoutIngredients) && !empty($withoutIngredients)) {
            $query->withoutFoodCategories($withoutIngredients);
        }

        $portions = $request->input('portions');
        if ($portions > 0) {
            if ($portions < 8) {
                $query->where('portions', $portions);
            } else {
                $query->where('portions', '>', $portions);
            }
        }

        $time = $request->input('time');
        if ($time > 0) {
            if ($time < 3600) {
                $query->where('time_total', '<', $time);
            } else {
                $query->where('time_total', '>', $time);
            }
        }

        $kcal = $request->input('kcal');
        if ($kcal > 0) {
            if ($kcal < 200) {
                $query->where('kilocalories', '<', $kcal);
            } else {
                $query->where('kilocalories', '>', $time);
            }
        }

        return $query;
    }

    /**
     * Generates a shopping list, groupped by shopping categories.
     *
     * @param array $recipes
     *
     * @return array
     */
    public static function generateShoppingList($recipes)
    {
        $shoppingCategories = [];
        foreach ($recipes as $recipe) {
            foreach ($recipe->ingredients as $ingredient) {

                // Get the shopping category
                $category = $ingredient->ingredient->shoppingCategories()->first();
                $shoppingCategories[$category->id]['category'] = $category;

                // Prepare the array key
                $key = $ingredient->ingredient->id;
                if ($ingredient->unit) {
                    $key .= '-'. $ingredient->unit->id;
                }

                // Calculate the total for that particular ingredient
                $total = $ingredient->quantity;
                if (isset($shoppingCategories[$category->id]['ingredients'][$key])) {
                    $total += $shoppingCategories[$category->id]['ingredients'][$key]['total'];
                }

                // In case of non-numerical quantities, avoid further sums
                if (!is_numeric($total)) {
                    $key .= '-' . $recipe->id;
                }

                $shoppingCategories[$category->id]['ingredients'][$key] = [
                    'ingredient' => $ingredient,
                    'total' => $total,
                ];
            }
        }

        return $shoppingCategories;
    }

    /**
     * Get the releated recipes, based on its main ingredient foodcategory.
     *
     * @param \App\Models\Recipe $recipe
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public static function related(Recipe $recipe)
    {
        $ingredient = $recipe->ingredients()->orderByRaw('length(quantity) DESC, quantity DESC')->first();

        // Avoid to show the same
        $query = Recipe::with('cover')->where('id', '!=', $recipe->id);

        $query->whereHas('ingredients', function ($query) use ($ingredient) {
            $query->where('ingredient_id', $ingredient->ingredient->id);
        })->inRandomOrder();
        return $query;

        /*$ingredients = $recipe->ingredients()->orderByRaw('length(quantity) DESC, quantity DESC')->take(2)->get();
        foreach($ingredients as $ingredient){
            $query->whereHas('ingredients', function ($query) use ($ingredient) {
                $query->where('ingredient_id', $ingredient->ingredient->id);
            })->inRandomOrder();
        }
        return $query;

        $category = $ingredient->ingredient->foodCategories()->first();
        $query->whereHas('ingredients', function ($query) use ($category) {
            $query->whereHas('ingredient', function ($query) use ($category) {
                $query->whereHas('foodCategories', function ($query) use ($category) {
                    $query->where('food_category_id', $category->id);
                });
            });
        })->inRandomOrder();
        return $query;*/
    }
}

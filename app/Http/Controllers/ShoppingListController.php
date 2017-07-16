<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Repositories\Recipes;

/**
 * Shopping List controller
 */
class ShoppingListController extends Controller
{
    /**
     * Shopping list
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*$recipes = Recipe::with('ingredients.ingredient.shoppingCategories', 'ingredients.unit')
                            ->inRandomOrder()
                            ->take(3)->get();*/
        /*\Cookie::queue(
            \Cookie::forget('shopping-list')
        );*/

        $cookie = request()->cookie('shopping-list');
        if (!is_array($cookie)) {
            $cookie = [];
        }

        $recipes = Recipe::with('ingredients.ingredient.shoppingCategories', 'ingredients.unit')
                            ->whereIn('id', $cookie)->get();

        $shoppingCategories = Recipes::generateShoppingList($recipes);

        return view('shoppinglist.view', compact('recipes', 'shoppingCategories'));
    }

    /**
     * Adds a recipe into the shopping list
     *
     * @param \App\Models\Recipe $recipe
     *
     * @return \Illuminate\Http\Response
     */
    public function add(Recipe $recipe)
    {
        $content = request()->cookie('shopping-list');
        if (!is_array($content)) {
            $content = [];
        }
        $content[] = $recipe->id;
        $cookie = cookie('shopping-list', $content);

        flash('Receta añadida a tu lista de compra')->success();

        return redirect()->route('shoppinglist.show')->cookie($cookie);
        ;
    }

    /**
     * Removes a recipe into the shopping list
     *
     * @param \App\Models\Recipe $recipe
     *
     * @return \Illuminate\Http\Response
     */
    public function remove(Recipe $recipe)
    {
        $content = request()->cookie('shopping-list');
        if (is_array($content)) {
            $pos = array_search($recipe->id, $content);
            if ($pos !== false && isset($content[$pos])) {
                unset($content[$pos]);
            }
        } else {
            $content = [];
        }
        $cookie = cookie('shopping-list', $content);

        flash('Receta eliminada de tu lista de compra')->success();

        return redirect()->route('shoppinglist.show')->cookie($cookie);
        ;
    }
}

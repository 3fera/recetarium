<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Repositories\Recipes;

/**
 * Recipes controller
 */
class RecipesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['mine', 'create', 'store', 'update']]);
    }

    /**
     * Browse recipes.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $recipes = Recipes::search($request)->orderBy('cookidoo_fav_count', 'DESC')->get();

        return response()->success(compact('recipes'));
    }

    /**
     * Recipe.
     *
     * @param \App\Models\Recipe $recipe
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Recipe $recipe)
    {
        // Related
        $related = Recipes::related($recipe)->take(3)->get();

        return response()->success(compact('recipe', 'related'));
    }
}

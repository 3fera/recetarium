<?php

namespace App\Http\Controllers;

use App\Models\FoodCategory;
use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Unit;
use App\Models\Tool;
use App\Repositories\Recipes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Recipes\Store as StoreRequest;

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
        // Search form items
        $categories = Category::main()->pluck('name', 'id')->toArray();
        $ingredients = FoodCategory::pluck('name', 'id')->toArray();

        // Search
        $recipes = Recipes::search($request)->orderBy('cookidoo_fav_count', 'DESC')->paginate(12);

        return view('recipes.search', compact('recipes', 'categories', 'ingredients'));
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

        return view('recipes.view', compact('recipe', 'related'));
    }

    /**
     * Current user recipes.
     *
     * @return \Illuminate\Http\Response
     */
    public function mine()
    {
        // Search
        $recipes = Auth::user()->recipes()->paginate(12);

        return view('recipes.mine', compact('recipes'));
    }

    /**
     * New recipe form.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id');
        $ingredients = Ingredient::pluck('name', 'id');
        $units = Unit::pluck('name', 'id');
        $tools = Tool::pluck('name', 'id');

        return view('recipes.create', compact('categories', 'ingredients', 'units', 'tools'));
    }

    /**
     * Create a new recipe.
     *
     * @param \App\Http\Requests\Recipes\Store $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $recipe = new Recipe($request->all());
        $recipe->user()->associate(Auth::user());
        $recipe->category()->associate(Category::find($request->input('category_id')));
        $recipe->save();

        $ingredients = $request->input('ingredients');
        dd($ingredients);
        foreach ($ingredients as $ingredient) {

        }

        flash('Receta creada satisfactoriamente')->success();

        return redirect($recipe->url);
    }

    /**
     * Edit recipe form.
     *
     * @param \App\Models\Recipe $recipe
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Recipe $recipe)
    {
        if (Gate::denies('update-recipe', $recipe)) {
            abort(403);
        }

        $categories = Category::pluck('name', 'id');
        $ingredients = Ingredient::pluck('name', 'id');
        $units = Unit::pluck('name', 'id');
        $tools = Tool::pluck('name', 'id');

        return view('recipes.edit', compact('categories', 'ingredients', 'units', 'tools'));
    }

    /**
     * Update a recipe.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $recipe = Recipe::findOrFail($request->input('id'));

        if (Gate::denies('update-recipe', $recipe)) {
            abort(403);
        }

        flash('Receta actualizada satisfactoriamente')->success();

        return redirect($recipe->url);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Recipe;

class HomeController extends Controller
{
    /**
     * Home.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recipes = Recipe::with('cover')->orderBy('id', 'DESC')->paginate(9);

        $sliderRecipes = Recipe::with('cover')->take(5)->get();

        return view('home.view', compact('recipes', 'sliderRecipes'));
    }
}

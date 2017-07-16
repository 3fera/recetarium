<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * Auth & Account.
 */
Route::auth();

Route::get('cuenta', [
    'as' => 'account',
    'uses' => 'Auth\AccountController@index',
]);

Route::post('cuenta/guardar', [
    'as' => 'account.store',
    'uses' => 'Auth\AccountController@store',
]);

/**
 * Home.
 */
Route::get('/', 'HomeController@index');

/**
 * Recipes.
 */
Route::any('recetas', [
    'as' => 'recipes.list',
    'uses' => 'RecipesController@index',
]);

Route::get('receta/{recipe}', [
    'as' => 'recipes.show',
    'uses' => 'RecipesController@show',
]);

Route::any('mis-recetas', [
    'as' => 'recipes.mine',
    'uses' => 'RecipesController@mine',
]);

Route::get('subir-receta', [
    'as' => 'recipes.create',
    'uses' => 'RecipesController@create',
]);

Route::post('subir-receta/guardar', [
    'as' => 'recipes.store',
    'uses' => 'RecipesController@store',
]);

Route::get('receta/{recipe}/editar', [
    'as' => 'recipes.edit',
    'uses' => 'RecipesController@edit',
]);

Route::post('editar-receta/guardar', [
    'as' => 'recipes.update',
    'uses' => 'RecipesController@update',
]);

/**
 * Shopping List.
 */
Route::any('lista-de-compra', [
    'as' => 'shoppinglist.show',
    'uses' => 'ShoppingListController@index',
]);

Route::any('lista-de-compra/add/{recipe}', [
    'as' => 'shoppinglist.add',
    'uses' => 'ShoppingListController@add',
]);

Route::any('lista-de-compra/remove/{recipe}', [
    'as' => 'shoppinglist.remove',
    'uses' => 'ShoppingListController@remove',
]);

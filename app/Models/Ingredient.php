<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Searchy;

class Ingredient extends Model
{
    use Sluggable;

    /**
     * Database table name.
     *
     * @var string
     */
    protected $table = 'ingredients';

    /**
     * Sugable.
     *
     * @var array
     */
    protected $sluggable = [
       'build_from' => 'name',
       'save_to'    => 'slug',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    /**
    * Food Categories relationship
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    */
    public function foodCategories()
    {
        return $this->belongsToMany('App\Models\FoodCategory', 'ingredients_food_categories');
    }

    /**
    * Shopping Categories relationship
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    */
    public function shoppingCategories()
    {
        return $this->belongsToMany('App\Models\ShoppingCategory', 'ingredients_shopping_categories');
    }

    /**
    * Recipes relationship
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function recipeIngredients()
    {
        return $this->hasMany('App\Models\RecipeIngredient', 'recipes_ingredients');
    }

    public function product()
    {
        $item = Searchy::products('name', 'description')->query($this->name)->getQuery()->having('relevance', '>', 50)->first();
        if ($item) {
            return Product::find($item->id);
        }
    }
}

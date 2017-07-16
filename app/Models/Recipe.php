<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use DB;

class Recipe extends Model
{
    use Sluggable;
    use SluggableScopeHelpers;

    /**
     * Database table name.
     *
     * @var string
     */
    protected $table = 'recipes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'price_level', 'difficulty_level', 'portions', 'info', 'source',
        'cookidoo_id', 'cookidoo_fav_count', 'time_total', 'time_active', 'time_waiting',
        'kilojoules', 'kilocalories', 'protein', 'carbohydrates', 'fat', 'cholesterol', 'dietaryFibre',
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
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Steps relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function steps()
    {
        return $this->hasMany('App\Models\Step');
    }

    /**
     * Ingredients relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function ingredients()
    {
        return $this->hasMany('App\Models\RecipeIngredient');
    }

    /**
     * Tools relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tools()
    {
        return $this->belongsToMany('App\Models\Tool', 'recipes_tools')->withPivot('description', 'units');
    }

    /**
     * User relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Category relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    /**
     * SubCategory relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function subcategory()
    {
        return $this->belongsTo('App\Models\Category', 'subcategory_id');
    }

    /**
     * Image (cover) relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function cover()
    {
        return $this->hasOne('App\Models\RecipeImage')->where('cover', 1);
    }

    /**
     * Images relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany('App\Models\RecipeImage');
    }

    /**
     * Get the Recipe URL.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return route('recipes.show', ['slug' => $this->slug]);
    }

    /**
     * Search with FoodCategories query scope.
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @param array                              $foodCategories
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithFoodCategories($query, $foodCategories)
    {
        foreach ($foodCategories as $i => $category) {
            $query->whereHas('ingredients', function ($query) use ($category) {
                $query->whereHas('ingredient', function ($query) use ($category) {
                    $query->whereHas('foodCategories', function ($query) use ($category) {
                        $query->where('food_category_id', $category);
                    });
                });
            });
        }
        return $query;
    }

    /**
     * Search with some FoodCategories query scope.
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @param array                              $foodCategories
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithSomeFoodCategories($query, $foodCategories)
    {
        foreach ($foodCategories as $i => $category) {
            $method = $i == 0 ? 'whereHas' : 'orWhereHas';
            $query->$method('ingredients', function ($query) use ($category) {
                $query->whereHas('ingredient', function ($query) use ($category) {
                    $query->whereHas('foodCategories', function ($query) use ($category) {
                        $query->where('food_category_id', $category);
                    });
                });
            });
        }
        return $query;
    }

    /**
     * Search without FoodCategories query scope.
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @param array                              $foodCategories
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeWithoutFoodCategories($query, $foodCategories)
    {
        foreach ($foodCategories as $i => $category) {
            $query->doesntHave('ingredients', 'and', function ($query) use ($category) {
                $query->whereHas('ingredient', function ($query) use ($category) {
                    $query->whereHas('foodCategories', function ($query) use ($category) {
                        $query->where('food_category_id', $category);
                    });
                });
            });
        }
        return $query;
    }

    /**
     * Search query scope.
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @param string                             $search
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($query) use ($search) {
            $search = '%' . $search . '%';
            $query->where('name', 'like', $search);
        });
    }

    public function getPrice()
    {
        $total = 0;
        $ingredients = $this->ingredients()->with('ingredient', 'unit')->get();
        foreach ($ingredients as $ingredient) {
            $product = $ingredient->ingredient->product();
            if ($product) {
                $price = null;
                if ($ingredient->unit) {
                    $avg = $product->getAVGPriceQuantity();
                    if ($avg) {
                        if ($ingredient->unit->name = 'gramos' && is_numeric($ingredient->quantity)) {
                            $price = (100 * ($ingredient->quantity / 1000)) / $avg;
                        }
                    }
                }
                if (!$price) {
                    $price = $product->getAVGPrice();
                }
                $total += $price;
            }
        }

        return $total;
    }
}

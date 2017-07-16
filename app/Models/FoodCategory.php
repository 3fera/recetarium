<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class FoodCategory extends Model
{
    use Sluggable;

    /**
     * Database table name.
     *
     * @var string
     */
    protected $table = 'food_categories';

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
    * Ingredients relationship
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    */
    public function ingredients()
    {
        return $this->belongsToMany('App\Models\Ingredient', 'ingredients_food_categories');
    }
}

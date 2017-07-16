<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * Database table name.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'price', 'price_quantity', 'brand_id',
    ];

    /**
     * Brand relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand()
    {
        return $this->belongsTo('App\Models\ProductBrand');
    }

    /**
     * Supermarkets relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function supermarkets()
    {
        return $this->belongsToMany('App\Models\Supermarket', 'supermarkets_products')->withPivot('price', 'price_quantity');
    }

    public function getAVGPrice()
    {
        return round($this->supermarkets()->avg('price'), 2);
    }

    public function getAVGPriceQuantity()
    {
        return round($this->supermarkets()->avg('price_quantity'), 2);
    }
}

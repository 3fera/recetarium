<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Codesleeve\Stapler\ORM\StaplerableInterface;
use Codesleeve\Stapler\ORM\EloquentTrait;

class RecipeImage extends Model implements StaplerableInterface
{
    use EloquentTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'recipes_images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['image'];

    /**
     * Construct.
     */
    public function __construct(array $attributes = array())
    {
        $this->hasAttachedFile('image', [
            'styles' => [
                'large' => '800x600#',
                'medium' => '640x480#',
                'thumb' => '100x100#',
            ],
        ]);

        parent::__construct($attributes);
    }

    /**
     * Recipe relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipe()
    {
        return $this->belongsTo('App\Models\Recipe');
    }
}

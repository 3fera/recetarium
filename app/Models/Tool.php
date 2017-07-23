<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Tool extends Model
{
    use Sluggable;
    use SluggableScopeHelpers;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tools';

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
     * Recipes relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function recipes()
    {
        return $this->belongsToMany('App\Models\Recipes', 'recipes_tools')->withPivot('description', 'units');
    }
}

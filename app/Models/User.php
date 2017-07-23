<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Codesleeve\Stapler\ORM\StaplerableInterface;
use Codesleeve\Stapler\ORM\EloquentTrait;

class User extends Authenticatable implements JWTSubject, StaplerableInterface
{
    use EloquentTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Construct.
     */
    public function __construct(array $attributes = array())
    {
        $this->hasAttachedFile('image', [
            'styles' => [
                'medium' => '300x300#',
                'thumb' => '100x100#',
            ],
        ]);

        parent::__construct($attributes);
    }

    /**
    * Get the identifier that will be stored in the subject claim of the JWT
    *
    * @return mixed
    */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

   /**
    * Return a key value array, containing any custom claims to be added to the JWT
    *
    * @return array
    */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Recipes relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipes()
    {
        return $this->hasMany('App\Models\Recipe');
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: fjruiz
 * Date: 13/01/17
 * Time: 8:56
 */

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Persona extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nombre','password'
    ];


    /**
     * Persona constructor.
     * @param array $fillable
     */
    public function __construct(array $fillable)
    {
        $this->fillable = $fillable;
    }


}
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
        'Id', 'Nombre','Correo','Password'
    ];

    protected $hidden=[
        'Password'
    ];

    protected $primaryKey='Id';
    protected $table="Personas";
    public $timestamps=false;


    /**
     * Persona constructor.
     * @param array $fillable
     */
    /*public function __construct(array $fillable)
    {
        parent::__construct();
        $this->fillable = $fillable;
    }*/

    public function getId(){
        return $this->fillable['id'];
    }

    public function getNombre(){
        return $this->fillable['nombre'];
    }

    public function getPassword(){
        return $this->fillable['password'];
    }

}
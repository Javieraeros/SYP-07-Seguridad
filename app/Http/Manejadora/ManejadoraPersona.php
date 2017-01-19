<?php
namespace App\Http\Manejadora;
use App\Persona;
use Illuminate\Support\Facades\DB;

class ManejadoraPersona
{
    static function getPersonaBD($id){
        if(isset($id)){
            $results=app('db')->select("Select * from Personas where Id=?",[$id]);
        }else{
            $results = app('db')->select("SELECT * FROM Personas");
        }
        return $results;
    }

    static function postPersonaBD(Persona $persona){
        app('db')->insert("Insert into Personas (Nombre,Password)
                                      VALUES (?,?)",[$persona->getNombre(),$persona->getPassword()]);
    }
}
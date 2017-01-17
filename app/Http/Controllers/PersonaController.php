<?php

namespace App\Http\Controllers;
//TODO Usar response

use App\Http\Manejadora\ManejadoraPersona;


class PersonaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getPersonas($id=null){
        $resultado=ManejadoraPersona::getPersonaBD($id);

        /*if(isset($id)){
            //$results=app('db')->select("Select * from Personas where Id=?",$id);
            $resultado= DB::table('Personas')->where('Id',$id)->first();
        }else{
            $resultado = app('db')->select("SELECT * FROM Personas");
        }*/
        return $resultado;
    }

    public function postPersonas($Persona){

    }
}

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
        return $resultado;
    }

    public function postPersonas($Persona){

    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Database;

//TODO Usar response
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

    public function getPersona($id){
        $resultado=Database\ManejadoraPersona::getPersonaBD($id);
        return $resultado;
    }

    public function postPersona($Persona){

    }
}

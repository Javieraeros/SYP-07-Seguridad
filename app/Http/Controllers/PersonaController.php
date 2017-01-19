<?php

namespace App\Http\Controllers;
//TODO Usar response

use App\Http\Manejadora\ManejadoraPersona;
use App\Persona;
use Illuminate\Http\Request;


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

    public function postPersonas(Request $request){
        if($request->has('Nombre') and $request->has('Password')){
            //TODO hacerlo en middleware o algo por el estilo
            $parametros['id']=0; //No inserta el id puesto que es autogenerado
            $parametros['nombre']=$request->input('Nombre');
            $parametros['password']=hash('sha256',$request->input('Password'));
            $persona=new Persona($parametros);
            ManejadoraPersona::postPersonaBD($persona);
        }

    }
}

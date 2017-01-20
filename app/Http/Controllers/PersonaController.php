<?php

namespace App\Http\Controllers;
//TODO Usar response

use App\Http\Manejadora\ManejadoraPersona;
use App\Persona;
use App\Providers\AuthServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


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

    public function getPersonas(Request $request,$id=null){
        //if($request->user()!=null) {

            //$resultado = ManejadoraPersona::getPersonaBD($id);

            $resultado=DB::select("Select * from Personas");
        //}
        return $resultado;
    }

    public function postPersonas(Request $request){
        if($request->has('Nombre') and $request->has('Password')){
            //TODO hacerlo en middleware o algo por el estilo

            $opciones['coste']=12;

            $parametros['id']=0; //No inserta el id puesto que es autogenerado
            $parametros['nombre']=$request->input('Nombre');
            $parametros['password']=password_hash($request->input('Password'),PASSWORD_BCRYPT,$opciones);
            $persona=new Persona($parametros);
            ManejadoraPersona::postPersonaBD($persona);
        }

    }
}

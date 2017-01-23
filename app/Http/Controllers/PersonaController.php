<?php

namespace App\Http\Controllers;
//TODO Usar response

//TODO Preguntar Miguel Angel problema contraseña

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

    public function getPersona($id){
        $resultado=Persona::find($id);
        return response()->json($resultado);
    }

    public function getPersonas(){
        $resultado=Persona::all();
        return response()->json($resultado);
    }

    public function postPersonas(Request $request){
        $resultado=null;
        $code=400;
        if($request->has('Nombre') and $request->has('Password')){
            $opciones['coste']=12;

            $persona=new Persona();
            $persona->Id=0; //No inserta el id puesto que es autogenerado
            $persona->Nombre=$request->input('Nombre');
            $persona->Password=password_hash($request->input('Password'),PASSWORD_BCRYPT,$opciones);

            $resultado= Persona::create($persona->toArray());
            $code=200;
            //ManejadoraPersona::postPersonaBD($persona);
        }

        return response()->json($resultado,$code);

    }

    public function deletePersona($id){
        $persona=Persona::destroy($id);
        return response()->json($persona,200);
    }

    public function putPersona(Request $request,$id){
        $persona=Persona::find($id);
        $persona['Nombre']=$request->input(['Nombre']);
        $persona['Password']=password_hash($request->input('Password'),PASSWORD_BCRYPT,['coste'=>12]);
        $persona->save();
        return response()->json($persona);
    }
}

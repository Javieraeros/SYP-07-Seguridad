<?php

namespace App\Http\Controllers;
//TODO Usar response y middleware para el tema de tokens, autorización y autenticación

use App\Http\Manejadora\ManejadoraPersona;
use App\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\ValidationData;

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
        $resultado=Persona::all("Nombre");
        return response()->json($resultado);
    }

    public function postPersonas(Request $request){

        if($request->has('Nombre') and $request->has('Password')) {
            $opciones['coste'] = 12;
            $persona = new Persona();
            $persona->Id = 0; //No inserta el id puesto que es autogenerado
            $persona->Nombre = $request->input('Nombre');
            $persona->Password = Hash::make($request->input('Password'));
            $persona = Persona::create($persona->getAttributes());
            if (isset($persona)) {
                $resultado=response()->json($persona,200);
            } else {
                $resultado=response()->json("Error con la conexion de la base de datos",400);
            }
        }
        return $resultado;

    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse El valor del body será 1 si se ha borrado la persona
     */
    public function deletePersona($id){
        //TODO añadir autorización
        $persona=Persona::destroy($id);
        return response()->json($persona,200);
    }

    public function putPersona(Request $request,$id){
        //TODO añadir autorización
        $persona=Persona::find($id);
        $persona['Nombre']=$request->input(['Nombre']);
        $persona['Password']=Hash::make($request->input('Password'));
        $persona->save();
        return response()->json($persona);
    }
}

<?php

namespace App\Http\Controllers;
//TODO Usar response y middleware para el tema de tokens, autorización y autenticación

use App\Http\Manejadora\ManejadoraPersona;
use App\Persona;
use Illuminate\Http\Request;
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
        $resultado=Persona::all();
        return response()->json($resultado);
    }

    public function postPersonas(Request $request){


        $resultado=null;
        $code=400;
        //TODO hacer la recuperación de la persona y codificación de contraseña en middleware
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

        //TODO mover a Authenticate
        $signer = new Sha256();
        $token=(new Builder())
            ->setIssuer('http://personas.fjruiz.ciclo.iesnervion.es')
            ->setAudience('http://personas.fjruiz.ciclo.iesnervion.es')
            //->setNotBefore(time() + 60)
            ->setId('1234')
            ->sign($signer,'secretoIberico')
            ->getToken();
        return response()->json($resultado,$code)->header("Authorization","Bearer ".$token);

    }

    public function deletePersona($id){
        //TODO añadir autorización
        $persona=Persona::destroy($id);
        return response()->json($persona,200);
    }

    public function putPersona(Request $request,$id){
        //TODO añadir autorización
        $persona=Persona::find($id);
        $persona['Nombre']=$request->input(['Nombre']);
        $persona['Password']=password_hash($request->input('Password'),PASSWORD_BCRYPT,['coste'=>12]);
        $persona->save();
        return response()->json($persona);
    }
}

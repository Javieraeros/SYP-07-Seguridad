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

    public function getPersona(Request $request,$id){
        //datos de validación
        $data=new ValidationData();
        $data->setIssuer('http://personas.fjruiz.ciclo.iesnervion.es');
        $data->setAudience('http://personas.fjruiz.ciclo.iesnervion.es');
        $data->setId('1234');
        $signer=new Sha256();
        //recuperamos el token con 'Bearer ' delante, por eso usamos substring
        $token =(new Parser())->parse(substr((string) $request->header("Authorization"),7));

        //echo var_dump($token->verify($signer,'secretoIberico'));

        echo var_dump($token->validate($data));

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

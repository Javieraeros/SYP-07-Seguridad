<?php

namespace App\Http\Controllers;

use App\Persona;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
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

    public function getToken(Request $request){
        //No me deja usar isset
        if($request->header("Authorization")!="" and $request->header("Authorization")!=null){
            $usuarioPassword=base64_decode(substr((string) $request->header("Authorization"),6));
            $arrayUsuario=explode(":",$usuarioPassword);
            try {
                $persona = Persona::where("Nombre","=", $arrayUsuario[0])->firstOrFail();
                if(Hash::check($arrayUsuario[1],$persona->Password)){
                    $resultado=response("Usuario y contraseña correctos",200);
                }else{
                    $resultado=response("La contraseña es incorrecta",400);
                }
            }catch (ModelNotFoundException $httpException){
                $resultado=response("No existe el nombre",404);
            }
        }else{
            $resultado=response("Autenticacion no recibida",401);
        }
        return $resultado;
    }
}

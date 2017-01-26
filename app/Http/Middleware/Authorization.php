<?php

namespace App\Http\Middleware;

use Closure;

use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\ValidationData;
class Authorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    //TODO En vez de usar substr, usar exploit con " " y dependiendo de si el primer valor es Basic o Bearer
    //llamar a dos métodos privados de esta misma clase que comprueba si está autorizado o no
    public function handle($request, Closure $next,$id)
    {
        //datos de validación
        $data=new ValidationData();
        $data->setIssuer('http://personas.fjruiz.ciclo.iesnervion.es');
        $data->setAudience('http://personas.fjruiz.ciclo.iesnervion.es');
        //$data->set('uid',$id);
        $signer=new Sha256();
        $secreto=env("APP_KEY");

        //TODO eliminar token de lista blanca,filtrar por id

        try{
            //recuperamos el token con 'Bearer ' delante, por eso usamos substring
            //Pongo esta linea aqui,porque me puede dar Runtime exception
            $token =(new Parser())->parse(substr((string) $request->header("Authorization"),7));
            if($token->validate($data) and $token->verify($signer,$secreto) and $token->getClaim("uid")==$id){
                return $next($id);
            }else{
                return response("No válido!",401);
            }
        }catch(\RuntimeException $runtimeException){
            return response("Token mal formado!",400);
        }catch(\Exception $exception){
            return response("Unauthorized",401);
        }
    }
}

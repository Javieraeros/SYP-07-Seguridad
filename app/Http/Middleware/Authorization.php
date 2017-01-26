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
    public function handle($request, Closure $next,$id)
    {
        //datos de validación
        $data=new ValidationData();
        $data->setIssuer('http://personas.fjruiz.ciclo.iesnervion.es');
        $data->setAudience('http://personas.fjruiz.ciclo.iesnervion.es');
        $data->setId('1234');
        $signer=new Sha256();

        //TODO eliminar token de lista blanca,filtrar por id

        try{
            //recuperamos el token con 'Bearer ' delante, por eso usamos substring
            //Pongo esta linea aqui,porque me puede dar Runtime exception
            $token =(new Parser())->parse(substr((string) $request->header("Authorization"),7));
            if($token->validate($data) and $token->verify($signer,'secretoIberico')){
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

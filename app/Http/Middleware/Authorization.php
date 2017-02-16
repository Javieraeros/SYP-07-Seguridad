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
    public function handle($request, Closure $next)
    {
        //datos de validación
        $id=explode("/",$request->path())[1];
        $data=new ValidationData();
        $data->setIssuer('http://personas.fjruiz.ciclo.iesnervion.es');
        $data->setAudience('http://personas.fjruiz.ciclo.iesnervion.es');
        $signer=new Sha256();
        $secreto=env("APP_KEY");


        try{
            //recuperamos el token con 'Bearer ' delante, por eso usamos explode
            //Pongo esta linea aqui,porque me puede dar Runtime exception
            $token =(new Parser())->parse(explode(" ",$request->header("Authorization"))[1]);
            if($token->validate($data) and $token->verify($signer,$secreto) and $token->getClaim("jti")==$id){
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

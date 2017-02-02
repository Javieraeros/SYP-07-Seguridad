<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $jwt;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next Obligatoriamente, tendrá que devolver un array con un campo que sea el code, y una persona
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $resultado=$next($request);
        if($resultado["code"]==200){
            $token=self::generaToken($resultado["persona"]->Id);
            return response()->json($resultado["persona"],$resultado["code"])->header("Authorization","Bearer ".$token);
        }else{
            return response()->json($resultado["persona"],$resultado["code"]);
        }


    }

    public static function generaToken($id){
        $signer = new Sha256();
        $secreto=env("APP_KEY");
        $token=(new Builder())
            ->setIssuer('http://personas.fjruiz.ciclo.iesnervion.es')
            ->setAudience('http://personas.fjruiz.ciclo.iesnervion.es')
            //->setNotBefore(time() + 60)
            //->setId('1234')
            ->setExpiration(time()+3600)
            ->sign($signer,$secreto)
            ->set("uid",$id)
            ->getToken();

        return $token;
    }

}

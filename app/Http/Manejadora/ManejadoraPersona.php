<?php
namespace App\Http\Manejadora;
class ManejadoraPersona
{
    static function getPersonaBD($id){
        if(isset($id)){
            //$results=app('db')->select("Select * from Personas where Id=?",$id);
            $results= DB::table('Personas')->where('Id',$id)->first();
        }else{
            $results = app('db')->select("SELECT * FROM Personas");
        }
        return $results;
    }
}
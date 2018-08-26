<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Saldo extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    protected $table = 'tbl_produtos';

    protected $fillable = [
        'name', 'email',
    ];

    protected $hidden = [
        'password',
    ];

    public static function saldo_estoque(){
        $saldos = Saldo::all();
        if($saldos){
            $array = array();
            $num = 0;
            foreach($saldos as $saldo){
                $array["produtos"][$num]["codigo"] = $saldo->produto_id;
                $array["produtos"][$num]["descricao"] = $saldo->produto_descricao;
                $array["produtos"][$num]["saldo"] = $saldo->produto_quantidade_estoque;
                $num++;
            }
            return new Response(json_encode($array, JSON_PRETTY_PRINT), 200);

            return $saldo->toJson();
        }else{
            return new Response("Produto não encontrado", 404);
        }
    }

    public static function saldo_estoque_by_produto_id($produto_id){
        $saldos = Saldo::where();
        if($saldos){
            $array = array();
            $num = 0;
            foreach($saldos as $saldo){
                $array["produtos"][$num]["codigo"] = $saldo->produto_id;
                $array["produtos"][$num]["descricao"] = $saldo->produto_descricao;
                $array["produtos"][$num]["saldo"] = $saldo->produto_quantidade_estoque;
                $num++;
            }
            return new Response(json_encode($array, JSON_PRETTY_PRINT), 200);

            return $saldo->toJson();
        }else{
            return new Response("Produto não encontrado", 404);
        }
    }

}

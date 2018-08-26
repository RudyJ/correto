<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Rastreio extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    protected $fillable = [
        'name', 'email',
    ];

    protected $hidden = [
        'password',
    ];
    
    public static function rastreamento_produto($produto_id = null){    
        if($produto_id == null)
            return new Response("Codigo invalido", 400);
        
        $saldos_get = Saldo::where("produto_id", $produto_id);
        if($saldos_get->exists()){
            $saldos = $saldos_get->get();
            $array = array();            
            $num = 0;
            foreach($saldos as $saldo){
                $array["produtos"][$num]["codigo"] = $saldo->produto_id;
                $array["produtos"][$num]["descricao"] = $saldo->produto_descricao;
                $array["produtos"][$num]["movimentacoes"] = Rastreio::rastreamento_produto_movimentacao($saldo->produto_id);
                $num++;
            }
            return new Response(json_encode($array, JSON_PRETTY_PRINT), 200);
        }else{
            return new Response("Produto nao encontrado", 404);
        }
    }

    
    public static function rastreamento_produto_movimentacao($produto_id){  
        /*
                    
            SELECT 
                RP.recebimento_produto_id as codigo_movimentacao,
                R.recebimento_datahora as data_hora_movimentacao,
                RP.recebimento_produto_quantidade as quantidade_movimentada
            FROM
                tbl_recebimentos_produtos as RP
            INNER JOIN
                tbl_recebimentos as R
            ON
                RP.recebimento_id = R.recebimento_id
            ORDER BY
                R.recebimento_datahora DESC
        
        */

        $recebimento = Rastreio::insertType( DB::table('tbl_recebimentos_produtos')
            ->join('tbl_recebimentos', 'tbl_recebimentos_produtos.recebimento_id', '=', 'tbl_recebimentos.recebimento_id')
            ->join('tbl_produtos', 'tbl_recebimentos_produtos.produto_id', '=', 'tbl_produtos.produto_id')
            ->select('tbl_recebimentos_produtos.recebimento_produto_id as codigo_movimentacao', 
                     'tbl_recebimentos.recebimento_datahora as data_hora_movimentacao', 
                     'tbl_recebimentos_produtos.recebimento_produto_quantidade as quantidade_movimentada')
            ->where('tbl_produtos.produto_id', $produto_id)
            ->get(), 'R');
        
        $saida = Rastreio::insertType( DB::table('tbl_saidas_produtos')
            ->join('tbl_saidas', 'tbl_saidas_produtos.saida_id', '=', 'tbl_saidas.saida_id')
            ->join('tbl_produtos', 'tbl_saidas_produtos.produto_id', '=', 'tbl_produtos.produto_id')
            ->select('tbl_saidas_produtos.saida_produto_id as codigo_movimentacao', 
                    'tbl_saidas.saida_datahora as data_hora_movimentacao', 
                    'tbl_saidas_produtos.saida_produto_quantidade as quantidade_movimentada')
            ->where('tbl_produtos.produto_id', $produto_id)
            ->get(), 'S');

        $ajuste = Rastreio::adjustType(DB::table("tbl_ajustes_estoque as AJ")
                ->select("AJ.ajuste_id as codigo_movimentacao", 
                         "AJ.ajuste_datahora as data_hora_movimentacao",
                         "AJ.ajuste_quantidade as quantidade_movimentada",
                         "AJ.ajuste_tipo as movimentacao")
                ->where("produto_id", $produto_id)
                ->get());

        
                
        $collection = collect($recebimento);
        $concatenated = $collection->concat($saida)->concat($ajuste);
        $sorted = $concatenated->sortBy('data_hora_movimentacao');
        
        return $sorted->values()->all();
    }


    public static function insertType($objs, $type){

        foreach($objs as $obj):            
            switch($type):
                case "R":
                    $obj->movimentacao = "recebimento";
                    break;
                case "S":
                    $obj->movimentacao = "saida";
                    break;
            endswitch;
        endforeach;
        return $objs;
    }

    public static function adjustType($objs){

        foreach($objs as $obj):
            switch($obj->movimentacao){
                case "S":
                    $obj->movimentacao = "ajuste de saida";
                    break;
                case "E":
                    $obj->movimentacao = "ajuste de entrada";
                    break;
            }
        endforeach;
        return $objs;
    }

}

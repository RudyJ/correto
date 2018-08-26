<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\Saldo;
use App\Rastreio;

class HomeController extends Controller
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

    public function index(){
        $produtos = DB::table('tbl_produtos')->get();
        $ajustes_estoque = DB::table('tbl_ajustes_estoque')->get();
        $recebimentos = DB::table('tbl_recebimentos')->get();
        $recebimentos_produtos = DB::table('tbl_recebimentos_produtos')->get();
        $saidas = DB::table('tbl_saidas')->get();
        $saidas_produtos = DB::table('tbl_saidas_produtos')->get();

        return view("home", compact('produtos', 'ajustes_estoque', 'recebimentos', 'recebimentos_produtos', 'saidas', 'saidas_produtos'));
    }


    public function saldoEstoque(){
        return Saldo::saldo_estoque();
    }

    public function rastreamentoProduto($id){
        return Rastreio::rastreamento_produto($id);
    }

    
}

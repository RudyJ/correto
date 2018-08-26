<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Correto</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/css/materialize.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"/>
</head>
<body class="blue-grey lighten-3">
<section class="row">
    <article class="col s12 m6">
        <div class="card-panel">
            <h4>tbl_produtos</h4>
            <p>índices com prefixo produto_</p>
            <table class="striped highlight centered responsive-table">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>descricao</th>
                        <th>quantidade_estoque</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produtos as $produto)
                    <tr>
                        <td>{{ $produto->produto_id }}</td>
                        <td>{{ $produto->produto_descricao }}</td>
                        <td>{{ $produto->produto_quantidade_estoque }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </article>
    <article class="col s12 m6">
        <div class="card-panel">
            <h4>tbl_ajuste_estoque</h4>
            <p>índices com prefixo ajuste_, exceto produto_id</p>
            <table class="striped highlight centered responsive-table">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>tipo</th>
                        <th>datahora</th>
                        <th>motivo</th>
                        <th>produto_id</th>
                        <th>quantidade</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ajustes_estoque as $ajuste_estoque)
                    <tr>
                            <td>{{ $ajuste_estoque->ajuste_id }}</td>
                            <td>{{ $ajuste_estoque->ajuste_tipo }}</td>
                            <td>{{ $ajuste_estoque->ajuste_datahora }}</td>
                            <td>{{ $ajuste_estoque->ajuste_motivo }}</td>
                            <td>{{ $ajuste_estoque->produto_id }}</td>
                            <td>{{ $ajuste_estoque->ajuste_quantidade }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </article>

    <article class="col s12 m6">
        <div class="card-panel">
            <h4>tbl_recebimentos</h4>
            <p>índices com prefixo recebimento_</p>
            <table class="striped highlight centered responsive-table">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>datahora</th>
                        <th>numero_nota</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recebimentos as $recebimento)
                    <tr>
                        <td>{{ $recebimento->recebimento_id }}</td>
                        <td>{{ $recebimento->recebimento_datahora }}</td>
                        <td>{{ $recebimento->recebimento_numero_nota }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </article>
    <article class="col s12 m6">
        <div class="card-panel">
            <h4>tbl_recebimentos_produtos</h4>
            <p>índices com prefixo recebimento_, exceto produto_id</p>
            <table class="striped highlight centered responsive-table">
                <thead>
                    <tr>
                        <th>produto_id</th>
                        <th>id</th>
                        <th>produto_id</th>
                        <th>produto_quantidade</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recebimentos_produtos as $recebimentos_produto)
                    <tr>
                        <td>{{ $recebimentos_produto->recebimento_produto_id }}</td>
                        <td>{{ $recebimentos_produto->recebimento_id }}</td>
                        <td>{{ $recebimentos_produto->produto_id }}</td>
                        <td>{{ $recebimentos_produto->recebimento_produto_quantidade }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </article>  
    <article class="col s12 m6">
        <div class="card-panel">
            <h4>tbl_saidas</h4>
            <table class="striped highlight centered responsive-table">
                <thead>
                    <tr>
                        <th>saida_id</th>
                        <th>saida_datahora</th>
                        <th>saida_numero_nota</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($saidas as $saida)
                    <tr>
                        <td>{{ $saida->saida_id }}</td>
                        <td>{{ $saida->saida_datahora }}</td>
                        <td>{{ $saida->saida_numero_nota }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </article>
    <article class="col s12 m6">
        <div class="card-panel">
            <h4>tbl_saidas_produtos</h4>
            <table class="striped highlight centered responsive-table">
                <thead>
                    <tr>
                        <th>saida_produto_id</th>
                        <th>saida_id</th>
                        <th>produto_id</th>
                        <th>saida_produto_quantidade</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($saidas_produtos as $saidas_produto)
                    <tr>
                        <td>{{ $saidas_produto->saida_produto_id }}</td>
                        <td>{{ $saidas_produto->saida_id }}</td>
                        <td>{{ $saidas_produto->produto_id }}</td>
                        <td>{{ $saidas_produto->saida_produto_quantidade }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </article>  
</section>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/js/materialize.min.js"></script>
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready( function () {
    $('table').DataTable();
});
</script>
</body>
</html>
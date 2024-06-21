@extends('index')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Vendas</h1>
    </div>
    <div>
        <form action="{{ route('vendas.index') }}" method="get">
            <input type="text" name="pesquisar" placeholder="Digite o numero da venda" />
            <button>Pesquisar</button>
            <a type="button" href="{{ route('cadastrar.venda') }}" class="btn btn-success float-end">
                Incluir nova Venda
            </a>
        </form>

        <div class="table-responsive mt-4">
            @if ($tableVenda->isEmpty())
                <p>Não existe dados</p>
            @else
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Numeração</th>
                            <th>Produto</th>
                            <th>Cliente</th>
                            <th>Valor</th>

                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tableVenda as $venda)
                            <tr>
                                <td>{{ $venda->numero_da_venda }}</td>
                                <td>{{ $venda->produto->nome }}</td>
                                <td>{{ $venda->cliente->nome }}</td>
                                <td>{{ $venda->valor }}</td>
                                <td>
                                    <a href="{{route('pdf.venda',$venda->id)}}" class="btn btn-dark btn-sm">
                                        Gerar PDF
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection

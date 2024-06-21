@extends('index')

@section('content')
    <form method="POST" action="{{ route('cadastrar.venda') }}">
        @csrf
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Cadastrar nova Venda</h1>
        </div><br><br>


        <div class=" card p-4 mb-3">
            <h2 class="h4">Cliente</h2>
            <div class="mb-5 d-flex">
                <div class="col-2 me-5">
                    <label class="form-label">Nome</label>
                    <select id="cliente_select" class="form-select" name="cliente_id" required>
                        @foreach ($tbCliente as $cliente)
                            <option value="{{ $cliente->id }}" cpf-valor ="{{ $cliente->cpf }}">{{ $cliente->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-2 ">
                    <label class="form-label">CPF</label>
                    <input id="cpf_cliente" type="text" disabled class="form-control">
                </div>
            </div>
        </div>

        <div class="card p-4 mb-3">
            <h2 class="h4">Itens</h2>
            <div class="mb-5  d-flex align-items-center">
                <div class="col-2 me-5">
                    <label class="form-label">Nome do produto</label>
                    <select id="id_produto" class="form-select" name="produto_id" required>
                        <option disabled selected>Selecione o produto</option>
                        @foreach ($tbProduto as $produto)
                            <option value="{{ $produto->id }}" valor-prod="{{ $produto->valor }}"
                                nome-produto="{{ $produto->nome }}">{{ $produto->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-2 me-5">
                    <label class="form-label mascara_valor">Valor unitário</label>
                    <input id="valor_uni_prod" type="text" disabled class="form-control">
                </div>

                <div class="col-2 me-5">
                    <label class="form-label">Quantidade</label >
                    <input id="quantidade_prod" type="number" class="form-control" min="1" max="100"required>
                </div>
                <div class="col-2 me-5 ">
                    <label class="form-label">Subtotal</label>
                    <input id="subtotal_prod" type="text" disabled class="form-control"required>
                </div>
                <div>
                    <a class="btn btn-success mt-4" onclick="adicionar_itens()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-plus-lg" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2" />
                        </svg>
                    </a>
                </div>
                <br>
            </div>
            <div>
                <div class="table-responsive mt-4 col-9">
                    <table class="table table-striped table-sm">
                        <thead class="ml-4">
                            <tr>
                                <th class="text-center">Nome</th>
                                <th class="text-center">Valor unitário</th>
                                <th class="text-center">Quantidade</th>
                                <th class="text-center">Subtotal</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody id="tabela_itens">
                            {{-- tabela criada --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div class="card p-4 mb-3">

            <h2 class="h4">Forma de pagamento </h2>

            <div class="mb-3 col-12 mt-5 ">
                <h2 class="h5">
                    Valor Total da Venda:
                    <span id="valor_total_venda"></span>
                    <input type="text"  id="input_valor_total" name="valor" required hidden >
                </h2>
            </div>
            <div class="d-flex mb-3">
                <div class=" col-5">

                    <div class="col-10 me-4">
                        <label class="form-label">Número de parcelas</label>
                        <input id="quantidade_parce" type="number" class="form-control" min="1" max="100" required>
                    </div>
                    <div class="col-10 me-4">
                        <label class="form-label">Data</label>
                        <input id="date_parce" class="form-control" type="date" required/>
                    </div>
                    <div class="col-10 mb-4 ">
                        <label class="form-label"type="text" dis>Valor das parcelas</label>
                        <input id="valor_parce" class=" form-control" type="text" disabled required />
                    </div>
                    <a onclick="adicionar_parcelas()" class="btn btn-primary">Adicionar parcelas</a>

                </div>
                <div>
                    <div class=" table-responsive   ">
                        <table class="table ">
                            <thead class="ml-4">
                                <tr class="col-8">
                                    <th id="date_par" class="text-center">Data da parcela</th>
                                    <th id="" class="text-center">Valor</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody id="tabela_parcelas">
                                {{-- parcelas --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>

        <div class="d-flex justify-content-center  mb-5">
            <button type="h" class="btn btn-success col-5">Salvar</button>
        </div>

    </form>
@endsection

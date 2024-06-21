@extends('index')

@section('content')
    <form method="POST" action="{{ route('atualizar.cliente', $tableCliente->id) }}">
        @csrf
        @method('PUT')
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Editar Cliente</h1>
        </div>
        <div class="mb-3">
            <label class="form-label">Nome</label>
            <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome"
                value="{{ isset($tableCliente->nome) ? $tableCliente->nome : old('nome') }}">
            @if ($errors->has('nome'))
                <div class="invalid-feedback">{{ $errors->first('nome') }}</div>
            @endif
        </div>
        <div class="mb-3">
            <label class="form-label">CPF</label>
            <input id="cpf" class="form-control @error('cpf') is-invalid @enderror" name="cpf"
                value="{{ isset($tableCliente->cpf) ? $tableCliente->cpf : old('cpf') }}">
            @if ($errors->has('cpf'))
                <div class="invalid-feedback">{{ $errors->first('cpf') }}</div>
            @endif
        </div>
        <button type="submit" class="btn btn-success">Salvar</button>
    </form>
@endsection

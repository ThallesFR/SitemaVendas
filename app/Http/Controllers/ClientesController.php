<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormRequestCliente;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ClientesController extends Controller
{
    protected $cliente;

    public function __construct(Cliente $cliente)
    {
        $this->cliente = $cliente;
    }
    public function index(Request $request)
    {
        $pesquisar = $request->pesquisar;
        $tableCliente = $this->cliente->getClientesPesquisarNome(search: $pesquisar ?? '');

        return view('pages.clientes.clientes', compact('tableCliente'));
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $buscaRegistro = Cliente::find($id);
        $buscaRegistro->delete();
        return response()->json(['sucesso' => true]);
    }

    public function cadastrarCliente(FormRequestCliente $request)
    {
        if ($request->method() == 'POST') {
            $data = $request->all();
            Cliente::create($data);
            return redirect()->route('clientes.index');
        }

        return view('pages.clientes.create');
    }

    public function atualizarCliente(FormRequestCliente $request, $id)
    {
        if ($request->method() == 'PUT') {
            $data = $request->all();
            $buscaRegistro = Cliente::find($id);
            $buscaRegistro->update($data);

            return redirect()->route('clientes.index');
        }
        $tableCliente = Cliente::where('id', '=', $id)->first();

        return view('pages.clientes.update', compact('tableCliente'));
    }
}

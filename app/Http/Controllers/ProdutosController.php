<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\FormRequestProduto;
use App\Models\FormatInput;
use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutosController extends Controller
{
    protected $produto;
    
    public function __construct(Produto $produto)
    {
        $this->produto = $produto;
    }
    
    public function index(Request $request)
    {   
        $pesquisar = $request->input_pesquisar;
        $tableProduto = $this->produto->getProdutosPesquisarNome(search: $pesquisar ??'');
        return view("pages.produtos.produtos", compact('tableProduto'));
    }
    
    public function delete(Request $request)
    {
        $id = $request->id; 
        $buscaRegistro = Produto::find($id);
        $buscaRegistro->delete();
        return response()->json(['sucesso' => true]);
    }

    public function cadastrarProduto(FormRequestProduto $request)
    {
        if ($request->method() == 'POST') {
            $data = $request->all();
            $componentes = new FormatInput();
            $data['valor'] = $componentes->MascaraDinheiroDecimal($data['valor']);
            Produto::create($data);
            return redirect()->route('produto.index');
        }

        return view('pages.produtos.create');
    }

    public function atualizarProduto(FormRequestProduto $request, $id)
    {
        if ($request->method() == 'PUT') {
            $data = $request->all();
            $componentes = new FormatInput();
            $data['valor'] = $componentes->MascaraDinheiroDecimal($data['valor']);
            $buscaRegistro     = Produto::find($id);
            $buscaRegistro->update($data);

            return redirect()->route('produto.index');
        }
        $tableProduto = Produto::where('id', '=', $id)->first();

        return view('pages.produtos.update', compact('tableProduto'));
    }

}

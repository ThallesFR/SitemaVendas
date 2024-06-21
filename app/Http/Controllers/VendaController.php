<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormRequestVenda;
use App\Models\Cliente;
use App\Models\Produto;
use App\Models\Venda;
use App\Models\Parcelas;
use Illuminate\Http\Request;
use TCPDF;

class VendaController extends Controller
{
    protected $venda;

    public function __construct(Venda $venda)
    {
        $this->venda = $venda;
    }
    public function index(Request $request)
    {
        $pesquisar = $request->pesquisar;
        $tableVenda = $this->venda->getVendasPesquisarIndex(search: $pesquisar ?? '');

        return view('pages.vendas.vendas', compact('tableVenda'));
    }

    public function cadastrarVenda(FormRequestVenda $request)
    {
        $tbNumeracao = Venda::max('numero_da_venda') + 1;
        $tbProduto = Produto::all();
        $tbCliente = Cliente::all();


        if ($request->method() == 'POST') {
            $data = $request->all();
            $venda = [
                'cliente_id' => $data['cliente_id'],
                'numero_da_venda' => $tbNumeracao,
                'produto_id' => $data['produto_id'],
                'valor' => $data['valor'],
            ];
            Venda::create($venda);

            $ultimaVenda = Venda::latest()->first();
            $idDaUltimaVenda = $ultimaVenda->id;

            $numero_parcelas = $data['numero_parcela'];
            $vencimentos = $data['vencimento'];
            $valores_parce = $data['valor_parcela'];

            foreach ($numero_parcelas as $index => $numeroParcela) {
                $parcela = [
                    'numero_parcela' => $numeroParcela,
                    'venda_id' => $idDaUltimaVenda,
                    'valor_parcela' => $valores_parce[$index],
                    'vencimento' => $vencimentos[$index],
                ];
                Parcelas::create($parcela);
            }
            return redirect()->route('vendas.index');
        }

        return view('pages.vendas.create', compact('tbProduto', 'tbCliente'));
    }


    public function gerar_pdf($id)
    {
        ob_end_clean(); // Limpa o buffer de saída antes de gerar o PDF
        ob_start(); // Inicia o buffer de saída

        $id_venda = $id[0];

        $venda = Venda::findOrFail($id_venda);
        $cliente = $venda->cliente->nome;
        $produto = $venda->produto->nome;
        $parcelas = Parcelas::where('venda_id', $id_venda)->get();

        $pdf = new TCPDF();
        $pdf->SetMargins(10, 10, 10);
        $pdf->AddPage();

        $html = '<table border="1">';
        $html .= '<h1> PDF de venda número' . $venda['numero_da_venda'] . '.</h1> <br>';
        $html .= '<h3> Cliente: ' . $cliente . '.</h3>';
        $html .= '<h3> Produtos: ' . $produto . '.</h3>';
        $html .= '<h3> Finalização feita: ' . $venda['created_at'] . '.</h3>';
        $html .=  '<h3> Valor: R$' . $venda['valor'] . '.</h3><br><br>,<br>';

        $html .= '<h2> Parcelas:</h2> <br>';
        $html .= '<tr><th> Numero </th><th> Valor </th><th> Vencimento </th></tr>';

        foreach ($parcelas as $parcela) {
            $html .= '<tr> ';
            $html .= '<td> ' . $parcela['numero_parcela'] . '</td>';
            $html .= '<td> ' . $parcela['valor_parcela'] . '</td>';
            $html .= '<td> ' . $parcela['vencimento'] . '</td>';
            $html .= '</tr> ';
        }

        $pdf->writeHTML($html, true, false, true, false, '');

        ob_end_clean(); // Limpa o buffer de saída antes de gerar o PDF

        $pdf->Output('relatorio.pdf', 'D');
    }
}

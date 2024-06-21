//////////////////////////////// ajax delete  ////////////////////////////////
function deleteRegistroPaginacao(rotaUrl, idDoRegistro) {

    if (confirm("Deseja confirmar a exclusão do item?")) {
        $.ajax({
            url: rotaUrl,
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                id: idDoRegistro,
            },
            beforeSend: function () {
                $.blockUI({
                    message: 'Excluindo...',
                    timeout: 2000,
                });
            },
        }).done(function (data) {

            $.unblockUI();
            if (data.sucesso == true) {
                window.location.reload();
            } else {
                alert("Não foi possível excluir")
            }

        }).fail(function (data) {
            $.unblockUI();
            alert('Não foi possível buscar os dados');
        });
    }
}

//////////////////// mascaras ////////////////////////

$(".mascara_valor").mask("#.###,00", { reverse: true }).attr('maxlength', '10');

$("#cpf").mask("000.000.000-00");


////////////////////////////////////////// interação de vendas ////////////////////////////////

$(document).ready(function () {

    // seta valor unitario ouvindo o input id
    $("#id_produto").change(function () {
        var valor_produto = $(this).find('option:selected').attr('valor-prod');
        $("#valor_uni_prod").val(valor_produto);
    });

    // seta subtotal ouvindo o input quantidade
    $("#quantidade_prod").blur(function () {
        if ($("#id_produto").val()) {
            $("#subtotal_prod").val($("#valor_uni_prod").val() * $(this).val());
        }
    });

    // seta o cpf  ouvindo o input cliente
    $("#cliente_select").change(function () {
        var cpf= $(this).find('option:selected').attr('cpf-valor');
        $("#cpf_cliente").val(cpf);
    });

    // seta valor de parcelas  ouvindo o input quantidade de parcelas
    $("#quantidade_parce").blur(function () {
        let total = total_venda;
        let quantidade = $("#quantidade_parce").val();

        if (quantidade > 0 && total > 0) {
            let valor_parc = total / quantidade;
            $('#valor_parce').val(valor_parc.toFixed(2));
        }
    });

});


//////////////////////////////// produtos

const Tabela_itens = [];
const Tabela_parcelas = [];
var total_venda = 0;


function atualizar_valor_total() {
    let total = 0;
    for (var id in Tabela_itens) {
        total += parseFloat(Tabela_itens[id].subtotal);
    }
    document.getElementById("valor_total_venda").innerHTML = total.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
    $("#input_valor_total").val(total.toFixed(2));

    return total_venda = total;
}

function gerar_tabela_itens() {
    var htmlContent = '';

    Tabela_itens.forEach(function (iten, index) {

        htmlContent += '<tr id="item_' + index + '">' +
            '<td  class="text-center"><input id="nome_tr_input' + index + '" disabled value="' + iten.nome_item + '" class="form-control" type="text"></input></td>' +
            '<td class="text-center"><input id ="valor_uni_tr_input' + index + '" disabled value="' + iten.valor_uni + '" class="form-control mascara_valor" type="text"></input></td>' +
            '<td class="text-center"><input id="quant_tr_input' + index + '" onblur="editar_item_tabela(' + index + ')" value="' + iten.quantidade + '" class="form-control" type="number"></input></td>' +
            '<td class="text-center"><input id ="subtotal_tr_input' + index + '" disabled value="' + iten.subtotal + '" class="form-control subtotais_input mascara_valor" type="text"></input></td>' +
            '<td class="col-2 text-center"><a class="btn btn-danger btn-sm me-2" onclick="remover_item_tabela(' + index + ')">Excluir</a></td>' +
            '</tr>';
    }


    );
    document.getElementById('tabela_itens').innerHTML = htmlContent;
    atualizar_valor_total();

}

function adicionar_itens() {
    var item = {
        nome_item: $('#id_produto').find('option:selected').attr('nome-produto'),
        valor_uni: $('#valor_uni_prod').val(),
        quantidade: $('#quantidade_prod').val(),
        subtotal: $('#subtotal_prod').val()
    };


    if ($('#subtotal_prod').val() > 0 || $('#valor_uni_prod').val() == "") {

        Tabela_itens.push(item);

    } else {
        alert('Preencha todos os campos de itens para continuar');
    }
    gerar_tabela_itens();
}

function remover_item_tabela(id) {
    Tabela_itens.splice(id, 1);
    gerar_tabela_itens();

}

function editar_item_tabela(id) {

    Tabela_itens[id] = {
        nome_item: $('#nome_tr_input' + id).val(),
        valor_uni: $('#valor_uni_tr_input' + id).val(),
        quantidade: $('#quant_tr_input' + id).val(),
        subtotal: $('#valor_uni_tr_input' + id).val() * $('#quant_tr_input' + id).val(),
    };
    gerar_tabela_itens();
}


////////////////////////////////// parcelas
function gerar_tabela_parcelas() {
    var htmlContent = '';

    Tabela_parcelas.forEach(function (parcela, index) {

        htmlContent += '<tr id="parcela_' + index + '">' +
            '<td class="text-center">' +
            '<input id="date_tr_input_par' + index + '" onblur="editar_parcela_tabela(' + index + ');altera_demais_datas(' + index + ')" value="' + parcela.date + 
            '" class="form-control" type="date" name="vencimento['+ index+']"/>' +
            '</td>' + '<input  value="' + parcela.numero_id_parcela + '" class="form-control" type="number" name="numero_parcela['+index+']" hidden >'+
            '<td class="text-center"/>' +
            '<input class="input_parcelas_tr" id="valor_tr_input_par' + index + '" onblur="editar_parcela_tabela(' + index + '); alterar_valor_parcelas(' + index + ')" value="' + parcela.valor +
             '" class="form-control"  name="valor_parcela['+index+']" type="text"/>' +
            '</td>' +
            '<td class="col-2 text-center">' +
            '<a  class="btn btn-danger btn-sm me-2" onclick="remover_parcela_tabela(' + index + ')"> Exluir</a>' +
            '</td>' +
            '</tr>';
    }

    );
    document.getElementById('tabela_parcelas').innerHTML = htmlContent;
}

function adicionar_parcelas() {
    let valor_parc = $('#valor_parce').val();
    let date_parce = $('#date_parce').val();
    let quantidade_par = $('#quantidade_parce').val();

    for (let index = 0; index < quantidade_par; index++) {
        let parcela = {
            valor: valor_parc,
            date: date_parce,
            numero_id_parcela: index+1
        }

        let data_setada = new Date(parcela.date);
        if (index > 0) {
            let data_anterior = new Date(Tabela_parcelas[index - 1].date);
            data_setada.setMonth(data_anterior.getMonth() + 1);
            parcela.date = data_setada.toISOString().split('T')[0];
        }
        Tabela_parcelas.push(parcela);
    }
    gerar_tabela_parcelas();
}

function remover_parcela_tabela(id) {
    Tabela_parcelas.splice(id, 1);
    let numero_parcelas = Tabela_parcelas.length;
    let valor_total = total_venda;

    Tabela_parcelas.forEach(function (parcela) {
        parcela.valor = valor_total / numero_parcelas;
    });
    gerar_tabela_parcelas();
}

function editar_parcela_tabela(id) {
    let date_parce = $('#date_tr_input_par' + id).val();
    let valor_parc = $('#valor_tr_input_par' + id).val();

    Tabela_parcelas[id] = {
        date: date_parce,
        valor: valor_parc,
    };
    gerar_tabela_parcelas();
}

function altera_demais_datas(id) {

    let valor_input_date = $('#date_tr_input_par' + id).val();
    let data_input = new Date(valor_input_date);
    let data_input_mes = data_input.getMonth();
    let data_input_ano = data_input.getFullYear();

    Tabela_parcelas.forEach(function (parcela) {
        let data_setada = new Date(parcela.date);
        let data_setada_mes = data_setada.getMonth();
        let data_setada_ano = data_setada.getFullYear();


        if (data_setada < data_input && data_setada_mes == data_input_mes && data_setada_ano == data_input_ano) {
            data_setada.setMonth(data_setada.getMonth() - 1);
            parcela.date = data_setada.toISOString().split('T')[0];
        }
        if (data_setada > data_input) {
            data_setada.setMonth(data_setada.getMonth() + 1);
            parcela.date = data_setada.toISOString().split('T')[0];
        }
    });
    gerar_tabela_parcelas();
}

function alterar_valor_parcelas(id) {

    let outras_parc = Tabela_parcelas.length - 1;
    let valor_input_alterado = $('#valor_tr_input_par' + id).val();
    let valor_restante = total_venda - valor_input_alterado;

    Tabela_parcelas.forEach(function (parcela, index) {
        if (index != id) {
            parcela.valor = valor_restante / outras_parc;
            parcela.valor = parcela.valor.toFixed(2, 0)
        }
    })
    gerar_tabela_parcelas();
}
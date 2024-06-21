<?php

use App\Http\Controllers\ClientesController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProdutosController;
use App\Http\Controllers\VendaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('home');
});

Route::prefix('/home')->group(function() {
    Route::get('',[IndexController::class,'index'])->name('home');
});

//Produtos
Route::prefix('produtos')->group(function () {
    Route::get('/', [ProdutosController::class, 'index'])->name('produto.index');
    Route::get('/cadastrarProduto', [ProdutosController::class, 'cadastrarProduto'])->name('cadastrar.produto');
    Route::post('/cadastrarProduto', [ProdutosController::class, 'cadastrarProduto'])->name('cadastrar.produto');
    Route::get('/atualizarProduto/{id}', [ProdutosController::class, 'atualizarProduto'])->name('atualizar.produto');
    Route::put('/atualizarProduto/{id}', [ProdutosController::class, 'atualizarProduto'])->name('atualizar.produto');
    Route::delete('/delete', [ProdutosController::class, 'delete'])->name('produto.delete');
});


//Clientes
Route::prefix('clientes')->group(function () {
    Route::get('/', [ClientesController::class, 'index'])->name('clientes.index');
    Route::get('/cadastrarCliente', [ClientesController::class, 'cadastrarCliente'])->name('cadastrar.cliente');
    Route::post('/cadastrarCliente', [ClientesController::class, 'cadastrarCliente'])->name('cadastrar.cliente');
    Route::get('/atualizarCliente/{id}', [ClientesController::class, 'atualizarCliente'])->name('atualizar.cliente');
    Route::put('/atualizarCliente/{id}', [ClientesController::class, 'atualizarCliente'])->name('atualizar.cliente');
    Route::delete('/delete', [ClientesController::class, 'delete'])->name('cliente.delete');
});


//Vendas
Route::prefix('vendas')->group(function () {
    Route::get('/', [VendaController::class, 'index'])->name('vendas.index');
    Route::get('/cadastrarVenda', [VendaController::class, 'cadastrarVenda'])->name('cadastrar.venda');
    Route::post('/cadastrarVenda', [VendaController::class, 'cadastrarVenda'])->name('cadastrar.venda');
    Route::get('/{id}', [VendaController::class, 'gerar_pdf'])->name('pdf.venda');
    
});

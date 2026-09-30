<?php

use App\Http\Controllers\Admin\ConfiguracaoController;
use App\Http\Controllers\Admin\PainelController;
use App\Http\Controllers\Admin\ProjetoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RedirecionamentoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Público
|--------------------------------------------------------------------------
*/

Route::get('/', HomeController::class)->name('home');

// Link rastreado: registra o clique e redireciona. O {destino} é validado
// contra uma lista fixa no controller — nunca aceita URL do usuário.
Route::get('/go/{destino}', RedirecionamentoController::class)->name('go');

/*
|--------------------------------------------------------------------------
| Autenticação
|--------------------------------------------------------------------------
| Sem rota de cadastro: o único usuário é criado por comando artisan.
*/

Route::middleware('guest')->group(function () {
    Route::get('/entrar', [LoginController::class, 'mostrar'])->name('login');

    // throttle: 5 tentativas por minuto, por IP. Trava ataque de força bruta.
    Route::post('/entrar', [LoginController::class, 'entrar'])
        ->middleware('throttle:5,1');
});

Route::post('/sair', [LoginController::class, 'sair'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Painel administrativo
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->prefix('painel')->name('admin.')->group(function () {
    Route::get('/', [PainelController::class, 'index'])->name('painel');
    Route::delete('/metricas', [PainelController::class, 'zerar'])->name('metricas.zerar');

    Route::get('/projetos',                 [ProjetoController::class, 'index'])->name('projetos.index');
    Route::get('/projetos/novo',            [ProjetoController::class, 'create'])->name('projetos.create');
    Route::post('/projetos',                [ProjetoController::class, 'store'])->name('projetos.store');
    Route::get('/projetos/{projeto}/editar',[ProjetoController::class, 'edit'])->name('projetos.edit');
    Route::put('/projetos/{projeto}',       [ProjetoController::class, 'update'])->name('projetos.update');
    Route::delete('/projetos/{projeto}',    [ProjetoController::class, 'destroy'])->name('projetos.destroy');
    Route::post('/projetos/{projeto}/mover',[ProjetoController::class, 'mover'])->name('projetos.mover');

    Route::get('/configuracoes',  [ConfiguracaoController::class, 'edit'])->name('configuracoes.edit');
    Route::put('/configuracoes',  [ConfiguracaoController::class, 'update'])->name('configuracoes.update');
});

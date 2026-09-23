<?php

namespace App\Http\Controllers;

use App\Models\Configuracao;
use App\Models\Evento;
use App\Models\Projeto;
use App\Services\Rastreador;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(Request $request, Rastreador $rastreador): View
    {
        $rastreador->registrar($request, Evento::TIPO_VISITA);

        return view('home', [
            'projetos' => Projeto::visiveis()->get(),
            'contato'  => Configuracao::todas(),
        ]);
    }
}

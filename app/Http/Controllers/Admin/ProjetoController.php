<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjetoRequest;
use App\Models\Projeto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjetoController extends Controller
{
    public function index(): View
    {
        return view('admin.projetos.index', [
            'projetos' => Projeto::orderBy('ordem')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.projetos.form', [
            'projeto' => new Projeto(['publicado' => true]),
        ]);
    }

    public function store(ProjetoRequest $request): RedirectResponse
    {
        Projeto::create(
            $request->validated() + ['ordem' => Projeto::proximaOrdem()]
        );

        return redirect()
            ->route('admin.projetos.index')
            ->with('sucesso', 'Projeto criado.');
    }

    public function edit(Projeto $projeto): View
    {
        return view('admin.projetos.form', compact('projeto'));
    }

    public function update(ProjetoRequest $request, Projeto $projeto): RedirectResponse
    {
        $projeto->update($request->validated());

        return redirect()
            ->route('admin.projetos.index')
            ->with('sucesso', 'Projeto atualizado.');
    }

    public function destroy(Projeto $projeto): RedirectResponse
    {
        $projeto->delete();

        return redirect()
            ->route('admin.projetos.index')
            ->with('sucesso', 'Projeto excluído.');
    }

    /**
     * Sobe ou desce um projeto trocando a ordem com o vizinho.
     * Mais simples que reordenar a lista inteira e suficiente para
     * a quantidade de projetos que um portfólio costuma ter.
     */
    public function mover(Request $request, Projeto $projeto): RedirectResponse
    {
        $direcao = $request->input('direcao');

        $vizinho = $direcao === 'cima'
            ? Projeto::where('ordem', '<', $projeto->ordem)->orderByDesc('ordem')->first()
            : Projeto::where('ordem', '>', $projeto->ordem)->orderBy('ordem')->first();

        if ($vizinho) {
            [$projeto->ordem, $vizinho->ordem] = [$vizinho->ordem, $projeto->ordem];
            $projeto->save();
            $vizinho->save();
        }

        return back();
    }
}

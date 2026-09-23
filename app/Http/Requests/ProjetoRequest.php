<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validação do formulário de projeto.
 *
 * FormRequest em vez de validar no controller: a regra fica testável,
 * reutilizável entre criar e editar, e o controller só recebe dado limpo.
 */
class ProjetoRequest extends FormRequest
{
    public function authorize(): bool
    {
        // A rota já está atrás do middleware 'auth'.
        return true;
    }

    /**
     * Stack e métricas chegam como texto separado por vírgula (mais simples
     * de digitar que um campo dinâmico). Convertemos antes de validar.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'stack'       => $this->paraLista($this->input('stack')),
            'metricas'    => $this->paraLista($this->input('metricas')),
            'demo_aberta' => $this->boolean('demo_aberta'),
            'publicado'   => $this->boolean('publicado'),
        ]);
    }

    public function rules(): array
    {
        return [
            'titulo'      => ['required', 'string', 'max:120'],
            'descricao'   => ['required', 'string', 'max:600'],
            'stack'       => ['array', 'max:10'],
            'stack.*'     => ['string', 'max:30'],
            'metricas'    => ['array', 'max:6'],
            'metricas.*'  => ['string', 'max:40'],
            'repo'        => ['nullable', 'url', 'max:255'],
            'demo'        => ['nullable', 'url', 'max:255'],
            'demo_aberta' => ['boolean'],
            'publicado'   => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required'    => 'O projeto precisa de um título.',
            'descricao.required' => 'Escreva o que o projeto resolve.',
            'descricao.max'      => 'A descrição ficou longa demais (máx. 600 caracteres).',
            'repo.url'           => 'O link do repositório precisa ser uma URL completa (com https://).',
            'demo.url'           => 'O link da demo precisa ser uma URL completa (com https://).',
        ];
    }

    private function paraLista(mixed $valor): array
    {
        if (is_array($valor)) {
            return $valor;
        }

        if (! is_string($valor) || trim($valor) === '') {
            return [];
        }

        return collect(explode(',', $valor))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->all();
    }
}

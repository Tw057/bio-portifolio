<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;

/**
 * Cria (ou atualiza a senha do) usuário do painel.
 *
 * Existe em vez de uma tela de cadastro porque o site tem um único
 * administrador: uma rota pública de registro seria só superfície de ataque.
 */
class CriarAdmin extends Command
{
    protected $signature = 'admin:criar
                            {--email= : E-mail de acesso}
                            {--nome=  : Nome de exibição}
                            {--senha= : Senha (evite no terminal; use só em deploy automatizado)}';

    protected $description = 'Cria o usuário administrador do painel';

    public function handle(): int
    {
        $email = $this->option('email') ?: $this->ask('E-mail');
        $nome  = $this->option('nome')  ?: $this->ask('Nome', 'Admin');

        // --senha permite rodar sem terminal interativo (deploy).
        // Em uso manual, secret() esconde o que é digitado.
        $senha = $this->option('senha') ?: $this->secret('Senha (mínimo 8 caracteres)');

        $validacao = Validator::make(
            compact('email', 'nome', 'senha'),
            [
                'email' => ['required', 'email'],
                'nome'  => ['required', 'string', 'max:60'],
                'senha' => ['required', Password::min(8)],
            ]
        );

        if ($validacao->fails()) {
            foreach ($validacao->errors()->all() as $erro) {
                $this->error($erro);
            }

            return self::FAILURE;
        }

        $existente = User::where('email', $email)->first();

        // Num deploy o comando roda a cada subida: se o usuário já existe,
        // manter a senha atual evita revertê-la para a do .env toda vez.
        if ($existente && $this->option('senha')) {
            $this->info("Usuário {$email} já existe — senha mantida.");

            return self::SUCCESS;
        }

        $usuario = User::updateOrCreate(
            ['email' => $email],
            ['name' => $nome, 'password' => Hash::make($senha)]
        );

        $this->info(
            $usuario->wasRecentlyCreated
                ? "Usuário criado: {$email}"
                : "Senha atualizada para: {$email}"
        );

        $this->line('Acesse o painel em /entrar');

        return self::SUCCESS;
    }
}

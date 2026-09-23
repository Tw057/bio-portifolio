<?php

namespace Database\Seeders;

use App\Models\Configuracao;
use App\Models\Projeto;
use Illuminate\Database\Seeder;

/**
 * Leva para o banco o que hoje está escrito no Blade.
 * Usa updateOrCreate para poder rodar de novo sem duplicar.
 */
class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        Configuracao::gravar([
            'nome'              => 'Thiago',
            'cargo'             => 'Desenvolvedor de Software · PHP / Laravel',
            'whatsapp'          => '5598870241632',
            'whatsapp_mensagem' => 'Olá! Vim pelo seu site e gostaria de conversar sobre um projeto.',
            'email'             => 'waquimthiago7@gmail.com',
            'github'            => 'https://github.com/Tw057',
            'instagram'         => 'https://instagram.com/waquimthiago',
            'linkedin'          => '',
            'twitter'           => '',
            'local'             => 'Brasil · Atendimento remoto',
        ]);

        Projeto::updateOrCreate(
            ['titulo' => 'Sistema de Gestão para Clínica Veterinária'],
            [
                'descricao'   => 'Cadastro de clientes e pets, agendamento de atendimentos e histórico completo por animal. Painel com os últimos atendimentos e controle de serviços ativos.',
                'stack'       => ['PHP (POO)', 'PostgreSQL', 'Bootstrap 5', 'Docker'],
                'metricas'    => ['4 entidades', 'MVC próprio', 'No ar via Render'],
                'repo'        => 'https://github.com/Tw057/clinica-veterinaria',
                'demo'        => 'https://clinica-veterinaria-kp0e.onrender.com/',
                'demo_aberta' => true,
                'publicado'   => true,
                'ordem'       => 1,
            ]
        );
    }
}

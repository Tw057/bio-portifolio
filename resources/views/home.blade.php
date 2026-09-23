@extends('layouts.app')

{{--
  Os dados vêm do HomeController: projetos do banco, contato das configurações.
  Para editar, use o painel em /painel — não é mais preciso mexer aqui.
--}}

@section('content')

    <x-hero
        :nome="$contato['nome'] ?? 'Thiago'"
        avatar="img/avatar.jpg"
        :cargo="$contato['cargo'] ?? null"
        :whatsapp="route('go', 'whatsapp')"
        :github="($contato['github'] ?? '') ? route('go', 'github') : null"
        :linkedin="($contato['linkedin'] ?? '') ? route('go', 'linkedin') : null"
        :instagram="($contato['instagram'] ?? '') ? route('go', 'instagram') : null"
        :twitter="($contato['twitter'] ?? '') ? route('go', 'twitter') : null"
    />

    {{-- ══ DIAGNÓSTICO DE DOR ════════════════════════════════════════ --}}
    <x-diagnostico
        :telefone="$contato['whatsapp'] ?? ''"
        :dores="[
            [
                'titulo'  => 'Quero vender online e não tenho loja',
                'exemplo' => 'Hoje vendo pelo Instagram, WhatsApp ou não vendo pela internet.',
                'resumo'  => 'Colocar sua loja no ar, pronta para vender',
                'passos'  => [
                    'Entendo o que você vende, como cobra e como entrega.',
                    'Monto a loja com catálogo, carrinho, pagamento e frete calculado.',
                    'Deixo você no controle: painel para cadastrar produto e ver pedido.',
                ],
                'prazo'   => 'de 3 a 7 semanas',
            ],
            [
                'titulo'  => 'Vendo pelo direct e não dou conta',
                'exemplo' => 'Pedido no WhatsApp, anotação em caderno, cliente esperando resposta.',
                'resumo'  => 'Tirar a venda do direct e organizar o pedido',
                'passos'  => [
                    'Mapeio como o pedido chega e onde ele se perde hoje.',
                    'Crio um caminho onde o cliente escolhe e fecha sozinho.',
                    'Centralizo tudo em um painel: pedido, pagamento e status.',
                ],
                'prazo'   => 'de 2 a 5 semanas',
            ],
            [
                'titulo'  => 'Minha loja é lenta e perco venda',
                'exemplo' => 'O cliente desiste antes de terminar a compra.',
                'resumo'  => 'Acelerar a loja e destravar o carrinho',
                'passos'  => [
                    'Meço onde o cliente trava — carregamento, checkout ou pagamento.',
                    'Corrijo a causa: imagem pesada, consulta lenta, passo demais no fluxo.',
                    'Deixo medição no ar para você ver a conversão subir.',
                ],
                'prazo'   => 'de 1 a 4 semanas',
            ],
            [
                'titulo'  => 'Meu site é antigo ou não tenho nenhum',
                'exemplo' => 'Não aparece no Google, fica quebrado no celular, passa má impressão.',
                'resumo'  => 'Um site que funciona no celular e traz cliente',
                'passos'  => [
                    'Entendo quem é o seu cliente e o que ele precisa ver primeiro.',
                    'Construo o site rápido, adaptado ao celular e pronto para o Google.',
                    'Ligo os canais de contato para a visita virar conversa.',
                ],
                'prazo'   => 'de 2 a 4 semanas',
            ],
            [
                'titulo'  => 'Perco tempo com tarefa repetitiva',
                'exemplo' => 'Copiar dados de um lugar para outro, gerar o mesmo relatório toda semana.',
                'resumo'  => 'Automatizar o que hoje é feito na mão',
                'passos'  => [
                    'Mapeio o processo como ele funciona hoje, passo a passo.',
                    'Identifico o que dá para automatizar sem quebrar a rotina da equipe.',
                    'Construo o fluxo automático e deixo um painel para acompanhar.',
                ],
                'prazo'   => 'de 2 a 5 semanas',
            ],
            [
                'titulo'  => 'Meus dados vivem em planilhas soltas',
                'exemplo' => 'Cada pessoa tem a sua versão, ninguém sabe qual é a certa.',
                'resumo'  => 'Centralizar a informação em um sistema só',
                'passos'  => [
                    'Entendo quais dados existem e como eles se relacionam.',
                    'Modelo um banco de dados que reflete o seu negócio de verdade.',
                    'Migro o que já existe e entrego uma área de gestão com histórico.',
                ],
                'prazo'   => 'de 3 a 6 semanas',
            ],
            [
                'titulo'  => 'Meu sistema atual trava ou está lento',
                'exemplo' => 'Demora para carregar, cai quando tem muita gente usando.',
                'resumo'  => 'Encontrar o gargalo e corrigir a causa',
                'passos'  => [
                    'Meço onde o tempo realmente se perde — consulta, servidor ou código.',
                    'Ataco a causa: índices, cache, filas ou reescrita do trecho crítico.',
                    'Deixo monitoramento no ar para você ver a diferença e ser avisado antes.',
                ],
                'prazo'   => 'de 1 a 4 semanas',
            ],
            [
                'titulo'  => 'Preciso que dois sistemas conversem',
                'exemplo' => 'O ERP não fala com a loja, o financeiro não fala com o estoque.',
                'resumo'  => 'Integrar os sistemas sem depender de digitação',
                'passos'  => [
                    'Levanto o que cada sistema oferece — API, exportação ou banco.',
                    'Construo a ponte com tratamento de falha, para não perder dado quando um cair.',
                    'Deixo registro de tudo que passou, para auditar quando precisar.',
                ],
                'prazo'   => 'de 2 a 5 semanas',
            ],
            [
                'titulo'  => 'Quero cobrar meus clientes automaticamente',
                'exemplo' => 'Mensalidade, assinatura, cobrança recorrente controlada na mão.',
                'resumo'  => 'Automatizar a cobrança de ponta a ponta',
                'passos'  => [
                    'Defino as regras: ciclos, valores, o que acontece quando falha.',
                    'Integro o meio de pagamento com confirmação automática.',
                    'Entrego painel de inadimplência e aviso automático para o cliente.',
                ],
                'prazo'   => 'de 3 a 6 semanas',
            ],
            [
                'titulo'  => 'Tenho uma ideia e não sei por onde começar',
                'exemplo' => 'Sei o problema que quero resolver, mas não sei o caminho técnico.',
                'resumo'  => 'Transformar a ideia em um primeiro sistema no ar',
                'passos'  => [
                    'Conversamos para separar o essencial do que pode esperar.',
                    'Defino a arquitetura e o menor sistema que já resolve de verdade.',
                    'Entrego em partes, para você validar com gente real antes de investir mais.',
                ],
                'prazo'   => 'de 4 a 8 semanas',
            ],
        ]"
    />

    {{-- ══ NÚMEROS ═══════════════════════════════════════════════════ --}}
    {{--
      Desativado até haver números reais para mostrar.
      Para reativar: descomente e troque pelos seus valores verdadeiros.

    <x-stats :itens="[
        ['valor' => '3',    'sufixo' => '+',  'rotulo' => 'Anos com PHP/Laravel'],
        ['valor' => '12',   'sufixo' => '',   'rotulo' => 'Projetos entregues'],
        ['valor' => '99.9', 'sufixo' => '%',  'rotulo' => 'Uptime médio'],
        ['valor' => '24',   'sufixo' => 'h',  'rotulo' => 'Tempo de resposta'],
    ]" />
    --}}

    {{-- ══ PROJETOS ══════════════════════════════════════════════════ --}}
    @if ($projetos->isNotEmpty())
    <section id="projetos" class="relative mx-auto max-w-6xl scroll-mt-4 px-5 py-16 sm:px-6 sm:py-24 lg:px-8 lg:py-32">

        <header class="max-w-2xl">
            <p class="font-mono text-[12px] uppercase tracking-[0.2em] text-accent">Portfólio</p>
            <h2 class="mt-3 text-[28px] font-bold tracking-tight text-white sm:mt-4 sm:text-4xl">
                Alguns dos meus projetos
            </h2>
            <p class="mt-4 text-[15px] leading-relaxed text-slate-400 sm:mt-5 sm:text-base">
                Sistemas que construí do banco de dados à interface. Não precisa acreditar
                na minha palavra: abre a demo e usa como se fosse seu.
            </p>
        </header>

        {{-- O grid acompanha a quantidade: com poucos projetos, cards largos
             valem mais que colunas vazias. --}}
        @php
            $colunas = match (true) {
                count($projetos) === 1 => 'max-w-xl',
                count($projetos) === 2 => 'sm:grid-cols-2 max-w-4xl',
                default                 => 'sm:grid-cols-2 lg:grid-cols-3',
            };
        @endphp

        <div class="mt-10 grid gap-5 sm:mt-14 sm:gap-6 {{ $colunas }}">
            @foreach ($projetos as $projeto)
                <x-project-card
                    :titulo="$projeto->titulo"
                    :descricao="$projeto->descricao"
                    :stack="$projeto->stack ?? []"
                    :metricas="$projeto->metricas ?? []"
                    :repo="$projeto->repo"
                    :demo="$projeto->demo"
                    :demo-aberta="$projeto->demo_aberta"
                />
            @endforeach
        </div>

    </section>
    @endif

    {{-- ══ RODAPÉ ════════════════════════════════════════════════════ --}}
    <x-rodape
        :nome="$contato['nome'] ?? 'Thiago'"
        :cargo="$contato['cargo'] ?? null"
        :email="$contato['email'] ?? ''"
        :local="$contato['local'] ?? 'Brasil · Atendimento remoto'"
        :whatsapp="route('go', 'whatsapp')"
        :emailUrl="route('go', 'email')"
        :github="($contato['github'] ?? '') ? route('go', 'github') : null"
        :linkedin="($contato['linkedin'] ?? '') ? route('go', 'linkedin') : null"
        :instagram="($contato['instagram'] ?? '') ? route('go', 'instagram') : null"
        :twitter="($contato['twitter'] ?? '') ? route('go', 'twitter') : null"
    />

    {{-- ══ BARRA FIXA DE CONVERSÃO ═══════════════════════════════════ --}}
    <x-cta-fixo :whatsapp="route('go', 'whatsapp')" />

@endsection

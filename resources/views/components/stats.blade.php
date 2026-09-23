@props(['itens' => []])

<section aria-label="Números" class="border-y border-line/60 bg-panel/20">
    <div class="mx-auto max-w-6xl px-6 py-14 lg:px-8">
        <dl class="grid grid-cols-2 gap-8 sm:gap-10 lg:grid-cols-4">
            @foreach ($itens as $item)
                <div class="text-center lg:text-left">
                    <dt class="sr-only">{{ $item['rotulo'] }}</dt>
                    <dd>
                        <span class="block text-3xl font-bold tracking-tight text-white sm:text-4xl">
                            {{-- data-contador é lido pelo JS; o texto inicial é o fallback sem script --}}
                            <span data-contador="{{ $item['valor'] }}">{{ $item['valor'] }}</span><span class="text-accent">{{ $item['sufixo'] ?? '' }}</span>
                        </span>
                        <span class="mt-2 block text-[13.5px] text-slate-500">{{ $item['rotulo'] }}</span>
                    </dd>
                </div>
            @endforeach
        </dl>
    </div>
</section>

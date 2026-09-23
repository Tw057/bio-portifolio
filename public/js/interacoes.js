/**
 * Interações do portfólio — vanilla JS, sem dependências.
 *
 * 1. Terminal com efeito de digitação
 * 2. Contadores animados ao entrar na tela
 * 3. Diagnóstico de dor com mensagem pronta para o WhatsApp
 * 4. Barra fixa de conversão
 *
 * Tudo respeita prefers-reduced-motion: quem desativou animação
 * recebe o estado final direto, sem movimento.
 */
(() => {
    'use strict';

    const semMovimento = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* ─────────────────────────────────────────────────────────────
       1. TERMINAL — digita o código linha por linha
       ───────────────────────────────────────────────────────────── */
    const initTerminal = () => {
        const alvo = document.querySelector('[data-typewriter]');
        if (!alvo) return;

        const fonte = document.querySelector('[data-typewriter-source]');
        if (!fonte) return;

        // Em um <template>, os filhos vivem em .content (DocumentFragment),
        // não em .children — que vem sempre vazio.
        const raiz = fonte.content ?? fonte;
        const linhas = Array.from(raiz.children);
        if (!linhas.length) return;

        if (semMovimento) {
            linhas.forEach((l) => alvo.appendChild(l.cloneNode(true)));
            return;
        }

        alvo.textContent = '';
        let i = 0;

        const escreverLinha = () => {
            if (i >= linhas.length) return;

            const original = linhas[i];
            const clone = original.cloneNode(true);
            clone.style.opacity = '0';
            clone.style.transform = 'translateY(4px)';
            clone.style.transition = 'opacity .18s ease, transform .18s ease';
            alvo.appendChild(clone);

            requestAnimationFrame(() => {
                clone.style.opacity = '1';
                clone.style.transform = 'none';
            });

            i++;
            // Linhas vazias passam rápido; linhas com código têm pausa proporcional.
            const texto = original.textContent.trim();
            const espera = texto.length === 0 ? 60 : Math.min(70 + texto.length * 7, 260);
            setTimeout(escreverLinha, espera);
        };

        // Só começa quando o terminal entra na tela.
        const observer = new IntersectionObserver((entradas, obs) => {
            entradas.forEach((entrada) => {
                if (entrada.isIntersecting) {
                    setTimeout(escreverLinha, 450);
                    obs.disconnect();
                }
            });
        }, { threshold: 0.25 });

        observer.observe(alvo);
    };

    /* ─────────────────────────────────────────────────────────────
       2. CONTADORES — sobem de 0 até o valor ao entrar na tela
       ───────────────────────────────────────────────────────────── */
    const initContadores = () => {
        const contadores = document.querySelectorAll('[data-contador]');
        if (!contadores.length) return;

        const animar = (el) => {
            const destino = parseFloat(el.dataset.contador);
            const decimais = (el.dataset.contador.split('.')[1] || '').length;
            const duracao = 1400;

            if (semMovimento) {
                el.textContent = destino.toFixed(decimais);
                return;
            }

            const inicio = performance.now();

            const passo = (agora) => {
                const t = Math.min((agora - inicio) / duracao, 1);
                // easeOutExpo: rápido no começo, desacelera no fim
                const eased = t === 1 ? 1 : 1 - Math.pow(2, -10 * t);
                el.textContent = (destino * eased).toFixed(decimais);
                if (t < 1) requestAnimationFrame(passo);
            };

            requestAnimationFrame(passo);
        };

        const observer = new IntersectionObserver((entradas, obs) => {
            entradas.forEach((entrada) => {
                if (entrada.isIntersecting) {
                    animar(entrada.target);
                    obs.unobserve(entrada.target);
                }
            });
        }, { threshold: 0.5 });

        contadores.forEach((c) => observer.observe(c));
    };

    /* ─────────────────────────────────────────────────────────────
       3. DIAGNÓSTICO — a pessoa escolhe a dor, recebe o caminho
       ───────────────────────────────────────────────────────────── */
    const initDiagnostico = () => {
        const raiz = document.querySelector('[data-diagnostico]');
        if (!raiz) return;

        const dados = (() => {
            const tag = raiz.querySelector('[data-diagnostico-dados]');
            try {
                return JSON.parse(tag?.textContent || '[]');
            } catch {
                return [];
            }
        })();
        if (!dados.length) return;

        const telefone   = raiz.dataset.telefone || '';
        const botoes     = Array.from(raiz.querySelectorAll('[data-dor]'));
        const painel     = raiz.querySelector('[data-resposta]');
        const elTitulo   = raiz.querySelector('[data-resposta-titulo]');
        const elPassos   = raiz.querySelector('[data-resposta-passos]');
        const elPrazo    = raiz.querySelector('[data-resposta-prazo]');
        const elWhatsapp = raiz.querySelector('[data-whatsapp]');

        const selecionar = (indice) => {
            const item = dados[indice];
            if (!item) return;

            botoes.forEach((b) => {
                b.setAttribute('aria-expanded', String(Number(b.dataset.indice) === indice));
            });

            elTitulo.textContent = item.resumo;

            elPassos.innerHTML = '';
            item.passos.forEach((passo, i) => {
                const li = document.createElement('li');
                li.className = 'flex items-start gap-3 text-[14.5px] leading-relaxed text-slate-400';
                li.innerHTML =
                    `<span class="mt-[3px] font-mono text-[11px] text-accent" aria-hidden="true">0${i + 1}</span>` +
                    `<span></span>`;
                li.lastElementChild.textContent = passo;
                elPassos.appendChild(li);
            });

            elPrazo.textContent = item.prazo;

            // A mensagem vem dos dados: cada dor tem a sua redação.
            elWhatsapp.href = `https://wa.me/${telefone}?text=${encodeURIComponent(item.mensagem)}`;

            const jaEstavaAberto = ! painel.hidden;
            painel.hidden = false;

            // No celular a resposta abre abaixo de uma lista longa: sem rolar,
            // a pessoa clica e parece que nada aconteceu. Levamos o painel ao
            // topo da tela apenas na primeira abertura — ao trocar de dor com o
            // painel já visível, mover a página de novo seria desorientador.
            requestAnimationFrame(() => {
                const retangulo = painel.getBoundingClientRect();
                const foraDaTela = retangulo.top < 0 || retangulo.bottom > window.innerHeight;

                if (! foraDaTela) return;

                const ehCelular = window.matchMedia('(max-width: 640px)').matches;

                painel.scrollIntoView({
                    behavior: semMovimento ? 'auto' : 'smooth',
                    // No celular o painel é alto: alinhar pelo topo mostra o
                    // título e os passos. No desktop, 'nearest' move o mínimo.
                    block: ehCelular && ! jaEstavaAberto ? 'start' : 'nearest',
                });
            });
        };

        botoes.forEach((botao) => {
            botao.addEventListener('click', () => selecionar(Number(botao.dataset.indice)));
        });
    };

    /* ─────────────────────────────────────────────────────────────
       4. CTA FIXO — surge quando o botão principal sai da tela
       ───────────────────────────────────────────────────────────── */
    const initCtaFixo = () => {
        const barra = document.querySelector('[data-cta-fixo]');
        if (!barra) return;

        // Referência: o CTA do Hero. Enquanto ele estiver visível,
        // a barra seria redundante.
        const referencia = document.querySelector('[data-cta-referencia]');
        if (!referencia) return;

        barra.hidden = false;

        const observer = new IntersectionObserver(
            ([entrada]) => {
                if (entrada.isIntersecting) {
                    barra.removeAttribute('data-visivel');
                } else {
                    barra.setAttribute('data-visivel', '');
                }
            },
            { threshold: 0 }
        );

        observer.observe(referencia);
    };

    /* ───────────────────────────────────────────────────────────── */
    const iniciar = () => {
        initTerminal();
        initContadores();
        initDiagnostico();
        initCtaFixo();
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', iniciar);
    } else {
        iniciar();
    }
})();

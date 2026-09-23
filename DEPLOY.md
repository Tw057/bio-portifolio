# Publicar no Render

Guia para colocar o site no ar de graça. Leva uns 20 minutos na primeira vez.

---

## Antes de começar

Confirme o número do WhatsApp. Abra o site local, clique em **Fazer um orçamento**
e veja se abre a sua conversa. Se der "número inválido", corrija pelo painel em
`/painel/configuracoes` antes de publicar — é o botão mais importante do site.

---

## 1. Subir o código para o GitHub

O Render lê o código de um repositório. Na pasta do projeto:

```bash
git init
git add .
git commit -m "Portfólio: site, painel administrativo e métricas"
```

Crie um repositório vazio em github.com (pode ser privado) e conecte:

```bash
git remote add origin https://github.com/Tw057/portfolio.git
git branch -M main
git push -u origin main
```

---

## 2. Criar o serviço no Render

1. Entre em [render.com](https://render.com) e faça login com o GitHub.
2. **New +** → **Blueprint**.
3. Escolha o repositório que você acabou de subir.
4. O Render lê o `render.yaml` e mostra o que vai criar:
   um serviço web e um banco Postgres. Confirme.

Ele vai pedir os valores marcados como `sync: false`:

| Variável | O que colocar |
|---|---|
| `APP_URL` | deixe em branco agora; você preenche no passo 4 |
| `ADMIN_EMAIL` | seu e-mail de acesso ao painel |
| `ADMIN_PASSWORD` | uma senha forte, mínimo 8 caracteres |

5. **Apply**. O primeiro build leva de 5 a 10 minutos.

---

## 3. Acompanhar o build

Na aba **Logs** você vai ver, em ordem:

```
==> Preparando a aplicação
==> Migrando o banco
==> Semeando dados iniciais
==> Garantindo usuário administrador
==> Otimizando
==> Subindo na porta 10000
```

Se parar em algum ponto, o erro aparece ali. Os mais comuns:

- **"could not find driver"** — o Postgres ainda não subiu. Espere e faça
  *Manual Deploy* de novo.
- **"No application encryption key"** — a `APP_KEY` não foi gerada.
  Vá em Environment e confirme que ela existe.

---

## 4. Ajustar a URL

Quando o serviço subir, o Render te dá uma URL como
`https://portfolio-thiago.onrender.com`.

Vá em **Environment**, preencha `APP_URL` com essa URL exata (com `https://`)
e salve. O serviço reinicia sozinho.

Isso importa: sem `APP_URL` correta, as meta tags de Open Graph apontam para
o endereço errado e o preview do link não funciona.

---

## 5. Conferir

- Abra a URL — o site deve carregar.
- Acesse `SUA_URL/entrar` e entre com `ADMIN_EMAIL` e `ADMIN_PASSWORD`.
- Clique no botão do WhatsApp e veja se abre a sua conversa.
- Teste o preview do link: cole a URL em
  [opengraph.xyz](https://www.opengraph.xyz) e veja se o cartão aparece.

---

## 6. Colocar na bio do Instagram

Copie a URL e cole no campo de site do seu perfil.

Dica: no Instagram, o texto acima do link vende mais que o link.
Algo como *"Sistemas, sites e lojas sob medida ↓"* funciona melhor que
só deixar a URL solta.

---

## O que esperar da hospedagem gratuita

**O serviço hiberna após 15 minutos sem visitas.** O próximo acesso leva
de 30 a 60 segundos enquanto o container acorda.

Isso é real e não tem como evitar no plano gratuito. Duas saídas:

- **Ping automático:** crie conta em [uptimerobot.com](https://uptimerobot.com)
  (grátis), adicione um monitor HTTP para a sua URL a cada 5 minutos.
  Mantém o serviço acordado quase sempre.
- **Plano pago:** US$ 7/mês no Render remove a hibernação.

**O banco Postgres gratuito expira em 30 dias.** O Render avisa por e-mail.
Antes disso, exporte os dados:

```bash
# no Shell do Render (aba Shell do serviço)
php artisan tinker --execute="
  file_put_contents('projetos.json', App\Models\Projeto::all()->toJson());
"
```

Depois crie um banco novo e rode o seeder de novo.

---

## Atualizar o site depois

Qualquer mudança no código:

```bash
git add .
git commit -m "descrição da mudança"
git push
```

O Render detecta o push e refaz o deploy sozinho.

**Para trocar textos, projetos ou contato, não precisa de deploy** — use o
painel em `SUA_URL/painel`.

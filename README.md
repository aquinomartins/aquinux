# Ergastério 2026

Documentação central do Ergastério, consolidando a mecânica principal do sistema e apontando para módulos específicos quando necessário.

## Mecânica unificada do Ergastério

- **Usuários**
  - Conjunto de agentes individuais (participantes/atores) que interagem entre si e com os ativos do sistema.

- **Ações**
  - Mintar NFTs.
  - Excluir NFTs.
  - Trocar NFTs.
  - Negociar NFTs.
  - Negociar BTC.
  - Prover ou retirar liquidez.
  - Operar moldura/chassi/galeria.
  - Participar de mercados preditivos.
  - Formar coalizões.
  - Estabelecer parcerias.

- **Payoff**
  - **R$** é a moeda universal de troca no sistema.

## Roteamento web (front controller)

- O deploy deve apontar o **document root para `public/`**.
- O ponto único de entrada é `public/index.php`, que resolve rotas HTML e mantém compatibilidade com endpoints existentes em `api/*.php`.
- Para Apache, use `public/.htaccess` (rewrite para o front controller).

## Rotas server-side (Front Controller)

Foram adicionadas rotas server-side no front controller para evitar quebra no refresh (F5):

- `GET /trending` → `app/controllers/TrendingController.php` + `app/views/pages/trending.php`
- `GET /mercados-lmsr` → `app/controllers/MercadosLmsrController.php` + `app/views/pages/mercados-lmsr.php`

O mapa de rotas está em `app/routes.php` e o front controller em `public/index.php`.

## Rewrite / Deploy

### Apache

- `/.htaccess`: mantém arquivos/diretórios existentes e redireciona rotas amigáveis para `public/index.php`.
- `/public/.htaccess`: aplica fallback interno para `index.php` quando a rota não for arquivo/diretório real.

### Nginx (snippet equivalente)

```nginx
location / {
    try_files $uri $uri/ /public/index.php?$query_string;
}
```

> Observação: este snippet deve ser aplicado na configuração do servidor (não versionada no projeto).

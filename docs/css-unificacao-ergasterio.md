# Unificação de CSS — APP Ergastério

## Inventário de arquivos `.css`

- `styles.css`
- `styles2.css`
- `responsive-layout.css`
- `mercados_lmsr/styles.css`
- `mercadoPreditivo/assets/styles.css`
- `cmss/styles.css`
- `cmss/estilos/www.css`
- `cmss/estilos/www2.css`
- `cmss/estilos/fgx0.css`
- `cmss/estilos/mxk5.css`
- `cmss/estilos/sec-3-6.css`
- `cmss/estilos/font-awesome.min.css`

## Análise

- O app possuía múltiplos pontos de entrada carregando CSS em ordens diferentes.
- Havia duplicidade de links `<link rel="stylesheet">` entre módulos principais e mercados.
- A ordem de carga dos estilos foi preservada para reduzir risco de regressão visual.

## Estratégia de unificação

- Criado um único ponto de entrada: `ergasterio-unificado.css`.
- Esse arquivo centraliza toda a pilha visual com `@import` ordenado por domínio:
  1. Núcleo do app
  2. Camada institucional (CMSS)
  3. Módulos de mercado
- Todos os templates/páginas atualizados para carregar apenas esse CSS unificado.

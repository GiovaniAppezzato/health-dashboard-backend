# Health Dashboard MVP

## Objetivo

Desenvolver um MVP (Produto Mínimo Viável) de um aplicativo mobile focado no acompanhamento de saúde do usuário. O aplicativo deve consumir dados básicos de saúde, processá-los e devolver recomendações práticas.

## 1. Stack Tecnológica Obrigatória

- **Mobile (Frontend):** React Native ou Expo
- **Backend (API):** PHP / Laravel 10+
- **Banco de Dados:** MySQL ou PostgreSQL
- **Inteligência Artificial:** Integração com alguma API de LLM (OpenAI, Anthropic, etc.)

---

## 2. Docker

Crie um ambiente Docker completo para executar toda a aplicação.

Inclua todos os serviços necessários: backend, banco de dados e quaisquer dependências.

Forneça um arquivo `docker-compose.yml` que suba toda a aplicação com o único comando:

```bash
docker compose up
```

A aplicação deve estar acessível na porta local **9000** (ajuste os mapeamentos de porta adequadamente no arquivo compose dependendo do servidor utilizado).

---

## 3. Funcionalidades Esperadas

### 3.1 Entrada de Dados

Uma interface simples onde o usuário possa inserir (ou simular a entrada de) biomarcadores básicos como:

- Horas de sono
- Nível de Glicose
- Frequência Cardíaca (HRV)

### 3.2 Processamento via IA

O backend deve receber esses dados e enviá-los para uma API de IA com um prompt que solicite a interpretação dos biomarcadores.

### 3.3 Visualização

O aplicativo deve exibir um dashboard simples mostrando os dados inseridos pelo usuário e uma lista de **3 recomendações de hábitos diários** geradas pela IA.

### 3.4 Diferencial (Não obrigatório)

Caso queira ir além do escopo base, sugira e implemente uma feature adicional que faça sentido dentro do contexto de saúde do usuário.

A feature deve utilizar IA como parte ativa na experiência do usuário final.

No vídeo de demonstração, explique brevemente o porquê da proposta, como foi implementada e o papel da IA.

---

## 4. Arquitetura de Backend

### 4.1 API RESTful

Utilize o padrão RESTful para todas as rotas da API (Verbos HTTP corretos, URIs semânticas e respostas padronizadas com status HTTP adequados).

### 4.2 Layered Architecture

Estruture o código em camadas com separação clara de responsabilidades:

**Controller**

Recebe requisições HTTP, valida o input e delega ao service (sem lógica de negócio).

**Service**

Contém toda a lógica de negócio, orquestra chamadas ao repositório e à API de IA.

**Repository**

Abstrai o acesso ao banco de dados, isolando as queries.

---

## 5. Requisitos de Qualidade

- Aplicação de princípios SOLID e Clean Code no backend (Laravel) — nomes expressivos, funções com responsabilidade única, sem acoplamento desnecessário.
- Arquitetura limpa e organização de componentes no React Native.
- Implementação de pelo menos um teste automatizado essencial na API.

---

## 6. Uso de Ferramentas de IA

Encorajamos fortemente o uso de ferramentas de IA durante o desenvolvimento (Cursor, GitHub Copilot, ChatGPT, Claude Code, v0.dev).

Queremos avaliar sua capacidade de orquestrar essas ferramentas para entregar um código de alta qualidade com rapidez.

# API Project - Task Management

API Project é uma API Restful simples de gerenciamento de tarefas com validação OAuth desenvolvido com Laravel. Ele permite que listem, visualizem, criem, atualizem e excluam tarefas.

![Laravel](https://img.shields.io/badge/Laravel-v8.x-orange) ![PHP](https://img.shields.io/badge/PHP-%3E=7.3-blue)

## 🚀 Instalação

Siga os passos abaixo para instalar e executar o projeto em seu ambiente local.

### Pré-requisitos

- PHP >= 7.3
- Composer
- MySQL | Postgres | SQLServer

### Passo 1: Clonar o repositório

```bash
git clone https://github.com/bmangilli/api_project.git
cd api_project
```

### Passo 2: Instalar dependências

```bash
composer install
```

### Passo 3: Configurar variáveis de ambiente

Copie o arquivo .env.example para um novo arquivo chamado .env e configure as variáveis de ambiente, como a conexão com o banco de dados.

```bash
cp .env.example .env
```

### Passo 4: Gerar chave de aplicação

```bash
php artisan key:generate
```

### Passo 5: Executar migrações

```bash
php artisan migrate
```

### Passo 6: Iniciar servidor de desenvolvimento

```bash
php artisan serve
```

Agora você pode acessar a API no endereço `http://127.0.0.1:8000`.

📚 Documentação
Documentação detalhada da API está disponível em [Wiki](https://github.com/bmangilli/api_project/wiki).

# Variáveis do projeto
sail := "./vendor/bin/sail"

# Exibe o guia de comandos automaticamente (substitui o antigo 'make help')
default:
    @just --list

# ====================================
# DOCKER / PODMAN
# ====================================

# Realiza a configuração do ambiente do projeto detectando Docker ou Podman
setup:
    #!/usr/bin/env bash
    set -euo pipefail

    # Detecta o gerenciador de contêineres instalado
    if command -v docker &> /dev/null; then
        CONTAINER_ENGINE="docker"
    elif command -v podman &> /dev/null; then
        CONTAINER_ENGINE="podman"
    else
        echo "Erro: Nem o Docker nem o Podman foram encontrados no sistema."
        exit 1
    fi

    echo "Gerenciador detectado: $CONTAINER_ENGINE"
    echo "Instalando dependências do Composer via $CONTAINER_ENGINE..."
    $CONTAINER_ENGINE run --rm -u "$(id -u):$(id -g)" -v "$(pwd):/var/www/html" -w /var/www/html composer:latest composer install --ignore-platform-reqs

    echo "Configurando o arquivo .env..."
    cp -n .env.example .env || true

    echo "Subindo os contêineres do Sail..."
    {{sail}} up -d

    echo "Aguardando a inicialização do banco de dados..."
    sleep 5

    echo "Gerando chave da aplicação..."
    {{sail}} artisan key:generate

    echo "Executando migrações e populando o banco de dados..."
    {{sail}} artisan migrate --seed

    echo "Instalação concluída com sucesso! Pode acessar o projeto."

# Inicia os contêineres do Docker em background (-d)
up:
    {{sail}} up -d

# Para e remove os contêineres do projeto
down:
    {{sail}} down

# Reconstrói as imagens do Docker do zero (sem usar cache)
build:
    {{sail}} build --no-cache

# Exibe e acompanha os logs dos contêineres em tempo real
logs:
    {{sail}} logs -f

# Limpa contêineres, redes e volumes parados/não utilizados
prune:
    {{sail}} prune

# Lista o status atual dos contêineres
ps:
    {{sail}} ps

# ====================================
# LARAVEL ARTISAN
# ====================================

# Abre o terminal interativo do Laravel (Tinker)
tinker:
    {{sail}} tinker

# Roda qualquer comando Artisan livre (ex: just art route:list ou just art make:model User)
art +comando:
    {{sail}} artisan {{comando}}

# Mostra todas as rotas criadas do projeto
routes:
    {{sail}} artisan route:list

# Roda todos os testes criados
run_tests:
    {{sail}} artisan test

# ====================================
# BANCO DE DADOS
# ====================================

# Sobe os contêineres, aguarda 5s e inicializa o banco de dados
start: up
    @echo "Aguardando a inicialização do banco de dados..."
    sleep 5
    {{sail}} artisan migrate
    {{sail}} artisan db:seed

# Roda as migrações pendentes
migrate:
    {{sail}} artisan migrate

# Roda apenas os seeders para popular as tabelas
seed:
    {{sail}} artisan db:seed

# Apaga todas as tabelas (DROP) e roda as migrações do zero
reset:
    {{sail}} artisan migrate:fresh

# Limpa o banco de dados (DROP) e recria tudo com seeders
clear_and_migrate:
    @echo "Limpando o banco de dados e injetando dados de teste (Seeders)..."
    {{sail}} artisan migrate:fresh --seed
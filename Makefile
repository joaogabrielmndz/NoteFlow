# ================
# Automation
# ================

.PHONY: help setup up down build logs prune ps tinker art routes run_tests start reset clear_and_migrate seed migrate

SAIL := ./vendor/bin/sail 

# ====================================
# Guia de Comandos (Help)
# ====================================

help:
	@echo "Guia de comandos do Projeto:"
	@echo "---------------------------------------------------------"
	@echo "[DOCKER]"
	@echo "  make setup            - Realiza a configuração do ambiente do projeto"
	@echo "  make up               - Inicia os contentores do Docker em background (-d)"
	@echo "  make down             - Para e remove os contentores do projeto"
	@echo "  make build            - Reconstrói as imagens do Docker do zero (sem usar cache)"
	@echo "  make logs             - Exibe e acompanha os logs dos contentores em tempo real"
	@echo "  make prune            - Limpa contentores, redes e volumes parados/não utilizados"
	@echo "  make ps               - Lista o status atual dos contentores"
	@echo "---------------------------------------------------------"
	@echo "[LARAVEL ARTISAN]"
	@echo "  make tinker           - Abre o terminal interativo do Laravel (Tinker)"
	@echo "  make art c=           - Roda qualquer comando Artisan livre (ex: make art c=\"route:list\")"
	@echo "  make routes           - Mostra todas as rotas criadas do projeto"
	@echo "  make run_tests        - Roda todos os testes criados"
	@echo "---------------------------------------------------------"
	@echo "[BASE DE DADOS]"
	@echo "  make migrate          - Roda as migrações pendentes"
	@echo "  make seed             - Roda apenas os seeders para popular as tabelas"
	@echo "  make reset            - Apaga todas as tabelas (DROP) e roda as migrações do zero"
	@echo "  make clear_and_migrate- Limpa a base de dados (DROP) e recria tudo com seeders"
	@echo "  make start            - Sobe os contentores, aguarda 5s e inicializa a base de dados"
	@echo "---------------------------------------------------------"

# ====================================
# Sail commands
# ====================================

setup:
	@echo "A instalar dependências do Composer via Docker..."
	docker run --rm -u "$(shell id -u):$(shell id -g)" -v "$(shell pwd):/var/www/html" -w /var/www/html composer:latest composer install --ignore-platform-reqs
	@echo "A configurar o arquivo .env..."
	cp .env.example .env
	@echo "A subir os contentores do Sail..."
	$(SAIL) up -d
	@echo "A aguardar a inicialização da base de dados..."
	@sleep 5
	@echo "A gerar chave da aplicação..."
	$(SAIL) artisan key:generate
	@echo "A executar migrações e popular a base de dados..."
	$(SAIL) artisan migrate --seed
	@echo "Instalação concluída com sucesso! Pode aceder ao projeto."

up: 
	$(SAIL) up -d 

down:
	$(SAIL) down 

build:
	$(SAIL) build --no-cache 

logs:
	$(SAIL) logs -f

prune:
	$(SAIL) prune

ps: 
	$(SAIL) ps

# ====================================
# Artisan
# ====================================

tinker:
	$(SAIL) tinker 

art:
	$(SAIL) artisan $(c)

routes:
	$(SAIL) artisan route:list

run_tests:
	$(SAIL) artisan test

# ====================================
# Artisan BD
# ====================================

start: up 
	@echo "A aguardar a inicialização da base de dados..."
	@sleep 5
	$(SAIL) artisan migrate 
	$(SAIL) artisan db:seed

reset:
	$(SAIL) artisan migrate:fresh

clear_and_migrate:
	@echo "A limpar a base de dados e a injetar dados de teste (Seeders)..."
	$(SAIL) artisan migrate:fresh --seed
	
seed:
	$(SAIL) artisan db:seed

migrate:
	$(SAIL) artisan migrate
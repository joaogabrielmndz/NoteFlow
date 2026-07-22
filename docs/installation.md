# ⚙️ Como instalar o Noteflow

## Sumário
-   **Pre-requisitos:** Definir quais são os pre-requistos necessarios para a instalação do projeto
-   **Instalação Rápida:** Guiar o leitor para, realizar a clonagem do repositorio e copiar o arquivo .env.example para .env
-   **Inicialização:** Como inicializar o projeto

## Pre-requisitos
Este projeto utiliza Laravel Sail (Docker) para garantir um ambiente padronizado. Não é necessário ter o PHP ou Base de Dados instalados na sua máquina, apenas o Docker e o utilitário make.

- 🐋 **Docker:** (seja Desktop no Windows, ou Engine em ambientes Unix-like, como Linux e Mac)
- ⚙️ **make:** Utilitário do ``just`` para automatização de tarefas com o arquivo ``justfile`` que se encontra na raiz do projeto

## Instalação
Clonar o repositorio 
```bash
git clone [https://github.com/joaogabrielmndz/NoteFlow.git](https://github.com/joaogabrielmndz/NoteFlow.git)
cd noteflow
```

## Inicialização 
Rode o comando ``just setup`` para inicializar todo o setup do projeto
```bash
make setup
```


**O que esse comando faz?**
-   [x] Baixa as dependências como o ``composer install`` para inicializar a pasta ``vendor/``
-   [x] Configura as variaveis de ambiente do arquivo ``.env.example`` para ``.env``
-   [x] Sobe os serviços, inicializa os containers do Laravel Sail, PHP e PostgreSQL em modo background ``-d``
-   [x] Gera a chave da aplicação
-   [x] Prepara o banco de dados com ``migrate``
-   [x] Popula o banco de dados com seeders com dados falsos para teste
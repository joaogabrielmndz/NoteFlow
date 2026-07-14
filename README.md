# 🌿 noteFlow

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white)

Um sistema dinâmico de gestão de inventário e base de dados de perfumaria. O noteFlow permite aos utilizadores gerir as suas coleções de fragrâncias e, futuramente, receber recomendações inteligentes baseadas no clima, ocasião e na sua própria pirâmide olfativa utilizando Inteligência Artificial.

Este é um projeto de natureza académica desenvolvido por João Gabriel e está totalmente aberto a contribuições da comunidade open-source.

---

## 🚀 Funcionalidades (MVP)

* **Catálogo Global de Perfumes:** Base de dados com informações detalhadas (concentração, ano de lançamento, público-alvo).
* **Gestão de Inventário:** Controle do volume restante (`remaining_ml`), código de lote e data de aquisição. O sistema altera o status do frasco automaticamente para "Finished" quando esvaziado.
* **Pirâmide Olfativa Detalhada:** Relacionamento N:M complexo que mapeia exatamente se uma nota atua no topo, coração ou fundo (base) de cada fragrância.
* **Automação de Ambiente:** Configuração 100% conteinerizada via Laravel Sail com *wrapper* em Makefile para execução com um clique.

---

## 🛠️ Arquitetura de Dados

O domínio principal do projeto é composto por quatro entidades centrais e relacionamentos otimizados no Eloquent:
* `User`: Dono do inventário.
* `Perfume`: O catálogo imutável.
* `Note`: Dicionário global de notas olfativas e famílias (Amadeirado, Cítrico, Doce, etc.).
* `Inventory` e `note_perfume`: Tabelas de cruzamento que detêm a lógica de posse de estado do sistema.

---

## ⚙️ Como Rodar o Projeto

Este projeto utiliza **Laravel Sail** (Docker) para garantir um ambiente padronizado. Não é necessário ter o PHP ou Base de Dados instalados na sua máquina, apenas o Docker e o utilitário `make`.

### 1. Pré-requisitos
* [Docker Desktop](https://www.docker.com/products/docker-desktop/) (ou Docker Engine no Linux)
* Utilitário `make` instalado no host.

### 2. Instalação

Clone o repositório e aceda à pasta do projeto:
```bash
git clone [https://github.com/seu-usuario/noteflow.git](https://github.com/seu-usuario/noteflow.git)
cd noteflow
```
Copie o ficheiro de ambiente e instale as dependências iniciais através de um contentor temporário:

```bash
cp .env.example .env
```

```Docker
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

Utilize a automação do Makefile para subir os contentores, gerar a chave da aplicação e popular a base de dados com o catálogo e os utilizadores de teste:

# Gera a chave da app
./vendor/bin/sail artisan key:generate

# Inicia a aplicação e cria a base de dados com dados falsos reais (Seeders)
make start

🤝 Como Contribuir

Como este é um ambiente de aprendizado e expansão, toda contribuição seja refatoração de código, integração do front-end em Vue.js, ajustes na documentação é bem-vinda!

    Faça um Fork do projeto

    Crie uma Branch para a sua Feature (git checkout -b feature/SuaFeature)

    Faça o Commit das suas mudanças (git commit -m 'feat: Adiciona integração com API de Clima')

    Faça o Push para a Branch (git push origin feature/SuaFeature)

    Abra um Pull Request

Projeto desenvolvido para exploração de Design Patterns, Integrações REST e Automação de Tarefas.
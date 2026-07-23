# Risk Manager

Risk Manager é uma aplicação web empresarial para gestão de riscos, desenvolvida em **Laravel 11**, com um design moderno e minimalista inspirado em *Shadcn UI*, utilizando **Tailwind CSS**. A aplicação foi concebida para fornecer às organizações uma forma estruturada de registar riscos, avaliar níveis inerentes, traçar planos de mitigação e gerar relatórios executivos.

---

## 🎯 Principais Funcionalidades

*   **Painel Executivo (Dashboard):** Visão geral e atalhos rápidos para gestão.
*   **Mapa de Calor (Heatmap):** Visualização matricial 5x5 interativa de todos os riscos (Probabilidade vs Impacto).
*   **Gestão de Riscos:** Registo de riscos com classificação automática (Crítico, Alto, Médio, Baixo) baseada em score (Matriz 5x5).
*   **Planos de Ação:** Criação de planos de mitigação para cada risco (com orçamentos em Kz).
*   **Relatórios (Exportação):** Exportação de dados dinâmicos em **PDF** e **Excel**.
*   **Gestão de Utilizadores:** Registo, edição de utilizadores, e upload de foto de perfil (Avatar).
*   **Controlo de Acessos Dinâmico (ACL):** Criação de **Perfis (Roles)** e associação granular de **Permissões (Permissions)** utilizando o *Spatie Laravel Permission*.
*   **Configurações Globais:** Definição dinâmica do Nome da Aplicação e do Logótipo (exibido na interface e nos relatórios PDF exportados).
*   **Localização:** Aplicação traduzida para Português (pt_BR), incluindo erros de validação e sistema de recuperação de palavra-passe.

---

## 🛠️ Tecnologias Utilizadas

*   **Backend:** PHP 8.5 / Laravel 11
*   **Frontend:** Blade / Tailwind CSS / Alpine.js (Breeze)
*   **Base de Dados:** MySQL (via Laravel Sail / Docker)
*   **Gestão de Permissões:** Spatie Laravel Permission
*   **Exportações:**
    *   *Barryvdh Laravel DomPDF* (Para Relatórios PDF)
    *   *Maatwebsite Excel* (Para Relatórios Excel)

---

## 🚀 Instalação e Configuração

Como o projeto utiliza o **Laravel Sail** (Docker), o ambiente de desenvolvimento é muito fácil de configurar.

### Pré-requisitos
*   [Docker](https://www.docker.com/products/docker-desktop) instalado e a correr no seu sistema.
*   [Git](https://git-scm.com/) instalado.

### Passos

1. **Clonar o Repositório**
   ```bash
   git clone git@github.com:matondojk/risk-manager.git
   cd risk-manager
   ```

2. **Instalar as dependências do Composer**
   (Se não tiver o PHP local instalado, pode usar uma pequena imagem Docker do composer):
   ```bash
   docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
   ```
   *(Ou se tiver o PHP local, basta executar `composer install`)*

3. **Configurar o ficheiro de Ambiente**
   ```bash
   cp .env.example .env
   ```

4. **Subir os contentores Docker (Laravel Sail)**
   ```bash
   ./vendor/bin/sail up -d
   ```

5. **Gerar a Chave da Aplicação**
   ```bash
   ./vendor/bin/sail artisan key:generate
   ```

6. **Criar Link de Armazenamento (Storage)**
   ```bash
   ./vendor/bin/sail artisan storage:link
   ```

7. **Executar Migrações e Seeders**
   Isto irá criar a base de dados, criar os perfis padrão (Administrador, Gestor, etc.) e o primeiro utilizador.
   ```bash
   ./vendor/bin/sail artisan migrate:fresh --seed
   ```

8. **Compilar os Assets de Frontend**
   ```bash
   ./vendor/bin/sail npm install
   ./vendor/bin/sail npm run build
   ```

A sua aplicação estará agora acessível em: `http://localhost`

---

## 🔐 Acesso e Credenciais

Ao correr as *seeders* (`db:seed`), o sistema criará utilizadores padrão de demonstração e irá atribuir automaticamente o perfil de **Administrador** ao primeiro utilizador do sistema.

Se precisar de criar um utilizador administrador manualmente:
1. Registe-se na aplicação.
2. Na linha de comandos, execute o seeder das permissões:
   ```bash
   ./vendor/bin/sail artisan db:seed --class=RolePermissionSeeder
   ```
*(O primeiro utilizador registado receberá automaticamente permissões de Administrador)*.

---

## 👨‍💻 Desenvolvedor
Desenvolvido por **[Matondo JK](https://github.com/matondojk)**.

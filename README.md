# DemandFlow

Sistema de gerenciamento de demandas em **Laravel** e **Bootstrap 5**.

## ⚙️ Funcionalidades
* **Demandas:** CRUD completo e histórico de comentários por demanda.
* **Usuários:** Controle total (criar, editar, deletar) exclusivo para administradores.
* **Perfil:** Visualização de perfil (`show`) disponível para qualquer usuário autenticado.

## 🔒 Controle de Acesso
* `/demands` ➔ Todos autenticados (`auth`)
* `/users/{id}` (show) ➔ Todos autenticados (`auth`)
* `/users/*` (index, create, edit, etc.) ➔ Apenas administradores (`IsAdmin`)

## 🚀 Instalação Rápida

```bash
# 1. Clonar e acessar
git clone [https://github.com/LuizFelipe2023/demandflow.git](https://github.com/LuizFelipe2023/demandflow.git) && cd demandflow

# 2. Instalar dependências
composer install
npm install

# 3. Configurar ambiente
cp .env.example .env
php artisan key:generate

# 4. Banco de dados e seeds
php artisan migrate --seed

# 5. Rodar projeto (em terminais separados)
npm run dev
php artisan serve
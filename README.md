# Aurem — Personal Finance Manager

> A full-stack personal finance management platform built with **Vue 3** and **Laravel 12**, designed to help users track income & expenses, set monthly budgets, and visualize spending through interactive reports — all with a modern, responsive UI and a separate admin panel.

---

## Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [Project Structure](#project-structure)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Running the Application](#running-the-application)
- [Default Accounts](#default-accounts)
- [API Endpoints](#api-endpoints)
- [Screenshots Overview](#screenshots-overview)

---

## Features

### User Side

- **Dashboard** — Real-time overview of total balance, monthly income, monthly expenses, savings rate, income vs expenses trend chart (last 6 months), spending by category doughnut chart, recent transactions, and top spending categories.
- **Transactions** — Add income/expense with live money formatting (e.g. `13 334 000,00 dh`), category selector with floating popover, sortable transaction table, and delete confirmation modals.
- **Budgets** — Month/year picker to select any period, auto-fetches expenses for the selected month from backend, set limits per category, progress bars (green → amber → red), summary strip showing total budget / spent / remaining, limits saved per-month in localStorage.
- **Reports** — Monthly trend line chart (income vs expenses over last 6 months), spending breakdown doughnut chart by category with legend and totals.
- **Categories** — Create, edit, delete custom categories with emoji icons and color pickers. System default categories are synced per user and protected from deletion.
- **Settings** — Update profile (name, email, password).
- **Internationalization** — Full French & English support via `vue-i18n`.
- **Currency** — All amounts displayed in Moroccan Dirham (`dh`) with professional number formatting.
- **Maintenance Mode** — Users see a maintenance page when the admin enables it.

### Admin Panel (`/admin`)

- **Separate authentication** — Dedicated admin guard with JWT, isolated session from regular users.
- **Dashboard** — Platform-wide stats: total users, total transactions, total income/expense, monthly user registrations chart, recent activity.
- **User Management** — Search, view profiles, deactivate/reactivate, or delete users.
- **Transaction Feed** — Global transaction list across all users, filterable by type (income/expense), category, month, and year with server-side pagination.
- **Category Management** — Manage system default categories (CRUD) + view and delete user-created custom categories grouped by user.
- **Audit Log** — Timestamped log of all admin actions (user deactivations, deletions, category changes, etc.).
- **System Settings** — Toggle maintenance mode, clear application cache.

---

## Tech Stack

### Frontend

| Technology       | Version | Purpose                          |
| ---------------- | ------- | -------------------------------- |
| Vue.js           | 3.5     | Composition API with `<script setup>` |
| Vite             | 8.x     | Build tool & dev server          |
| Vue Router       | 5.x     | Client-side routing with guards  |
| vue-i18n         | 11.x    | Internationalization (FR / EN)   |
| Chart.js         | 4.x     | Charts (doughnut, line)          |
| vue-chartjs      | 5.x     | Vue 3 wrapper for Chart.js       |
| Axios            | 1.x     | HTTP client for API calls        |

### Backend

| Technology       | Version | Purpose                          |
| ---------------- | ------- | -------------------------------- |
| PHP              | 8.2+    | Runtime                          |
| Laravel          | 12.x    | Web framework                    |
| tymon/jwt-auth   | latest  | JWT authentication (user + admin)|
| MySQL / SQLite   | —       | Database                         |

---

## Project Structure

```
PROJET RECHERCHE SCI/
├── backend/                          # Laravel 12 API
│   ├── app/
│   │   ├── Http/
│   │   │   ├── Controllers/Api/
│   │   │   │   ├── AuthController.php          # User register, login, logout, profile
│   │   │   │   ├── AdminAuthController.php     # Admin login/logout
│   │   │   │   ├── AdminController.php         # Admin dashboard, users, transactions, categories, logs, settings
│   │   │   │   ├── CategoryController.php      # User CRUD categories
│   │   │   │   ├── DashboardController.php     # User dashboard aggregation
│   │   │   │   ├── ExpenseController.php       # Expense CRUD + month/year filtering
│   │   │   │   └── IncomeController.php        # Income CRUD
│   │   │   └── Middleware/
│   │   │       └── CheckMaintenanceMode.php    # Blocks user requests when maintenance is on
│   │   └── Models/
│   │       ├── Admin.php
│   │       ├── AdminLog.php
│   │       ├── Category.php
│   │       ├── Expense.php
│   │       ├── Income.php
│   │       ├── SystemSetting.php
│   │       └── User.php
│   ├── database/
│   │   ├── migrations/                         # 12 migration files
│   │   └── seeders/
│   │       ├── DatabaseSeeder.php
│   │       ├── SystemDefaultCategoriesSeeder.php
│   │       └── DemoSeeder.php
│   └── routes/
│       └── api.php                             # All API routes
│
├── frontend/                         # Vue 3 SPA
│   ├── src/
│   │   ├── views/
│   │   │   ├── LandingView.vue                 # Public landing page
│   │   │   ├── LoginView.vue                   # User login
│   │   │   ├── RegisterView.vue                # User registration
│   │   │   ├── DashboardView.vue               # User dashboard
│   │   │   ├── TransactionsView.vue            # Add & view transactions
│   │   │   ├── BudgetsView.vue                 # Monthly budget planner
│   │   │   ├── ReportsView.vue                 # Financial reports & charts
│   │   │   ├── SettingsView.vue                # Profile settings
│   │   │   ├── MaintenanceView.vue             # Maintenance screen
│   │   │   └── admin/
│   │   │       ├── AdminLoginView.vue
│   │   │       ├── AdminLayout.vue             # Admin sidebar layout
│   │   │       ├── AdminDashboardView.vue
│   │   │       ├── AdminUsersView.vue
│   │   │       ├── AdminTransactionsView.vue
│   │   │       ├── AdminCategoriesView.vue
│   │   │       ├── AdminAuditView.vue
│   │   │       └── AdminSettingsView.vue
│   │   ├── components/
│   │   │   └── AppLayout.vue                   # Authenticated user layout (sidebar)
│   │   ├── router/
│   │   │   └── index.js                        # Route definitions & navigation guards
│   │   ├── services/
│   │   │   └── api.js                          # Axios instance with JWT interceptor
│   │   ├── i18n/
│   │   │   └── index.js                        # French & English translations
│   │   ├── style.css                           # Global styles
│   │   └── main.js                             # App entry point
│   └── package.json
│
└── README.md
```

---

## Prerequisites

- **PHP** >= 8.2
- **Composer** >= 2.x
- **Node.js** >= 18.x
- **npm** >= 9.x
- **MySQL** 8.x (or SQLite for local development)

---

## Installation

### 1. Clone the repository

```bash
git clone <repository-url>
cd "PROJET RECHERCHE SCI"
```

### 2. Backend setup

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
```

Configure your `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=aurem
DB_USERNAME=root
DB_PASSWORD=

# Admin credentials (add these)
ADMIN_NAME=Admin
ADMIN_EMAIL=admin@aurem.com
ADMIN_PASSWORD=password
```

Run migrations and seeders:

```bash
php artisan migrate
php artisan db:seed
```

### 3. Frontend setup

```bash
cd frontend
npm install
```

---

## Running the Application

### Option A — Separate terminals

**Terminal 1 — Backend:**
```bash
cd backend
php artisan serve
```
Backend runs at `http://localhost:8000`

**Terminal 2 — Frontend:**
```bash
cd frontend
npm run dev
```
Frontend runs at `http://localhost:5173`

### Option B — Using the composer dev script

```bash
cd backend
composer dev
```
This starts the Laravel server, queue worker, log viewer, and Vite dev server concurrently.

---

## Default Accounts

| Role  | Email               | Password   |
| ----- | ------------------- | ---------- |
| User  | test@example.com    | password   |
| Admin | admin@aurem.com     | password   |

> Admin login is available at `/admin/login`

---

## API Endpoints

### Authentication (`/api/auth`)

| Method | Endpoint          | Description            |
| ------ | ----------------- | ---------------------- |
| POST   | `/auth/register`  | Register a new user    |
| POST   | `/auth/login`     | Login & get JWT token  |
| POST   | `/auth/logout`    | Logout (revoke token)  |
| GET    | `/auth/me`        | Get authenticated user |
| PUT    | `/auth/profile`   | Update profile         |

### User Resources (`/api`)

| Method   | Endpoint                | Description                            |
| -------- | ----------------------- | -------------------------------------- |
| GET      | `/dashboard`            | Dashboard stats & charts               |
| GET      | `/categories`           | List user categories                   |
| POST     | `/categories`           | Create category                        |
| PATCH    | `/categories/{id}`      | Update category                        |
| DELETE   | `/categories/{id}`      | Delete category                        |
| GET      | `/expenses`             | List expenses (supports `?month=&year=`) |
| POST     | `/expenses`             | Create expense                         |
| DELETE   | `/expenses/{id}`        | Delete expense                         |
| GET      | `/incomes`              | List incomes                           |
| POST     | `/incomes`              | Create income                          |
| DELETE   | `/incomes/{id}`         | Delete income                          |

### Admin (`/api/admin`)

| Method   | Endpoint                          | Description                          |
| -------- | --------------------------------- | ------------------------------------ |
| POST     | `/admin/login`                    | Admin login                          |
| POST     | `/admin/logout`                   | Admin logout                         |
| GET      | `/admin/me`                       | Get admin profile                    |
| GET      | `/admin/dashboard`                | Platform-wide stats                  |
| GET      | `/admin/users`                    | List all users (with search)         |
| GET      | `/admin/users/{id}`               | View user profile                    |
| PATCH    | `/admin/users/{id}/deactivate`    | Deactivate user                      |
| PATCH    | `/admin/users/{id}/reactivate`    | Reactivate user                      |
| DELETE   | `/admin/users/{id}`               | Delete user                          |
| GET      | `/admin/transactions`             | Global feed (`?type=&category=&month=&year=`) |
| GET      | `/admin/categories`               | System default categories            |
| POST     | `/admin/categories`               | Create system category               |
| PATCH    | `/admin/categories/{id}`          | Update system category               |
| DELETE   | `/admin/categories/{id}`          | Delete system category               |
| GET      | `/admin/user-categories`          | User-created categories              |
| DELETE   | `/admin/user-categories/{id}`     | Delete user category                 |
| GET      | `/admin/logs`                     | Audit log                            |
| GET      | `/admin/settings`                 | Get system settings                  |
| PATCH    | `/admin/settings`                 | Update settings (maintenance mode)   |
| POST     | `/admin/settings/clear-cache`     | Clear application cache              |

---

## Screenshots Overview

| Page                  | Description                                                    |
| --------------------- | -------------------------------------------------------------- |
| Landing               | Public marketing page with feature showcase and tech stack     |
| Dashboard             | Balance cards, income vs expense trend, category doughnut      |
| Transactions          | Add form with live money formatting, sortable history table    |
| Budgets               | Month picker, per-category limits, progress bars, summary bar  |
| Reports               | 6-month trend line chart, category spending breakdown          |
| Admin Dashboard       | Platform stats, user registrations chart                       |
| Admin Transactions    | Global feed with type/category/month/year filters, pagination  |
| Admin Users           | User list with search, profile modal, activate/deactivate      |
| Admin Categories      | System defaults + user custom categories management            |

---

## License

This project is developed as an academic mini-project (Projet de Recherche Scientifique).

<p align="center">
  <img src="ressources/Logo Aurem.png" alt="Aurem" width="480" />
</p>

<p align="center">
  <strong>Personal Finance Manager — Full-Stack Web Application</strong><br/>
  <em>Track income & expenses · Set smart budgets · Visualize spending with interactive reports</em>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Vue.js-3.5-42b883?style=for-the-badge&logo=vuedotjs&logoColor=white" />
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" />
  <img src="https://img.shields.io/badge/Vite-8-646CFF?style=for-the-badge&logo=vite&logoColor=white" />
  <img src="https://img.shields.io/badge/Chart.js-4-FF6384?style=for-the-badge&logo=chartdotjs&logoColor=white" />
  <img src="https://img.shields.io/badge/JWT-Auth-000000?style=for-the-badge&logo=jsonwebtokens&logoColor=white" />
  <img src="https://img.shields.io/badge/MySQL-8-4479A1?style=for-the-badge&logo=mysql&logoColor=white" />
</p>

<p align="center">
  <img src="https://img.shields.io/badge/status-completed-brightgreen?style=flat-square" />
  <img src="https://img.shields.io/badge/license-academic-blue?style=flat-square" />
  <img src="https://img.shields.io/badge/i18n-FR%20%7C%20EN-orange?style=flat-square" />
</p>

---

## 📸 Preview

<p align="center">
  <strong>🎬 Demo Video</strong>
</p>

<p align="center">
  <a href="https://github.com/Zouhair-sS/Aurem/raw/main/ressources/Demo%20video.mp4">
    <img src="ressources/dashboard.png" alt="▶ Watch Demo Video" width="700" />
  </a>
</p>

<p align="center">
  <a href="https://github.com/Zouhair-sS/Aurem/raw/main/ressources/Demo%20video.mp4">
    <img src="https://img.shields.io/badge/▶%20Watch%20Full%20Demo-Download%20Video%20(95MB)-c9a84c?style=for-the-badge&logo=youtube&logoColor=white" />
  </a>
</p>

---

## ✨ Highlights

| What makes Aurem stand out |  |
|---|---|
| 🏗️ **Full-Stack Architecture** | Decoupled SPA (Vue 3) + RESTful API (Laravel 12) with JWT authentication |
| 🎨 **Premium UI/UX** | GSAP scroll animations, glassmorphism effects, responsive design, and custom branding |
| 👤 **Dual Auth System** | Separate user & admin authentication guards with isolated JWT sessions |
| 🌍 **Bilingual** | Complete French & English support via `vue-i18n` |
| 📊 **Interactive Charts** | Doughnut & line charts powered by Chart.js for real-time financial insights |
| 💰 **Moroccan Dirham** | Professional MAD currency formatting throughout the app |
| 🛡️ **Admin Panel** | Full platform management — user control, audit logs, maintenance mode |

---

## 🚀 Features

### 👤 User Dashboard

- **Real-time overview** — Balance, monthly income/expenses, savings rate
- **Trend charts** — Income vs. expenses over the last 6 months (line chart)
- **Spending breakdown** — Category-based doughnut chart with interactive legend
- **Recent transactions** — Quick access to latest financial activity

### 💸 Transaction Management

- Add income & expenses with **live money formatting** (e.g. `13 334 000,00 MAD`)
- **Floating category selector** with emoji icons and color coding
- Sortable transaction table with delete confirmation modals

### 🎯 Smart Budgets

- Month/year picker for any period
- Auto-fetch expenses from backend for selected month
- **Color-coded progress bars** — green → amber → red based on spending
- Summary strip: total budget / spent / remaining

### 📈 Visual Reports

- 6-month trend line chart (income vs. expenses)
- Category spending breakdown with totals
- Filterable by period

### 🏷️ Custom Categories

- Create, edit, delete categories with emoji icons + color pickers
- System defaults synced per user and protected from deletion

### ⚙️ Settings & i18n

- Profile management (name, email, password)
- Full **French / English** toggle

---

### 🔐 Admin Panel (`/admin`)

| Feature | Description |
|---|---|
| **Dashboard** | Platform-wide stats: total users, transactions, income/expense, registration trends |
| **User Management** | Search, view profiles, deactivate/reactivate, or delete accounts |
| **Transaction Feed** | Global feed with filters (type, category, month, year) + server-side pagination |
| **Category Management** | System default categories (CRUD) + user custom categories grouped by user |
| **Audit Log** | Timestamped record of all admin actions |
| **System Settings** | Maintenance mode toggle, application cache clearing |

---

## 🛠️ Tech Stack

### Frontend

| Technology | Version | Role |
|:---|:---:|:---|
| <img src="https://img.shields.io/badge/-Vue.js-42b883?logo=vuedotjs&logoColor=white&style=flat-square" /> | `3.5` | Composition API with `<script setup>` |
| <img src="https://img.shields.io/badge/-Vite-646CFF?logo=vite&logoColor=white&style=flat-square" /> | `8.x` | Build tool & dev server |
| <img src="https://img.shields.io/badge/-Vue%20Router-42b883?logo=vuedotjs&logoColor=white&style=flat-square" /> | `5.x` | Client-side routing with navigation guards |
| <img src="https://img.shields.io/badge/-vue--i18n-42b883?logo=vuedotjs&logoColor=white&style=flat-square" /> | `11.x` | Internationalization (FR / EN) |
| <img src="https://img.shields.io/badge/-Chart.js-FF6384?logo=chartdotjs&logoColor=white&style=flat-square" /> | `4.x` | Interactive charts (doughnut, line) |
| <img src="https://img.shields.io/badge/-Axios-5A29E4?logo=axios&logoColor=white&style=flat-square" /> | `1.x` | HTTP client with JWT interceptor |

### Backend

| Technology | Version | Role |
|:---|:---:|:---|
| <img src="https://img.shields.io/badge/-PHP-777BB4?logo=php&logoColor=white&style=flat-square" /> | `8.2+` | Runtime |
| <img src="https://img.shields.io/badge/-Laravel-FF2D20?logo=laravel&logoColor=white&style=flat-square" /> | `12.x` | RESTful API framework |
| <img src="https://img.shields.io/badge/-JWT-000000?logo=jsonwebtokens&logoColor=white&style=flat-square" /> | `latest` | Dual authentication (user + admin) |
| <img src="https://img.shields.io/badge/-MySQL-4479A1?logo=mysql&logoColor=white&style=flat-square" /> | `8.x` | Relational database |

---

## 📂 Project Structure

```
Aurem/
├── 📁 backend/                        # Laravel 12 RESTful API
│   ├── app/
│   │   ├── Http/Controllers/Api/
│   │   │   ├── AuthController         # Register, login, logout, profile
│   │   │   ├── AdminAuthController    # Admin JWT auth (separate guard)
│   │   │   ├── AdminController        # Dashboard, users, transactions, logs, settings
│   │   │   ├── CategoryController     # User CRUD categories
│   │   │   ├── DashboardController    # Aggregated user stats
│   │   │   ├── ExpenseController      # Expense CRUD + month/year filtering
│   │   │   └── IncomeController       # Income CRUD
│   │   ├── Middleware/
│   │   │   └── CheckMaintenanceMode   # Blocks user requests during maintenance
│   │   └── Models/                    # User, Admin, Category, Income, Expense, etc.
│   ├── database/
│   │   ├── migrations/                # 12 migration files
│   │   └── seeders/                   # Default categories, demo data
│   └── routes/
│       └── api.php                    # All API route definitions
│
├── 📁 frontend/                       # Vue 3 Single Page Application
│   ├── src/
│   │   ├── views/
│   │   │   ├── LandingView            # Animated public landing page
│   │   │   ├── DashboardView          # User financial dashboard
│   │   │   ├── TransactionsView       # Income & expense management
│   │   │   ├── BudgetsView            # Monthly budget planner
│   │   │   ├── ReportsView            # Charts & financial reports
│   │   │   ├── SettingsView           # Profile settings
│   │   │   └── admin/                 # 7 admin views (dashboard, users, etc.)
│   │   ├── components/
│   │   │   └── AppLayout              # Authenticated sidebar layout
│   │   ├── router/                    # Routes + navigation guards
│   │   ├── services/                  # Axios instance + JWT interceptor
│   │   ├── i18n/                      # FR & EN translation files
│   │   └── style.css                  # Global design system
│   └── package.json
│
├── 📁 ressources/                     # Design assets & mockups
└── 📄 README.md
```

---

## ⚡ Quick Start

### Prerequisites

- **PHP** ≥ 8.2 &nbsp;·&nbsp; **Composer** ≥ 2.x &nbsp;·&nbsp; **Node.js** ≥ 18.x &nbsp;·&nbsp; **MySQL** 8.x

### 1️⃣ Clone & Setup Backend

```bash
git clone https://github.com/Zouhair-sS/Aurem.git
cd Aurem/backend

composer install
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
```

Configure `.env` with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=aurem
DB_USERNAME=root
DB_PASSWORD=

ADMIN_NAME=Admin
ADMIN_EMAIL=admin@aurem.com
ADMIN_PASSWORD=password
```

```bash
php artisan migrate
php artisan db:seed
```

### 2️⃣ Setup Frontend

```bash
cd ../frontend
npm install
```

### 3️⃣ Run

```bash
# Terminal 1 — Backend
cd backend && php artisan serve          # → http://localhost:8000

# Terminal 2 — Frontend
cd frontend && npm run dev               # → http://localhost:5173
```

---

## 🔑 Default Accounts

| Role | Email | Password |
|:---:|:---|:---|
| 👤 **User** | `test@example.com` | `password` |
| 🔐 **Admin** | `admin@aurem.com` | `password` |

> Admin login is available at `/admin/login`

---

## 🌐 API Reference

<details>
<summary><strong>Authentication</strong> — <code>/api/auth</code></summary>

| Method | Endpoint | Description |
|:---:|:---|:---|
| `POST` | `/auth/register` | Register a new user |
| `POST` | `/auth/login` | Login & receive JWT |
| `POST` | `/auth/logout` | Revoke token |
| `GET` | `/auth/me` | Current user profile |
| `PUT` | `/auth/profile` | Update profile |

</details>

<details>
<summary><strong>User Resources</strong> — <code>/api</code></summary>

| Method | Endpoint | Description |
|:---:|:---|:---|
| `GET` | `/dashboard` | Dashboard stats & charts |
| `GET/POST` | `/categories` | List / create categories |
| `PATCH/DELETE` | `/categories/{id}` | Update / delete category |
| `GET/POST` | `/expenses` | List (filterable) / create expenses |
| `DELETE` | `/expenses/{id}` | Delete expense |
| `GET/POST` | `/incomes` | List / create incomes |
| `DELETE` | `/incomes/{id}` | Delete income |

</details>

<details>
<summary><strong>Admin Panel</strong> — <code>/api/admin</code></summary>

| Method | Endpoint | Description |
|:---:|:---|:---|
| `POST` | `/admin/login` | Admin login |
| `POST` | `/admin/logout` | Admin logout |
| `GET` | `/admin/me` | Admin profile |
| `GET` | `/admin/dashboard` | Platform-wide stats |
| `GET` | `/admin/users` | List users (with search) |
| `GET` | `/admin/users/{id}` | View user details |
| `PATCH` | `/admin/users/{id}/deactivate` | Deactivate user |
| `PATCH` | `/admin/users/{id}/reactivate` | Reactivate user |
| `DELETE` | `/admin/users/{id}` | Delete user |
| `GET` | `/admin/transactions` | Global feed with filters |
| `GET/POST` | `/admin/categories` | System categories CRUD |
| `PATCH/DELETE` | `/admin/categories/{id}` | Update / delete system category |
| `GET` | `/admin/user-categories` | User-created categories |
| `DELETE` | `/admin/user-categories/{id}` | Delete user category |
| `GET` | `/admin/logs` | Audit log |
| `GET/PATCH` | `/admin/settings` | System settings |
| `POST` | `/admin/settings/clear-cache` | Clear app cache |

</details>

---

## 🏗️ Architecture

```mermaid
graph LR
    A[Vue 3 SPA] -->|Axios + JWT| B[Laravel 12 API]
    B -->|Eloquent ORM| C[(MySQL)]
    B -->|JWT Guard| D[User Auth]
    B -->|Admin Guard| E[Admin Auth]
    A -->|Chart.js| F[Interactive Charts]
    A -->|vue-i18n| G[FR / EN]
    A -->|GSAP| H[Scroll Animations]
```

---

## 🧠 Key Technical Decisions

| Decision | Rationale |
|---|---|
| **Separate JWT guards** | User and admin sessions are fully isolated — compromising one doesn't affect the other |
| **Composition API (`<script setup>`)** | Cleaner, more concise component logic with better TypeScript readiness |
| **GSAP + ScrollTrigger** | Scroll-driven animations on the landing page for a premium, recruiter-worthy first impression |
| **IntersectionObserver for video** | Demo video auto-plays when scrolled into view — no wasted bandwidth |
| **localStorage for budgets** | Budget limits are client-side per month, keeping the backend stateless for budget config |
| **System vs. user categories** | Seedable defaults + full user customization without data conflicts |

---

## 👥 Team

| Member | Role |
|---|---|
| **Zouhair** | Full-Stack Developer |

> 🎓 Academic project — **EMSI Casablanca** · IIR · 3rd Year · 2025/2026

---

## 📄 License

This project was developed as a **Projet de Recherche Scientifique** (Scientific Research Project) at EMSI Casablanca. It is intended for academic and portfolio purposes.

---

<p align="center">
  <img src="ressources/Aurem logo 1.png" alt="Aurem" width="40" />
  <br/>
  <sub><strong>Aurem</strong> — Manage better. Live more.</sub>
</p>

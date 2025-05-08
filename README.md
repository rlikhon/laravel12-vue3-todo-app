# 📝 Laravel 12 + Vue 3 SPA To-Do List

A clean, secure, and modern **Single Page Application** built with **Laravel 12** and **Vue 3**, featuring **Sanctum authentication**, **task management (CRUD)**, **pagination**, and pink-themed styling with basic CSS.

---

## 🔧 Tech Stack

- **Backend**: Laravel 12 + Sanctum
- **Frontend**: Vue 3 (SPA inside Laravel)
- **Styling**: Plain CSS (pink theme)
- **Auth**: Sanctum-secured login, register, logout
- **Testing**: PHPUnit (Feature + API tests)

## 🚀 Features

- 🔐 Sanctum-secured **Login / Register / Logout**
- ✅ Authenticated **task CRUD** API
- 🎨 Clean, pink-themed UI using plain CSS
- 🔀 Vue Router guards for authenticated pages
- 📦 Laravel + Vue in the **same project**
- 🧪 Basic Feature Tests with PHPUnit for APIs

---

## Database
- Run migration and resister a new user
- Or import the laravel-todo.sql file and use the bellow credential.

## 📁 Login Info
- base url: http://127.0.0.1:8000
- email: rlikhon@example.com
- password: password


## 📁API Endpoints
- Auth
- POST /api/register

- POST /api/login

- GET /api/logout

- GET /api/user

- Tasks
- GET /api/tasks (paginated)

- POST /api/tasks

- PUT /api/tasks/{id}

- DELETE /api/tasks/{id}

- 🔐 All Task routes require authentication (auth:sanctum).



# 📝 Laravel 12 + Vue 3 SPA To-Do List

A clean, secure, and modern **Single Page Application** built with **Laravel 12** and **Vue 3**, featuring **Sanctum authentication**, **task management (CRUD)**, **pagination**, and pink-themed styling with basic CSS.

---

## 🚀 Features

- 🔐 Sanctum-secured **Login / Register / Logout**
- ✅ Authenticated **task CRUD** API
- 📄 Paginated task list (10 per page)
- 🎨 Clean, pink-themed UI using plain CSS (no Tailwind)
- 🔀 Vue Router guards for authenticated pages
- 📦 Laravel + Vue in the **same project**
- 🧪 Basic Feature Tests with PHPUnit

---

## 📁 Folder Structure (Frontend)


## 📁API Endpoints
Auth
POST /api/register

POST /api/login

GET /api/logout

GET /api/user

Tasks
GET /api/tasks (paginated)

POST /api/tasks

PUT /api/tasks/{id}

DELETE /api/tasks/{id}

🔐 All Task routes require authentication (auth:sanctum).
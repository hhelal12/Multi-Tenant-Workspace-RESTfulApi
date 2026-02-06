# Mini Multi-Tenant Workspace API

## Track Chosen
**Backend API Engineer**

---

## Tech Stack
- Laravel  (PHP framework)
- SQLite (local database)
- Docker + Docker Compose

---

## Project Overview

This is a **RESTful API** for a lightweight workspace and task management system.  

**Features implemented:**

### Users
- `POST /api/users` – Create a new user  
- `GET /api/users` – List all users  

### Workspaces
- `POST /api/workspaces` – Create a new workspace  
- `GET /api/workspaces` – List all workspaces  
- `POST /api/workspaces/{id}/users` – Add a user to a workspace  

### Tasks
- `POST /api/tasks` – Create a task  
- `GET /api/tasks?workspaceId=` – Get tasks for a workspace  
- `PATCH /api/tasks/{id}` – Mark task as completed  

### Summary
- `GET /api/summary` – Get total counts of users, workspaces, tasks, and completed vs pending tasks  

---

## Setup Instructions

### Prerequisites
- Docker Desktop installed (Windows, Mac, or Linux)
- Basic knowledge of Postman or API testing

---

### 1. Clone the repository
```bash
git clone <https://github.com/hhelal12/Multi-Tenant-Workspace-RESTfulApi.git>
cd <project-folder>

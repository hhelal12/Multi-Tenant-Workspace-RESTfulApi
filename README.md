# Mini Multi-Tenant Workspace API

## Track Chosen
**Backend API Engineer**

---

## Tech Stack
- Laravel 11 (PHP framework)
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

---

## Option A: Run With Docker (Recommended)

### Prerequisites
- Docker Desktop installed

### Steps

#### 1. Clone the repository
```bash
git clone https://github.com/hhelal12/Multi-Tenant-Workspace-RESTfulApi.git
cd Multi-Tenant-Workspace-RESTfulApi
```

#### 2. Build and run the container
```bash
docker-compose up -d --build
```
Wait 2-3 minutes for the build to complete.

#### 3. Test the API
Open browser or Postman:
```
http://localhost:8000/api/summary
```

#### 4. Stop the container
```bash
docker-compose down
```

---

## Option B: Run Without Docker

### Prerequisites
- PHP 8.2+
- Composer

### Steps

#### 1. Clone the repository
```bash
git clone https://github.com/hhelal12/Multi-Tenant-Workspace-RESTfulApi.git
cd Multi-Tenant-Workspace-RESTfulApi
```

#### 2. Install dependencies
```bash
composer install
```

#### 3. Setup environment
```bash
cp .env.example .env
php artisan key:generate
```

#### 4. Create database
**Windows (PowerShell):**
```powershell
New-Item database/database.sqlite -ItemType File
```

**Mac/Linux:**
```bash
touch database/database.sqlite
```

#### 5. Configure .env
Open `.env` and set:
```
DB_CONNECTION=sqlite
```

#### 6. Run migrations and seed data
```bash
php artisan migrate:fresh
php artisan db:seed
```

#### 7. Start the server
```bash
php artisan serve
```

#### 8. Test the API
Open browser or Postman:
```
http://localhost:8000/api/summary
```

---

## Project Structure

```
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Controller.php           # Base controller (shared methods)
│   │       ├── UsersController.php      # Handles user endpoints
│   │       ├── WorkspaceController.php  # Handles workspace endpoints
│   │       ├── TaskController.php       # Handles task endpoints
│   │       └── SummaryController.php    # Handles summary endpoint
│   │
│   └── Models/
│       ├── User.php                     # User model & relationships
│       ├── Workspace.php                # Workspace model & relationships
│       └── Task.php                     # Task model & relationships
│
├── database/
│   ├── migrations/                      # Database table definitions
│   │   ├── create_users_table.php
│   │   ├── create_workspaces_table.php
│   │   ├── create_tasks_table.php
│   │   └── create_workspace_user_table.php
│   │
│   └── seeders/
│       └── DatabaseSeeder.php           # Sample data for testing
│
├── routes/
│   └── api.php                          # API route definitions
│
├── Dockerfile                           # Docker configuration
├── docker-compose.yml                   # Docker Compose configuration
└── README.md                            # This file
```

### Key Files Explained

| File/Folder | Purpose |
|-------------|---------|
| `app/Http/Controllers/` | Contains all API logic |
| `app/Models/` | Database models with relationships |
| `database/migrations/` | Defines database tables structure |
| `database/seeders/` | Creates sample data |
| `routes/api.php` | Maps URLs to controller methods |
| `Dockerfile` | Builds the Docker image |
| `docker-compose.yml` | Runs the container |

---

## Database Schema

### Users Table
| Column | Type | Description |
|--------|------|-------------|
| id | integer | Primary key |
| name | string | User's name |
| email | string | Unique email |
| password | string | Hashed password |
| role | string | User role |

### Workspaces Table
| Column | Type | Description |
|--------|------|-------------|
| id | integer | Primary key |
| name | string | Workspace name |
| description | string | Description (optional) |
| leader_id | integer | Foreign key to users |

### Tasks Table
| Column | Type | Description |
|--------|------|-------------|
| id | integer | Primary key |
| title | string | Task title |
| body | text | Task description |
| workspace_id | integer | Foreign key to workspaces |
| creator_id | integer | Foreign key to users |
| assigned_to_id | integer | Foreign key to users (optional) |
| status | string | pending/in_progress/completed |
| deadline | date | Due date (optional) |

### Workspace_User Table (Pivot)
| Column | Type | Description |
|--------|------|-------------|
| workspace_id | integer | Foreign key to workspaces |
| user_id | integer | Foreign key to users |

---

## API Endpoints & Testing Examples

### 1. Users

#### GET /api/users - Get All Users
```
Method: GET
URL: http://localhost:8000/api/users
```

**Response (200):**
```json
[
    {
        "id": 1,
        "name": "John Doe",
        "email": "john@test.com",
        "role": "admin"
    },
    {
        "id": 2,
        "name": "Jane Smith",
        "email": "jane@test.com",
        "role": "member"
    }
]
```

---

#### POST /api/users - Create User
```
Method: POST
URL: http://localhost:8000/api/users
Headers: Content-Type: application/json
```

**Request Body:**
```json
{
    "name": "New User",
    "email": "newuser@test.com",
    "password": "password123",
    "role": "member"
}
```

**Response (201):**
```json
{
    "id": 4,
    "name": "New User",
    "email": "newuser@test.com",
    "role": "member"
}
```

---

### 2. Workspaces

#### GET /api/workspaces - Get All Workspaces
```
Method: GET
URL: http://localhost:8000/api/workspaces
```

**Response (200):**
```json
[
    {
        "id": 1,
        "name": "Marketing Team",
        "description": "Marketing department workspace",
        "leader_id": 1,
        "leader": {
            "id": 1,
            "name": "John Doe"
        },
        "users": [
            {"id": 2, "name": "Jane Smith"},
            {"id": 3, "name": "Bob Wilson"}
        ],
        "tasks": [
            {"id": 1, "title": "Create marketing plan"}
        ]
    }
]
```

---

#### POST /api/workspaces - Create Workspace
```
Method: POST
URL: http://localhost:8000/api/workspaces
Headers: Content-Type: application/json
```

**Request Body:**
```json
{
    "name": "Sales Team",
    "description": "Sales department workspace",
    "leader_id": 1
}
```

**Response (201):**
```json
{
    "id": 3,
    "name": "Sales Team",
    "description": "Sales department workspace",
    "leader_id": 1
}
```

---

#### POST /api/workspaces/{id}/users - Add User to Workspace
```
Method: POST
URL: http://localhost:8000/api/workspaces/1/users
Headers: Content-Type: application/json
```

**Request Body:**
```json
{
    "user_id": 3
}
```

**Response (200):**
```json
{
    "message": "User added to workspace",
    "workspace": {
        "id": 1,
        "name": "Marketing Team",
        "users": [
            {"id": 2, "name": "Jane Smith"},
            {"id": 3, "name": "Bob Wilson"}
        ]
    }
}
```

---

### 3. Tasks

#### GET /api/tasks?workspaceId={id} - Get Tasks by Workspace
```
Method: GET
URL: http://localhost:8000/api/tasks?workspaceId=1
```

**Response (200):**
```json
[
    {
        "id": 1,
        "title": "Create marketing plan",
        "body": "Develop Q1 marketing strategy",
        "workspace_id": 1,
        "creator_id": 1,
        "assigned_to_id": 2,
        "status": "pending",
        "deadline": "2025-03-01",
        "workspace": {
            "id": 1,
            "name": "Marketing Team"
        },
        "creator": {
            "id": 1,
            "name": "John Doe"
        },
        "assigned_to": {
            "id": 2,
            "name": "Jane Smith"
        }
    }
]
```

---

#### POST /api/tasks - Create Task
```
Method: POST
URL: http://localhost:8000/api/tasks
Headers: Content-Type: application/json
```

**Request Body:**
```json
{
    "title": "Write blog post",
    "body": "Create content for company blog",
    "workspace_id": 1,
    "creator_id": 1,
    "assigned_to_id": 2,
    "deadline": "2025-02-15"
}
```

**Response (201):**
```json
{
    "id": 5,
    "title": "Write blog post",
    "body": "Create content for company blog",
    "workspace_id": 1,
    "creator_id": 1,
    "assigned_to_id": 2,
    "status": "pending",
    "deadline": "2025-02-15"
}
```

---

#### PATCH /api/tasks/{id} - Mark Task Complete
```
Method: PATCH
URL: http://localhost:8000/api/tasks/1
```

**Response (200):**
```json
{
    "id": 1,
    "title": "Create marketing plan",
    "body": "Develop Q1 marketing strategy",
    "workspace_id": 1,
    "creator_id": 1,
    "assigned_to_id": 2,
    "status": "completed",
    "deadline": "2025-03-01"
}
```

---

### 4. Summary

#### GET /api/summary - Get System Statistics
```
Method: GET
URL: http://localhost:8000/api/summary
```

**Response (200):**
```json
{
    "total_users": 3,
    "total_workspaces": 2,
    "total_tasks": 4,
    "completed_tasks": 1,
    "pending_tasks": 2
}
```

---

## Error Responses

### 400 Bad Request
```json
{
    "message": "workspaceId is required"
}
```

### 404 Not Found
```json
{
    "message": "Task not found"
}
```




---

## Sample Data

When running with Docker or after `php artisan db:seed`, sample data is pre-loaded:

- **3 Users** (John, Jane, Bob)
- **2 Workspaces** (Marketing Team, Development Team)
- **4 Tasks** (mixed statuses)

---

## Author
Hussein Helal
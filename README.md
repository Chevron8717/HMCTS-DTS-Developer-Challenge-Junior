# DTS Developer Technical Test - Junior Software Developer

Welcome to my response for the DTS Developer Technical Test for the Junior Software Developer position! This repository contains my solution to the coding challenge provided in the test.

## Getting Started

To run the applications locally, follow these steps.

### Prerequisites

- [Docker](https://docs.docker.com/engine/install)
- [Docker Compose v2](https://docs.docker.com/compose/install)
- [Node.js (v24)](https://nodejs.org/en/download/)
- [Just](https://github.com/casey/just) (optional, for convenience)

All necessary dependencies for the API are containerised within Docker, so you only need to have Docker and the frontend dependencies installed on your host machine.

### Running the Applications

1. Clone this repository, then install dependencies for both frontend and backend:

   ```bash
   docker compose run --rm api composer install
   cd frontend && npm install && cd ..

   # If Just is installed, you can also run:
   just install
   ```

2. Start the backend and frontend applications:

   ```bash
   docker compose up -d
   cd frontend && npm run dev

   # If Just is installed, you can also run:
   just start-api
   just start-frontend
   ```

3. Access the applications:
   - Frontend Application: [http://localhost:5173](http://localhost:5173)
   - Backend API: [http://localhost:8000](http://localhost:8000)

## Architecture

The frontend and backend are separated into two distinct applications, and contained within this monorepo structure:

```
/ (root)
├── backend/          # Backend application (PHP - Yii2 Framework - REST API)
└── frontend/         # Frontend application (TypeScript - Vite - React)
```

### Backend

The backend is built using PHP 8.4 with the Yii2 framework, structured as a RESTful API. It handles data storage, retrieval, and business logic.

#### Yii2 Framework

Yii2 is a high-performance MVC PHP framework best suited for developing web applications and APIs. It's been chosen for its robustness, ease of use, and due to my own familiarity with it.

- Yii2 Documentation: [https://www.yiiframework.com/doc/guide/2.0/en](https://www.yiiframework.com/doc/guide/2.0/en)

#### API Endpoints

The backend exposes the following API endpoints:

##### `GET /tasks`

Retrieves a list of all tasks.

Example:

```output
$ curl -X GET http://localhost:8000/tasks \
  -H "Accept: application/json"

[
  {
    "id": 1,
    "title": "Sample Task",
    "description": "This is a sample task description.",
    "status": "pending",
    "created_at": "2024-01-01T12:00:00Z",
    "updated_at": "2024-01-01T12:00:00Z"
  },
  ...
]
```

##### `POST /tasks`

Creates a new task.

Example:

```output
$ curl -X POST http://localhost:8000/tasks \
  -H "Content-Type: application/json" \
  -d '{
    "title": "New Task",
    "description": "Description of the new task",
    "status": "pending",
    "due_at": "2024-01-10 12:00:00"
  }'

{
  "id": 3,
  "title": "New Task",
  "description": "Description of the new task",
  "status": "pending",
  "due_at": "2024-01-10 12:00:00",
  "created_at": "2024-01-02 12:00:00",
  "updated_at": "2024-01-02 12:00:00"
}
```

##### `GET /tasks/{id}`

Retrieves a specific task by ID.

Example:

```output
$ curl -X GET http://localhost:8000/tasks/3 \
  -H "Accept: application/json"

{
  "id": 3,
  "title": "New Task",
  "description": "Description of the new task",
  "status": "pending",
  "due_at": "2024-01-10 12:00:00",
  "created_at": "2024-01-02 12:00:00",
  "updated_at": "2024-01-02 12:00:00"
}
```

##### `PUT /tasks/{id}`

Updates an existing task by ID.

Example:

```output
$ curl -X PUT http://localhost:8000/tasks/3 \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Updated Task Title",
    "description": "Updated description",
    "status": "completed",
    "due_at": "2024-01-10 12:00:00"
  }'

{
  "id": 3,
  "title": "Updated Task Title",
  "description": "Updated description",
  "status": "completed",
  "due_at": "2024-01-10 12:00:00",
  "created_at": "2024-01-02 12:00:00",
  "updated_at": "2024-01-03 12:00:00"
}
```

### Frontend

The frontend is developed using TypeScript with Vite and React. It provides a user interface for interacting with the backend API.

#### Vite

Vite is a modern frontend build tool that offers fast development and optimized builds. It has been chosen for its speed and simplicity.

- Vite Documentation: [https://vitejs.dev/guide/](https://vitejs.dev/guide/)

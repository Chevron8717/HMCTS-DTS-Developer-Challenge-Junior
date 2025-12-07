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

### Frontend

The frontend is developed using TypeScript with Vite and React. It provides a user interface for interacting with the backend API.

#### Vite

Vite is a modern frontend build tool that offers fast development and optimized builds. It has been chosen for its speed and simplicity.

- Vite Documentation: [https://vitejs.dev/guide/](https://vitejs.dev/guide/)

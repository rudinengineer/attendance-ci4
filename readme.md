# Attendance APP

## Description

Attendance APP is a system developed using the **PHP** programming language with the **Codeigniter 4** framework.
This system is designed to simplify employee attendance management efficiently.

## Endpoint

- Attendance APP : /
- Administrator : /admin

## API

Attendance System API can be found here:
[Github Repository](https://github.com/rudinengineer/attendance-api-gofiber)

## Tech Stack

- **Programming Language:** PHP
- **Framework:** Codeigniter 4

## Setup Tutorial

### Run With Docker

1. Clone the repository:

   ```bash
   git clone https://github.com/rudinengineer/attendance-ci4.git
   cd attendance-ci4
   ```

1. Copy the environment file:

   ```bash
   cp .env.example .env
   ```

1. Build and run using Docker:

   ```bash
   docker network create attendance-net
   docker compose build --no-cache
   docker compose up -d
   ```

1. The APP will be accessible at:

   ```
   http://127.0.0.1:8080
   ```

---

🚀 You are ready to use Attendance APP!

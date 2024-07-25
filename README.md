## Name: Odubiyi Ifeoluwa Antonia

## Email: odubiyiifeolu@gmail.com

# Task Management API- https://documenter.getpostman.com/view/24419976/2sA3kXEgDy

## Project Overview

The Task Management API is a RESTful web service designed to manage tasks efficiently. It supports comprehensive CRUD operations and includes robust authentication mechanisms, data validation, and detailed API documentation. This API allows users to securely manage tasks with support for authentication and authorization.

## Features

- **CRUD Operations:** Create, Read, Update, and Delete tasks.
- **Data Validation:** Ensures accuracy and integrity of task data.
- **Authentication:** Secure access using Laravel Sanctum.
- **Testing:** Unit and feature tests to verify functionality.
- **Documentation:** Comprehensive API documentation using Postman.
https://documenter.getpostman.com/view/24419976/2sA3kXEgDy

## Libraries and Technologies

- **Laravel PHP Framework**  
  This provides a powerful and elegant framework for web development, offering built-in support for routing, middleware, authentication, and database operations.

- **Laravel Sanctum (or JWT/Laravel Passport)**  
  This was used for secure token-based authentication. Laravel Sanctum offers simplicity for API token management.

- **MySQL**  
  This was chosen for its performance and reliability in handling data storage and queries.

- **PHPUnit and Mockery**  
  This was utilized for unit testing, feature testing, and mocking dependencies, ensuring that code operates as expected in isolation.

- **Postman**  
  This was used for creating comprehensive API documentation and testing. Provides a user-friendly interface for sending requests and viewing responses.
  url:https://documenter.getpostman.com/view/24419976/2sA3kXEgDy

## Process Flow

The Task Management API follows a structured process flow to handle task-related operations efficiently:

1. **Client Request:** The client sends an HTTP request to the API endpoint.
2. **Routing:** Laravel routes the request to the appropriate controller method.
3. **Controller:** The controller handles the incoming request and delegates the task to the service layer.
4. **Service Layer:** The service layer encapsulates the business logic and interacts with the repository layer.
5. **Repository Layer:** The repository handles data access and interacts with the database.
6. **Response:** The service layer returns the result to the controller, which then sends the response back to the client.

## Services, Repositories, and Interfaces

### TaskService

- **Purpose:** Encapsulates business logic related to task management.
- **Methods:**
  - `getAllTasks()`: Retrieves all tasks.
  - `getTaskById(int $id)`: Retrieves a specific task by its ID.
  - `createTask(array $data)`: Creates a new task.
  - `updateTask(int $id, array $data)`: Updates an existing task.
  - `deleteTask(int $id)`: Deletes a task.

*Why TaskService?*  
The `TaskService` acts as an intermediary between the controller and the repository. It contains the business logic for task management, such as validation and processing, which helps keep the controller lean and focused on request handling.

### TaskRepository

- **Purpose:** Manages data access and interactions with the database.
- **Methods:**
  - `all()`: Retrieves all tasks.
  - `find(int $id)`: Finds a task by its ID.
  - `create(array $data)`: Creates a new task.
  - `update(int $id, array $data)`: Updates a task.
  - `delete(int $id)`: Deletes a task.

*Why TaskRepository?*  
The `TaskRepository` handles all database interactions, ensuring a clean separation of concerns. By managing data access in a repository, we can easily switch to a different data source or change database implementations with minimal impact on the rest of the application.

### TaskRepositoryInterface

- **Purpose:** Defines the contract for task data operations to ensure consistent implementation.

*Why TaskRepositoryInterface?*  
The `TaskRepositoryInterface` ensures that the repository implementation adheres to a consistent contract, facilitating easier testing and future changes. It allows for the use of dependency injection, enabling better flexibility and adherence to the Dependency Inversion Principle.

## Installation and Setup

```bash
# Clone the Repository
git clone https://github.com/T0niadev/Task-Management.git
cd Task-Management

# Install Dependencies
composer install

# Setup Environment
cp .env.example .env
# Update the .env file with your database and authentication configuration.

# Generate Application Key
php artisan key:generate

# Run Migrations
php artisan migrate

# Start the Server
php artisan serve

# Run Tests
php artisan test


## Authentication

### API Endpoints
- **Register**: `POST /api/registration`  
  Register users and generate a token for API access.

- **Login**: `POST /api/login`  
  Authenticate users and generate a token for API access.

- **Logout**: `POST /api/logout`  
  Revoke the user's token and end the session.

## Task Management

### API Endpoints

- **Get All Tasks**: `GET /api/tasks`  
  Retrieve a list of all tasks.

- **Get Task By ID**: `GET /api/tasks/{id}`  
  Retrieve a specific task by its ID.

- **Create Task**: `POST /api/tasks`  
  Create a new task with the provided data.

- **Update Task**: `PUT /api/tasks/{id}`  
  Update an existing task with new data.

- **Delete Task**: `DELETE /api/tasks/{id}`  
  Delete a task by its ID.

POSTMAN API DOCUMENTATION URL: https://documenter.getpostman.com/view/24419976/2sA3kXEgDy


# Overview
Built using clean architecture principles focusing on simplicity and maintainability. The system follows SOLID principles and KISS approach, implementing only essential features without over-engineering .

### Key Features
-   Order Processing
-   Stock Management
-   Dispatch Alerts
-   Simple API Interface
### Technical Stack

-   Laravel 10 /PHP 8
-   MySQL
-   PHPUnit


## Table of Contents

1. [Project Overview](#project-overview)

2. [System Architecture](#system-architecture)

3. [Database Schema](#database-schema)

4. [ Best Practices Implemented ](#core-features-implementation)

5. [API Documentation](#api-documentation)

6. [Error Handling](#testing-strategy)

7. [Git Strategy](#testing-strategy)

8. [Installation Guide](#installation-guide)



# Architecture Documentation
This solution follows the Onion Architecture pattern, with all layers wrapped within the infrastructure folder, promoting dependency inversion and loose coupling.
-   **Abstraction-First Approach**: All components are defined by interfaces before implementation
-   **Clean Dependency Flow**: Inner layers have no knowledge of outer layers
-   **Repository**: Data access abstraction ,Extensible for caching
-   **Services**: -   Encapsulates business rules,Orchestrates operations
-   **DTOs**: Clean data transfer between layers
-   **Value Objects**: Immutable domain concepts

![](/Architecture.png)


# Database Schema

![](/Schema.png)


# Best Practices Implemented
### 1. Architecture Patterns

-   ✓ Clean Architecture
-   ✓ SOLID Principles
-   ✓ Repository Pattern
-   ✓ Events **fire events in successful end function to allow rest of the system to use it**

### 2. Code Organization

-   ✓ Interface Segregation
-   ✓ Dependency Injection
-   ✓ DTO Pattern
-   ✓ Service Layer

### 3. Data Management

-   ✓ Transaction Management
-   ✓ Stock Level Monitoring
-   ✓ Alert System
-   ✓ Data Validation
-
### 4. Helpers

-   ✓ DTO array validation [validate that each item is an dto]
-   ✓ Logging [log exception in custom channels ]
-   ✓ APi Response


### 5. Testing Strategy

-   ✓ Feature Tests


# API Documentation

url : [ Post ] http://localhost/api/order

  ```json  payload : {

{
	   "products": [
			"product_id": 1,
			"quantity": 2,
			]
}
```

> laravel 10 uses mailpit for mails you can access it throw this port 8025


# Error Handling
there is a custom exception  that has dynamic logging to custom channel like transaction, order process ,product creation etc...

> and in the queue job there is a retrying mechanism for a 3 times for handling if error happen

# Installation Guide

- Clone repository
- Install dependencies: `composer install`
- Configure environment: `.env` copy from `.env.example`
- Run migrations: `php artisan migrate`
- Seed database: `php artisan db:seed`
- Run tests: `php artisan test`
- Run Queue `php artisan queue:work`

# Git Strategy

i am using trunk-flow as a branching strategy 



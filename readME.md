# Attribute With ReactPHP

A well-structured PHP project showcasing best practices for organization and scalability.

## Directory Structure

## Server

The `server` directory contains files and scripts related to server configuration and execution.

### Server Script

A PHP script (`server`) is provided to simplify running the application. It can be executed from the command line to start the built-in PHP server.



## Bootstrap

The `bootstrap` directory contains core files responsible for initializing the application.

- **app.php:** Main application file, initializing essential components.
- **config.php:** Configuration file, managing global settings.
- **route_cache.php:** Cached routes for improved performance.

## Config

The `config` directory holds configuration files used throughout the application.

- **helper.php:** Utility functions and helper methods.
- **database.php:** Database configuration settings.

## Src

The `src` directory is the heart of the application, containing source code for controllers, libraries, and middleware.

### Controllers

Controllers handle the application's HTTP requests and responses.

- **TestingController.php:** An example controller handling specific routes.

### Lib

The `Lib` directory contains custom libraries and annotations.

#### Annotations

Custom annotations used for routing and middleware.

- **RestController.php:** Base annotation class for RESTful controllers.
- **Middleware.php:** Annotation for middleware classes.
- **Prefix.php:** Annotation for route prefixes.
- **RouteGet.php, RoutePost.php, RoutePut.php, RouteDelete.php:** Annotations for HTTP methods.

- **Router.php:** Centralized router for handling route registration and dispatching.

### Middleware

Middleware classes for processing requests before reaching the controller.

- **JwtMiddleware.php:** Example middleware for handling JSON Web Tokens.

## Public

The `public` directory is the entry point for web requests.

- **index.php:** The main entry point

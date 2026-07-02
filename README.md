# PHP User Management Admin Panel

A secure, clean, and lightweight Web Interface built from scratch using Native PHP (8.2+), Object-Oriented Programming (OOP) best practices, and the MVC architecture pattern. The layout is implemented using Bootstrap 5.

---

## 🛡️ Implemented Security Best Practices

To ensure data integrity and infrastructure stability, the application includes native implementations against standard web vulnerabilities:
* **SQL Injection (SQLi) Prevention:** Fully addressed by utilizing **PDO Prepared Statements** for all database interactions. Dynamic identifiers (like sorting columns) are validated against strict internal whitelists.
* **Cross-Site Scripting (XSS) Prevention:** Mitigated by consistently applying context-aware output escaping via `htmlspecialchars()` on all user-submitted fields before rendering them in the DOM.
* **Cross-Site Request Forgery (CSRF) Protection:** Enforced using cryptographic anti-CSRF session tokens validated upon every state-changing `POST` request.
* **Session Guard & Authentication:** Strict router-level middleware ensures that no directory paths or action endpoints can be executed unless an administrative session is securely initialized.

---

## 🏗️ Architecture Design & PSR-4

The system completely isolates the presentation layer from business logic using a custom **Model-View-Controller (MVC)** structural flow:
* **`Core/`**: Contains the execution engine including the explicit `Router`, HTTP encapsulation (`Request`), state persistence (`Session`), and singleton PDO connection wrapper (`Database`).
* **`Models/`**: Implements the Repository Pattern (`UserRepository`) decoupling raw data mutation queries from operational controllers.
* **`Controllers/`**: Orchestrates logic execution flow, data mapping, input validation, and layout routing.
* **`Views/`**: Pure modular HTML5 components wrapped in a structural master view framework (`layout.php`).

The class directory obeys standard modern structure rules and uses **Composer PSR-4 automatic class mapping** directly managed inside the isolated execution shell.

---

## 🐳 Environment Requirements & Installation

The project is bundled with an automated container architecture via Docker. You do not need PHP or MySQL installed locally on your host machine.

### Prerequisites
* Docker & Docker Compose installed.

### Setup Instructions

1.  **Clone or unpack** the project archive into your workspace directory.
2.  Navigate to the project root directory in your terminal and spin up the containers:
    ```bash
    docker-compose up --build
    ```
    *Note: The environment is configured to run `composer install` inside the application runtime automatically during build execution to generate required class dependency paths.*

3.  **Database Seeding:** The container system automatically maps and executes the database baseline file `./database/init.sql` upon initial deployment.

---

## 🔑 Access Credentials & Configuration

### Web Panel Access
* **URL:** [http://localhost:8081/login](http://localhost:8081/login)
* **Default Administrative Username:** `admin`
* **Default Administrative Password:** `admin123`

### Environment Mapping Reference
Should you need to change configurations or link up an external viewer, the active port parameters defined within the infrastructure layout are:
* **Nginx Webserver Port:** `8081` (Mapped to internal legacy port `80`)
* **MySQL Database Port:** `3307` (Mapped to internal container port `3306`)
* **Database Name:** `users_manager_db`
* **Database Username:** `db_admin`
* **Database Password:** `db_password`

---

## 💡 Functional Highlights Inside the Application
* **Dynamic Role Control:** Fully functional implementation of administrative rights mapping via checkbox configurations within User Update workflows.
* **Pagination & Directional Sorting:** Scalable listing engine fetching specific indexes natively (`LIMIT / OFFSET`) preventing memory leaks on heavy record arrays, featuring multi-column dynamic toggle sorting links.

---
## 🧪 Running Unit Tests
All structural testing suites are handled via PHPUnit and isolated within the app container. Run them using:
```bash
docker exec -it php_users_manager_app ./vendor/bin/phpunit

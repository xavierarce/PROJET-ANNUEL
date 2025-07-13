
# 💬 Chat Web 2.0

A simple PHP chat application using a 4-tier architecture (Controller → Service → DAO → Model), powered by **Docker**, **MySQL**, and **Apache**.

---

## 🚀 How to Launch the Project

```bash
# 1. Clone the repo
git clone https://github.com/your-username/chat-app.git
cd chat-app

# 2. Create a .env file at the root
echo "MYSQL_ROOT_PASSWORD=yourpassword
MYSQL_DATABASE=chat_web
MYSQL_USER=user
MYSQL_PASSWORD=password" > .env

# 3. Install PHP dependencies locally
cd src
composer install
cd ..

# 4. Build and run the project
docker-compose down --volumes --remove-orphans
docker-compose up --build
```


* 🌐 App: [http://localhost:8000](http://localhost:8000)
* 🛠️ phpMyAdmin: [http://localhost:8080](http://localhost:8080) (use credentials from `.env`)


## 🧱 Project Structure

```pgsql
src/
├── controller/      → Handles routing & business logic
├── service/         → Processes data, validation
├── dao/             → Database access & queries
├── model/           → DB connection & data structures
├── view/            → PHP templates (HTML + PHP)
├── public/          → Entry point (index.php)
├── socket/          → WebSocket server (server.php)
├── vendor/          → Composer dependencies (generated)

```


## 🛠 Database Setup

* `schema.sql`: Creates tables
* `seed.sql`: Adds test data (users, rooms, messages, etc.)

Both are automatically loaded when you launch the containers.

To reset the database:

```bash
docker-compose down --volumes --remove-orphans
docker-compose up --build
```

## 🔌 WebSockets (Real-Time Chat)

WebSocket server runs automatically via Docker using [Ratchet](http://socketo.me/).

## 📦 Stack

* PHP 8.1
* MySQL 8.0
* Apache
* Docker & Docker Compose
* Ratchet (WebSockets)

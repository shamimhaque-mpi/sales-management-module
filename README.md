# Laravel Project

This is a Laravel project that includes **Models**, **Migrations**, and **Seeders** to manage database structure and initial data population.

## 🚀 Features
- **Models** – Define and interact with your database tables using Eloquent ORM.  
- **Migrations** – Version-controlled database schema management.  
- **Seeders** – Populate the database with test or default data.  

## ⚙️ Requirements
- PHP >= 8.1  
- Composer  
- Laravel >= 10  
- MySQL / MariaDB / PostgreSQL  

## 📦 Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/shamimhaque-mpi/sales-management-module
   cd sales-management-module
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Copy `example.env` to `.env` and configure your database:
   ```bash
   cp example.env .env
   ```

4. Generate application key:
   ```bash
   php artisan key:generate
   ```

## 🗄️ Database Setup

1. Run migrations:
   ```bash
   php artisan migrate
   ```

2. Run seeders:
   ```bash
   php artisan db:seed
   ```


## ▶️ Run the Project

Start the local development server:
```bash
php artisan serve
```

Then open in your browser:
```
http://127.0.0.1:8000
```

## 📂 Project Structure
```
app/Models          -> Application models
database/migrations -> Migration files
database/seeders    -> Seeder files
```

## 🤝 Contribution
Feel free to fork this repo and submit pull requests.  

---


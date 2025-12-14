# Role-Based Access Control (RBAC) API

This project demonstrates a simple **Role-Based Access Control (RBAC)** system built with Laravel, Laravel Passport, PostgresSQL.  
It provides authentication and authorization features where users are assigned a role and permissions are enforced based on those each role.

---

## Features
- User authentication with Laravel Passport
- Role-based authorization middleware
- Predefined roles: **User**, **Moderator**, **Admin**
- Database seeder that creates a default **Admin user** with all permissions

---

## Installation
1. **Clone the repository**
   git clone https://github.com/your-username/rbac-api.git

2. **Run migrations and seed db**
    php artisan migrate
    php artisan db:seed

---

## Configuration
After running php artisan db:seed, the seeder will create a default Super User with ability to assign roles and permissions.

Email: 'super@example.com'
Password: 'password'

This user can assign roles to users and permissions to roles.


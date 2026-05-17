# Work Integrated Learning Project (WIL) Allocation System

A Laravel web application for managing Work Integrated Learning (WIL) project allocations between students, industry partners, and teachers at Griffith University.

 <img width="1417" height="887" alt="image" src="https://github.com/user-attachments/assets/a283dcf7-0b3b-4a6a-b8ad-39bca9870937" />
 <img width="1417" height="887" alt="image" src="https://github.com/user-attachments/assets/267b8c56-8f36-44fc-bc34-04d2ea5bd360" />
 <img width="1417" height="887" alt="image" src="https://github.com/user-attachments/assets/766a9750-553a-4195-8a97-0dc87d5a1ccb" />




---

## Overview

The WIL Project Allocation System allows industry partners to post projects, students to apply, and teachers to run an automated GPA-based assignment algorithm that matches students to projects respecting team capacity limits.

---

## Features

- **Industry Partners** — Register, post projects (with file/image attachments), and await teacher approval
- **Students** — Browse projects, apply to up to 3 projects per offering, set GPA and skill roles
- **Teachers** — Approve industry partners, view all students, and run auto-assignment
- **Auto-Assignment** — GPA-sorted algorithm that assigns students to their highest-preference available project, respecting team size caps
- **Quick Login** — Dev dropdown on the login page to switch between test accounts instantly

---

## User Roles

| Role | Capabilities |
|---|---|
| Student | View projects, apply (max 3), edit own profile (GPA + roles) |
| Industry Partner | Create/edit/delete own projects, upload files |
| Teacher | Approve industry partners, view all students, run auto-assign |

---

## Tech Stack

- **Backend** — PHP 8.4, Laravel 10
- **Frontend** — Blade, Tailwind CSS, Alpine.js (via Laravel Breeze)
- **Database** — MySQL
- **Build** — Vite

---

## Requirements

- PHP >= 8.1
- Composer
- Node.js & npm
- MySQL

---

## Setup

```bash
# 1. Clone the repo
git clone <repo-url>
cd Project-Allocation-1

# 2. Install PHP dependencies
composer install

# 3. Install JS dependencies and build assets
npm install && npm run build

# 4. Copy environment file and generate app key
cp .env.example .env
php artisan key:generate

# 5. Configure your database in .env
#    DB_DATABASE=your_db
#    DB_USERNAME=your_user
#    DB_PASSWORD=your_password

# 6. Run migrations and seed test data
php artisan migrate:fresh --seed

# 7. Link storage for file uploads
php artisan storage:link

# 8. Start the dev server
php artisan serve
```

> **PHP 8.4 note:** Laravel 10 emits deprecation notices on PHP 8.4. These are suppressed via `php.ini` (`error_reporting = E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED`) and the pre-load workaround in `artisan`. They do not affect functionality.

---

## Test Accounts

All accounts use password: **`12345678`**

A quick-login dropdown on the login page auto-fills any of these accounts.

### Students

| Name | Email | GPA |
|---|---|---|
| Alice | alice@mail.com | 6.5 |
| Emma | emma@mail.com | 6.0 |
| Tom | T@mail.com | 5.5 |
| Carol | carol@mail.com | 5.0 |
| Bob | bob@mail.com | 4.0 |
| David | david@mail.com | 3.5 |

### Teacher

| Name | Email |
|---|---|
| Garry | garry@gmail.com |

### Industry Partners

| Name | Email | Status |
|---|---|---|
| Medi Care | medicare@mail.com | Approved |
| My Gov | mygov@mail.com | Approved |
| Tank Stream Design | TSD@mail.com | Approved |
| LSKD | lskd@mail.com | Pending |
| AirTasker | air@mail.com | Pending |
| Canva | canva@mail.com | Pending |

---

## Seeded Projects (2026 Trimester 1)

Pre-seeded with applications from all 6 students so auto-assign can be demonstrated immediately.

| Project | Partner | Team Size |
|---|---|---|
| Healthcare Portal | Medi Care | 3 |
| Government Services App | My Gov | 4 |
| E-Commerce Platform | Tank Stream Design | 3 |

---

## Auto-Assignment

Log in as **Garry (Teacher)** → go to **Students** → select **2026 / Trimester 1** → click **Run Auto-Assignment**.

The algorithm:
1. Resets any existing assignments for the selected offering
2. Sorts students by GPA (descending)
3. For each student (highest GPA first), assigns them to their first-choice project that still has capacity
4. Skips to next preference if a project is full

Expected result for 2026 T1:

| Student | GPA | Assigned To |
|---|---|---|
| Alice | 6.5 | Healthcare Portal |
| Emma | 6.0 | Government Services App |
| Tom | 5.5 | Healthcare Portal |
| Carol | 5.0 | Healthcare Portal |
| Bob | 4.0 | Government Services App |
| David | 3.5 | E-Commerce Platform |

---

## Database Schema

```
users               — auth table (usertype: student | industry_partner | teacher)
students            — student profiles (gpa, roles[])
teachers            — teacher profiles
industry_partners   — partner profiles (approved boolean)
projects            — project listings (title, description, team_size, trimester, year)
student_project     — applications pivot (justification, assigned boolean)
project_files       — uploaded files/images per project
```

---

## Key Routes

| Method | URI | Description |
|---|---|---|
| GET | `/` | Industry partners home |
| GET | `/projects` | Project listing |
| GET | `/projects/{id}/apply` | Apply to a project (student) |
| GET | `/students` | Student list (teacher) |
| POST | `/auto-assign` | Run auto-assignment (teacher) |
| GET | `/industry-partners/approval-menu` | Approve partners (teacher) |

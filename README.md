# 📋 Accura Members Management - Laravel CRUD Application

A Laravel-based CRUD application to manage **Accura Members** as part of a PHP full-stack technical assignment.  
The system allows adding, listing, searching, editing, and deleting members with DS Division selection.  
It follows MVC architecture, OOP principles, and includes server & client-side validation.

---

## 🚀 Features
- **Laravel 11** with MVC structure & Eloquent ORM  
- **MySQL database** with `members` and `ds_divisions` tables  
- **Bootstrap 5** for responsive, user-friendly UI  
- **CRUD operations** (Create, Read, Update, Delete)  
- Search members by last name (AJAX or normal form submit)  
- **Special Rule**: If Summary = `"ACCURA"`, append `" ACCURA"` to last name  
- Clean, maintainable codebase following Laravel best practices  

---

## 🗄 Database Structure

### `ds_divisions` table
| Column | Type    | Description |
|--------|---------|-------------|
| id     | INT PK  | Auto Increment |
| name   | VARCHAR | DS Division name |

### `members` table
| Column         | Type     | Description |
|----------------|----------|-------------|
| id             | INT PK   | Auto Increment |
| first_name     | VARCHAR  | Optional |
| last_name      | VARCHAR  | Required |
| ds_division_id | INT FK   | Linked to `ds_divisions` |
| summary        | TEXT     | Optional |
| created_at     | TIMESTAMP| Laravel default |
| updated_at     | TIMESTAMP| Laravel default |

---


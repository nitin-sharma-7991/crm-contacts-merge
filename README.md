# CRM Contacts Management with Merge Feature

This project implements a **CRM-style Contacts Management System** built using **Laravel and Filament**.  
It provides functionality for managing contacts, dynamic custom fields, and a robust merge feature that preserves data integrity without data loss.

---

## 🚀 Features

### ✅ Basic CRM
- Full CRUD for Contacts
- Contact Fields:
  - Name
  - Email
  - Phone
  - Gender (Radio)
  - Profile Image Upload
  - Additional File Upload
- Dynamic Custom Fields (flexible user-defined fields)
- AJAX-powered UI using Filament Livewire
- Filters by Name, Email, and Gender

---

### ✅ Merge Contacts
- Merge a secondary contact into a master contact
- Select the master contact via modal
- Merge emails and phones as unique, comma-separated lists
- Merge custom fields safely without duplication
- Secondary contact marked as merged but **not deleted**
- Merged contacts excluded from main contact list

---

## 🗄 Database Schema

### `contacts` table
| Column          | Description                          |
|-----------------|------------------------------------|
| id              | Primary key                        |
| user_id         | Owner/User reference                |
| name            | Contact's full name                 |
| email           | Contact email(s)                   |
| phone           | Contact phone number(s)            |
| gender          | Contact gender                     |
| profile_image   | Profile image file path             |
| additional_file | Additional uploaded file path       |
| is_merged       | Boolean to mark merged contacts    |
| merged_into     | Master contact id if merged        |
| created_at      | Timestamp                         |
| updated_at      | Timestamp                         |

---

### `custom_fields` table
| Column    | Description                |
|-----------|----------------------------|
| id        | Primary key                |
| name      | Custom field name          |
| type      | Field data type (e.g. text)|
| created_at| Timestamp                 |
| updated_at| Timestamp                 |

---

### `contact_custom_field_values` table
| Column          | Description                     |
|-----------------|---------------------------------|
| id              | Primary key                    |
| contact_id      | Foreign key to contacts          |
| custom_field_id | Foreign key to custom_fields     |
| value           | Stored value of the custom field |
| created_at      | Timestamp                     |
| updated_at      | Timestamp                     |

---

### `users` table (Application Users)
| Column            | Description                      |
|-------------------|----------------------------------|
| id                | Primary key                    |
| name              | User's full name               |
| email             | User's email address           |
| email_verified_at | Email verification timestamp   |
| password          | Hashed password                |
| remember_token    | Token for session persistence  |
| created_at        | Timestamp                    |
| updated_at        | Timestamp                    |

---

## 🔁 Merge Logic Explained

- The **master contact** remains active and retains its data.
- The **secondary contact** is marked as merged (`is_merged = true`) and linked to the master via `merged_into`.
- Emails and phones from both contacts are merged into unique, comma-separated lists in the master.
- Custom fields are merged as follows:
  - If the master contact **does not have** a custom field, it is added.
  - If the master contact **already has** the custom field with the same value, it is skipped.
- No data is lost; merged contacts are hidden but retained for audit.

---

## 🎥 Demo Video

A demo video showcasing:
- Creating contacts with dynamic custom fields
- Performing contact merges
- Viewing database changes before and after merges

---

## 🧑‍💻 Technology Stack

- Laravel 9
- Filament v2.17
- MySQL
- Livewire

---

## 📌 Use Case

Ideal for:
- CRM systems
- Lead and contact management
- Handling duplicates efficiently
- Admin dashboards with extensible contact fields

---


**Happy Coding!**

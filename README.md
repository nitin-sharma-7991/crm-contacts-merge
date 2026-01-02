# CRM Contacts Management with Merge Feature

This project implements a **CRM-like Contacts module** using **Laravel + Filament**.

## 🚀 Features

### ✅ Basic CRM
- Full CRUD for Contacts with real-time updates
- AJAX-powered UI via **Filament Livewire components** (no page reloads)
- Fields:
  - Name
  - Email
  - Phone
  - Gender (Radio)
  - Profile Image Upload
  - Additional File Upload
- Dynamic Custom Fields (flexible user-defined fields)
- Filters by Name, Email, and Gender

### ✅ Merge Contacts
- Merge two contacts into one master contact
- Select Master Contact from existing active contacts
- Emails & phones merged into comma-separated lists
- Custom fields merged safely without data loss
- Secondary contact marked as merged and hidden from lists

---

## 🗄 Database Design

### contacts
- `id`, `user_id`, `name`, `email`, `phone`, `gender`, `profile_image`, `additional_file`
- `is_merged` (boolean to mark merged contacts)
- `merged_into` (references master contact id)
- Timestamps

### custom_fields
- `id`, `name`, `type` (field type), timestamps

### contact_custom_field_values
- `id`, `contact_id`, `custom_field_id`, `value`, timestamps

### users
- `id`, `name`, `email`, `password`, timestamps, and other auth fields

---

## 🔁 Merge Logic

- Master contact remains active and retains its ID
- Secondary contact:
  - Marked as `is_merged = true`
  - `merged_into` set to the master contact's ID
- Emails and phones combined uniquely with commas
- Custom fields:
  - Values from secondary moved if master lacks them
  - Existing values on master remain unchanged

---

## AJAX Implementation Note

Although the task suggested using AJAX, this project leverages **Filament's Livewire framework**, which provides reactive, AJAX-driven CRUD operations out-of-the-box. This ensures smooth, asynchronous updates without full page reloads, fulfilling the AJAX requirement seamlessly within the Laravel ecosystem.

---

## 🎥 Demo Video (Recommended)
- Show creating, editing, deleting contacts
- Demonstrate merge action and modal form
- Show database state before and after merging

---

## 🧑‍💻 Tech Stack
- Laravel 9+
- Filament v2.x
- MySQL or compatible database
- Livewire (for reactive UI)

---

## Installation

1. Clone repository  
2. Run `composer install`  
3. Set up `.env` file and database  
4. Run migrations with `php artisan migrate`  
5. Serve with `php artisan serve`

---

## Author

Created as part of a practical task for CRM Contacts Management with merge functionality.

---


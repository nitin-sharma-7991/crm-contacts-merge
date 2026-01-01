# CRM Contacts Management with Merge Feature

This project implements a **CRM-like Contacts module** using **Laravel + Filament**.

## 🚀 Features

### ✅ Practical 1: Basic CRM
- CRUD for Contacts
- Fields:
  - Name
  - Email
  - Phone
  - Gender (Radio)
  - Profile Image
  - Additional File
- Dynamic Custom Fields (Birthday, Company, etc.)
- AJAX CRUD (Filament Livewire)
- Filters by Name, Email, Gender

### ✅ Practical 2: Merge Contacts
- Merge two contacts
- Select Master Contact
- Emails & phones merged (comma separated)
- Custom fields moved safely
- No data loss
- Secondary contact marked as merged
- Merged contacts hidden from list

---

## 🗄 Database Design

### contacts
- is_merged
- merged_into

### custom_fields
- Dynamic user-defined fields

### contact_custom_field_values
- Stores values per contact
- Updated during merge

---

## 🔁 Merge Logic

- Master contact remains active
- Secondary contact:
  - Marked `is_merged = true`
  - `merged_into = master_id`
- Custom fields:
  - If master doesn’t have → moved
  - If exists → kept on master

---

## 🎥 Demo Video (Required)
- Show CRUD
- Show merge action
- Show DB changes before/after merge

---

## 🧑‍💻 Tech Stack
- Laravel 9
- Filament v2.17
- MySQL

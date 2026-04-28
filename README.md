# 🏥 MediSync - Clinic Management System

## 1. Project Overview
**MediSync** is a modern, fast, and comprehensive management system designed specifically for medical and dental clinics. Built with a focus on usability and performance, it provides a seamless experience for managing appointments, patient records, medical services, and diagnostic reports all in one centralized platform.

## 2. Key Features
*   🔐 **Authentication & Roles:** Secure login system with distinct dashboards and permissions for Doctors (Admins) and Patients.
*   🎨 **Modern UI with Floating Sidebar:** A premium, responsive user interface featuring a sleek floating sidebar, ensuring optimal navigation on any device.
*   🌍 **Fully Multilingual (i18n):** Complete translation support for **English**, **French**, and **Arabic**, including automatic **RTL (Right-to-Left)** layout adaptation for Arabic users.
*   🌙 **Global Dark Mode:** A sophisticated, eye-friendly dark mode implemented using Alpine.js and Tailwind CSS, persisting across all pages via local storage.
*   💬 **Interactive Modals & Toast Notifications:** Smooth popup modals for CRUD operations and live, non-intrusive toast alerts for user feedback.
*   ⚡ **Dynamic Data & Filtering:** Intelligent, dynamic dropdowns for filtering medical reports and managing clinic services effortlessly.

## 3. Tech Stack
*   **Backend:** Laravel (PHP)
*   **Frontend Styling:** Tailwind CSS
*   **Frontend Logic:** Alpine.js
*   **Database:** MySQL

## 4. Installation Guide
Please follow these step-by-step instructions to set up the project locally.

**Step 1:** Clone the repository
```bash
git clone https://github.com/saddikihasnae/MediSync.git
cd MediSync_App
```

**Step 2:** Install PHP dependencies
```bash
composer install
```

**Step 3:** Install NPM dependencies and compile assets
```bash
npm install
npm run build
```

**Step 4:** Configure the environment
```bash
cp .env.example .env
```
*(Make sure to update the `.env` file with your local MySQL database credentials: `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`)*

**Step 5:** Generate the application key
```bash
php artisan key:generate
```

**Step 6:** Run migrations and seeders
```bash
php artisan migrate:fresh --seed
```
> **Note:** This command will automatically generate all necessary database tables and populate the system with dummy data (dummy clinic services, appointments, medical reports, and test users).

**Step 7:** Link the storage (For profile pictures and medical reports)
```bash
php artisan storage:link
```


**Step 8:** Run the local development server
Open your terminal and run the Laravel server:


php artisan serve
**Step 9:** Compile frontend assets (Vite)
Open a second (new) terminal window in the same project directory and run the following command to compile Tailwind CSS and Alpine.js:


npm run dev
(You can now access the application in your browser at http://localhost:8000)

## 5. Default Credentials
Use the following credentials to immediately log in and test the system without needing to register new accounts.

| Role | Name | Email Address | Password |
| :--- | :--- | :--- | :--- |
| **Doctor (Admin)** | Dr. Ahmed Ali | `doctor@medisync.com` | `password` |
| **Patient 1** | Sarah Johnson | `patient1@medisync.com` | `password` |
| **Patient 2** | Michael Smith | `patient2@medisync.com` | `password` |

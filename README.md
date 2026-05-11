# LensRent - Camera Rental Management System 📷

LensRent is a modern, full-featured web application built with Laravel that streamlines the process of renting cameras and gear. It is designed with a striking high-contrast "Black and White" (neo-brutalist) UI aesthetic.

## ✨ Key Features

- **Role-Based Access Control (RBAC):** Secured with Laravel Gates. Two distinct user roles:
  - **Admin:** Manages camera inventory, categories, verifies customer payments, tracks rental statuses, and processes returns.
  - **Customer:** Browses the camera catalog, makes reservations, views rental history, and uploads payment proofs.
- **Complete Inventory Management:** Full CRUD (Create, Read, Update, Delete) functionality for both Camera Categories and individual Camera units.
- **Robust Rental Workflow:**
  - Customers select rental duration, and the system automatically calculates the total fee.
  - Integration with a payment proof upload system.
  - Admins can approve or reject payments. Rejections automatically update the rental status and free up the camera for others.
- **Automated Late Fines:** When processing a return, the system automatically detects if it's past the due date and calculates appropriate late fees based on the camera's daily rate.
- **Striking Aesthetic:** A fully responsive, modern neo-brutalist UI built with Tailwind CSS, featuring bold typography, heavy borders, and high-contrast interactions.

## 🛠️ Technology Stack

- **Backend:** Laravel 11 (PHP)
- **Frontend:** Blade Templating, Tailwind CSS, Alpine.js
- **Database:** MySQL
- **Authentication:** Laravel Breeze
- **Authorization:** Laravel Gates

## 🚀 Getting Started

Follow these instructions to set up the project locally on your machine.

### Prerequisites

- PHP >= 8.2
- Composer
- Node.js and NPM
- MySQL or compatible database server

### Installation

1. **Clone the repository:**
   ```bash
   git clone <repository-url>
   cd Kel6_PrakWebUAS
   ```

2. **Install PHP dependencies:**
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies:**
   ```bash
   npm install
   ```

4. **Environment Setup:**
   Copy the example environment file and configure your database credentials.
   ```bash
   cp .env.example .env
   ```
   *Open `.env` and update `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD`.*

5. **Generate Application Key:**
   ```bash
   php artisan key:generate
   ```

6. **Run Migrations and Seeders:**
   This will create the database tables and populate them with initial data (like an admin account, categories, etc.).
   ```bash
   php artisan migrate --seed
   ```

7. **Create a Symbolic Link for Storage:**
   Required for displaying uploaded images (payment proofs, camera images).
   ```bash
   php artisan storage:link
   ```

8. **Run the Application:**
   Start the development server and Vite for asset compilation.
   ```bash
   php artisan serve
   ```
   In a separate terminal window:
   ```bash
   npm run dev
   ```

9. **Access the App:**
   Open your browser and navigate to `http://localhost:8000`.

## 👥 Default Accounts

If database seeders were used, you can log in with:
- **Admin:** (Check `DatabaseSeeder.php` for credentials, typically `admin@example.com` or similar)
- **Customer:** (Check `DatabaseSeeder.php` for credentials)

## 📄 License

This project is open-source and available under the [MIT license](https://opensource.org/licenses/MIT).

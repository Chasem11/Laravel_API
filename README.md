# Media Library Project

This project is a simple **Media Library** web application built with **Laravel**. It allows users to view available books and movies, and also create new users (students or teachers).

## Features

- View available books.
- View available movies.
- Create new users (students or teachers) with conditional form inputs.
- A shared navigation bar with links to home, books, movies, and user creation.
- Responsive design using **Bootstrap 5**.

## Table of Contents

- [Installation](#installation)
- [Usage](#usage)
- [Routes](#routes)
- [Database Setup](#database-setup)
- [Views](#views)
- [Future Enhancements](#future-enhancements)

## Installation

Follow these steps to set up the project on your local machine:

1. **Clone the repository**:

    ```bash
    git clone https://github.com/your-username/your-repo.git
    cd your-repo
    ```

2. **Install dependencies**:

    Make sure you have Composer installed, then run:

    ```bash
    composer install
    ```

3. **Set up the environment**:

    Copy the `.env.example` file to `.env`:

    ```bash
    cp .env.example .env
    ```

    Generate the application key:

    ```bash
    php artisan key:generate
    ```

4. **Configure your `.env` file**:

    Update the `.env` file with your database credentials and other environment variables.

5. **Run migrations**:

    Run the database migrations to set up the necessary tables:

    ```bash
    php artisan migrate
    ```

6. **Serve the application**:

    Start the Laravel development server:

    ```bash
    php artisan serve
    ```

7. **Access the application**:

    Open your browser and go to:

    ```
    http://127.0.0.1:8000
    ```

## Usage

The project allows you to:
- View all available books and movies.
- Create new users, selecting between students (with grade level) and teachers (with department).

### Creating a New User

- Click the **Create User** link in the navigation bar.
- Fill in the form, which conditionally displays additional fields based on whether the user is a student or a teacher.

### Viewing Available Books and Movies

- Click **Books** or **Movies** in the navigation bar to view all available media.

## Routes

Here are the main routes in the application:

| HTTP Method | URI             | Description                     |
|-------------|-----------------|---------------------------------|
| GET         | `/books`         | View available books            |
| GET         | `/movies`        | View available movies           |
| GET         | `/createUser`    | Display the form to create a user |
| POST        | `/createUser`    | Handle the form submission for creating a new user |
| GET         | `/`              | Home page                       |

## Database Setup

The database structure for this project includes the following tables:

### Users Table

| Column       | Type    | Description                               |
|--------------|---------|-------------------------------------------|
| `id`         | INT     | Auto-incrementing primary key              |
| `first_name` | STRING  | First name of the user                     |
| `last_name`  | STRING  | Last name of the user                      |
| `email`      | STRING  | Email (unique)                             |
| `user_type`  | ENUM    | Type of user (`student`, `teacher`)        |
| `grade_level`| INT     | Grade level (nullable, for students only)  |
| `department` | STRING  | Department (nullable, for teachers only)   |
| `gender`     | ENUM    | Gender (`male`, `female`, `other`)         |
| `created_at` | TIMESTAMP | Creation timestamp                        |
| `updated_at` | TIMESTAMP | Update timestamp                          |

### Books Table

| Column       | Type    | Description                               |
|--------------|---------|-------------------------------------------|
| `id`         | INT     | Auto-incrementing primary key              |
| `title`      | STRING  | Title of the book                          |
| `author`     | STRING  | Author of the book                         |
| `year`       | INT     | Year of publication                        |
| `available`  | BOOLEAN | Indicates whether the book is available    |

### Movies Table

| Column       | Type    | Description                               |
|--------------|---------|-------------------------------------------|
| `id`         | INT     | Auto-incrementing primary key              |
| `title`      | STRING  | Title of the movie                         |
| `director`   | STRING  | Director of the movie                      |
| `year`       | INT     | Year of release                            |
| `available`  | BOOLEAN | Indicates whether the movie is available   |

## Views

Here are the main views in the application:

- **`media/index.blade.php`**: The main page showing links to books, movies, and user creation.
- **`media/books.blade.php`**: Displays all available books.
- **`media/movies.blade.php`**: Displays all available movies.
- **`newUser.blade.php`**: The form to create a new user (student or teacher).
- **`partials/navbar.blade.php`**: A reusable navbar partial to be included in all views.

## Future Enhancements

- Add user authentication (login/register functionality).
- Improve search and filter options for books and movies.
- Add pagination for large sets of data.
- Implement user roles (e.g., admin vs standard user) with different permissions.

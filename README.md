# Media Library Project

This project is a simple **Media Library** web application built with **Laravel**. It allows users to view available books and movies, and also create new users (students or teachers).

## Features

- View available books and movies.
- Create new users (students or teachers) with conditional form inputs based on user type.
- Login and register options for user accounts.
- Rent and return items, with tracking of due dates for logged-in users.
- Interactive chatbot feature for checking availability of specific items and retrieving information on due rentals.
- A shared navigation bar with links to home, books, movies, user creation, rental options, and chatbot.
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
- Login to existing accounts
- Create new users, selecting between students (with grade level) and teachers (with department).
- Rent and return items, with tracking of due dates for logged-in users.
- Check availability of specific books or movies using a basic chatbot feature.
- Access detailed user and rental management features.

### Login
- Click the **Login** link on the Laravel welcome page.
- Fill in the form, and you will be redirected to the home page.

### Creating a New User

- Click the **Register** link on the Laravel welcome page.
- Fill in the form, which conditionally displays additional fields based on whether the user is a student or a teacher.

### Viewing Available Books and Movies

- Click **Books** or **Movies** in the navigation bar to view all available media.

### Renting and Returning Items

- To rent an item, navigate to the **Rent Item** page. Only available items will be shown for selection.
- To return an item, go to the **Return Item** page, where you can select from items currently rented by the logged-in user.

### Chatbot Interaction (Beta)

- Use the **Chatbot** feature to inquire about due rentals, available books and movies, and specific item availability.
- Enter questions like “Is [Title] available to rent?” or “What movies are available?” to get immediate responses on availability.
  
**Note:** The chatbot is in a basic beta version and may not recognize questions with typos or unusual wording. Please use straightforward phrases for the best results.


## Routes

Here are the main routes in the application:

| HTTP Method | URI                  | Description                                                              |
|-------------|----------------------|--------------------------------------------------------------------------|
| GET         | `/books`             | View available books                                                     |
| GET         | `/movies`            | View available movies                                                    |
| GET         | `/createUser`        | Display the form to create a new user                                    |
| POST        | `/createUser`        | Handle form submission for creating a new user                           |
| GET         | `/home`              | Home page                                                                |
| GET         | `/users`             | View list of all users                                                   |
| GET         | `/rentals`           | View list of all rentals                                                 |
| GET         | `/availableBooks`    | View list of available books                                             |
| GET         | `/availableMovies`   | View list of available movies                                            |
| GET         | `/dueRentals`        | View list of due rentals for the logged-in user                          |
| GET         | `/displayBooksView`  | Display view with all available books                                    |
| GET         | `/displayMoviesView` | Display view with all available movies                                   |
| GET         | `/displayRentView`   | Display view to rent an item                                             |
| GET         | `/displayReturnView` | Display view to return a rented item                                     |
| POST        | `/rentItem`          | Handle form submission to rent an item                                   |
| POST        | `/returnItem`        | Handle form submission to return a rented item                           |
| POST        | `/login`             | User login                                                               |
| POST        | `/logout`            | User logout                                                              |
| POST        | `/chatbot`           | Chatbot interaction for rental and item availability inquiries           |

## API Documentation

This project includes interactive API documentation with **Swagger**, providing a complete overview of available endpoints and data models.

### Accessing Swagger Documentation

After setting up and running the application:

1. Open your browser and navigate to:
`http://127.0.0.1:8000/api/documentation`

2. Use the interactive UI to view all endpoints, send requests, and examine responses.

### Key API Documentation Highlights
- All available API routes are documented, with descriptions of request parameters, responses, and examples.
- Schemas for each model (`User`, `Rental`, `Book`, `Movie`) are also included, showing data structure and required fields.
- Easily test endpoints for:
- **User registration** and **login**
- **Viewing media** (books and movies)
- **Renting and returning items**
- **Chatbot queries** for item availability and due rentals

This documentation makes it easy for developers and testers to explore and understand the API's functionality and data structures.


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
| `gender`     | ENUM    | Gender (`male`, `female`)                  |
| `password`   | STRING  | Password for the users account              |
| `created_at` | TIMESTAMP | Creation timestamp                        |
| `updated_at` | TIMESTAMP | Update timestamp                          |

### Rental Table

| Column Name | Type     | Nullable | Description                                       |
|-------------|----------|----------|---------------------------------------------------|
| `id`        | integer  | No       | Unique identifier for the rental                  |
| `renter_id` | integer  | No       | The ID of the user who rented the item            |
| `rental_date` | string (date) | No | The date the item was rented                      |
| `return_date` | string (date) | Yes | The date the item was returned                    |
| `returned`  | boolean  | No       | Status of whether the item has been returned      |
| `book_id`   | integer  | Yes      | ID of the rented book, `null` if a movie is rented |
| `movie_id`  | integer  | Yes      | ID of the rented movie, `null` if a book is rented |
| `user`      | relation | No       | User who rented the item (relation to User schema)|
| `movies`    | relation | Yes      | Movie associated with the rental (relation to Movie schema) |
| `books`     | relation | Yes      | Book associated with the rental (relation to Book schema)   |


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

- **`home.blade.php`**: The main page showing links to books, movies, and user creation.
- **`login.blade.php`**: Allows users to sign into their account using their email and password.
- **`register.blade.php`**: Allows users to create a new account.
- **`books.blade.php`**: Displays all available books.
- **`movies.blade.php`**: Displays all available movies.
- **`newUser.blade.php`**: The form to create a new user (student or teacher).
- **`navbar.blade.php`**: A reusable navbar partial to be included in all views.
- **`chatbot.blade.php`**: A simple chatbot that users can ask very basic questions to.
- **`rentItems.blade.php`**: Allows users to rent available Books or Movies.
- **`returnItem.blade.php`**: Allows users to return due rentals.

## Future Enhancements
- Improve search and filter options for books and movies.
- Add pagination for large sets of data.
- Implement user roles (e.g., admin vs standard user) with different permissions.
- Add a third party AI to provide better chatbot capabilities.

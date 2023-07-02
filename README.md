# CRUD App

This is a simple CRUD (Create, Read, Update, Delete) application built using the MVC (Model-View-Controller) architectural pattern.

## Features

- Create new records
- Read existing records
- Update existing records
- Delete records

## Requirements

- PHP >= 7.2
- MySQL database

## Installation

1. Clone the repository to your local machine or server:

   ```
   git clone https://github.com/mohamdebenchikh/crud-app.git
   ```

2. Navigate to the project directory:

   ```
   cd crud-app
   ```

3. Configure the database connection by updating the `config.php` file located in the `src` directory. Modify the following constants according to your database configuration:

   ```php
   define('DB_HOST', 'localhost');
   define('DB_PORT', '3306');
   define('DB_NAME', 'your_database_name');
   define('DB_USER', 'your_database_user');
   define('DB_PASS', 'your_database_password');
   ```

4. Import the SQL schema into your MySQL database. The SQL file can be found in the `database` directory.

5. Start the development server or configure your web server to serve the `public` directory as the document root.

6. Access the application in your web browser:

   ```
   http://localhost/crud-app
   ```

## Usage

- Home: Access the home page of the CRUD app.
- Create: Add a new record to the database.
- Read: View existing records in a paginated format.
- Update: Modify the details of an existing record.
- Delete: Remove a record from the database.

## Contributing

Contributions are welcome! If you find any issues or have suggestions for improvement, please create an issue or submit a pull request.

## Acknowledgments
   This CRUD app MVC project was developed as a learning exercise and may serve as a starting point for building more complex applications.

   Feel free to customize the configuration values and adapt the instructions based on your specific setup and requirements.


## License

This project is licensed under the [MIT License](https://opensource.org/licenses/MIT).
```

Copy the entire content and save it as `README.md` in the root directory of your Git repository.

# Laravel Multi-tenant Application Template

A Laravel-based multi-tenant application template that allows multiple organizations to use the same application instance while maintaining data isolation.

## Features

- Multi-tenant architecture with domain-based separation
- Built-in authentication system with password reset functionality
- Tenant-aware database queries and models
- Asset compilation with Laravel Mix
- Testing environment setup
- CORS support
- Modern frontend setup with Bootstrap and Axios

## Prerequisites

Before you begin, ensure you have the following installed:

### PHP >= 8.1.6

- **Windows**: Download the PHP installer from [php.net](https://windows.php.net/download/) and follow the installation instructions.
- **macOS**: Use Homebrew:
  ```bash
  brew install php
  ```
- **Linux**: Use your distribution's package manager. For example, on Ubuntu:
  ```bash
  sudo apt update
  sudo apt install php8.1
  ```

### Composer

- **All Platforms**: Follow the instructions on the [Composer website](https://getcomposer.org/download/) to download and install Composer globally.

### Node.js & NPM

- **Windows/macOS/Linux**: Download the installer from the [Node.js website](https://nodejs.org/) and follow the installation instructions. This will install both Node.js and NPM.

### MySQL >= 5.7 or MariaDB >= 10.3

- **Windows/macOS/Linux**: Download and install MySQL from the [MySQL website](https://dev.mysql.com/downloads/installer/) or MariaDB from the [MariaDB website](https://mariadb.org/download/).

### Git

- **Windows**: Download and install Git from [git-scm.com](https://git-scm.com/).
- **macOS**: Use Homebrew:
  ```bash
  brew install git
  ```
- **Linux**: Use your distribution's package manager. For example, on Ubuntu:
  ```bash
  sudo apt update
  sudo apt install git
  ```

## Setup Guidelines

1. **Clone the Repository**
   ```bash
   git clone https://github.com/your-username/your-repo-name.git
   cd your-repo-name
   ```

2. **Install PHP Dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js Dependencies**
   ```bash
   npm install
   ```

4. **Compile Assets**
   ```bash
   npm run dev
   ```

## Setting Up the Environment

1. **Copy the Example Environment File**
   ```bash
   cp .env.example .env
   ```

2. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

3. **Configure Database Settings**
   - Open the `.env` file and update the following lines with your database credentials:
     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=your_database_name
     DB_USERNAME=your_database_user
     DB_PASSWORD=your_database_password
     ```

## Running the Project Locally

1. **Run Database Migrations**
   ```bash
   php artisan migrate
   ```

2. **Start the Development Server**
   ```bash
   php artisan serve
   ```

3. **Access the Application**
   - Open your web browser and go to `http://localhost:8000`

## Folder Structure

Here's an overview of the project's folder structure:

```plaintext
your-repo-name/
├── app/
│   ├── Console/
│   ├── Exceptions/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Middleware/
│   ├── Models/
│   ├── Providers/
│   └── ...
├── bootstrap/
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   ├── seeders/
├── public/
├── resources/
│   ├── js/
│   ├── lang/
│   ├── sass/
│   └── views/
├── routes/
│   ├── api.php
│   ├── channels.php
│   ├── console.php
│   └── web.php
├── storage/
│   ├── app/
│   ├── framework/
│   └── logs/
├── tests/
│   ├── Feature/
│   └── Unit/
├── vendor/
├── .env.example
├── artisan
├── composer.json
├── package.json
└── webpack.mix.js
```

### Explanation

- **app/**: Core application code, including models, controllers, and middleware.
- **bootstrap/**: Framework bootstrap files.
- **config/**: Configuration files.
- **database/**: Migrations, factories, and seeders.
- **public/**: Publicly accessible assets and front controller.
- **resources/**: Views, raw assets, and language files.
- **routes/**: Route definitions.
- **storage/**: Compiled templates, sessions, caches, and logs.
- **tests/**: Automated tests.
- **vendor/**: Composer dependencies.

## Additional Information

- **Testing**: To run tests, use the following command:
  ```bash
  php artisan test
  ```

- **CORS Configuration**: If you need to configure CORS, you can do so in the `config/cors.php` file.

- **Environment Variables**: Ensure all necessary environment variables are set in your `.env` file for proper application functionality.

- **Contributing**: If you wish to contribute, please fork the repository and submit a pull request.

- **License**: This project is licensed under the MIT License.

For any further questions or issues, please refer to the project's issue tracker or contact the maintainers.

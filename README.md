# Task Manager

## Description

Created Using Laravel with TypeScript, styled with Tailwind CSS

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/frfusch21/taskManager.git
   cd taskManager

2. Install Dependencies
    ```bash
    composer install
    npm install

3. Create a copy of .env file:
    ```bash
    cp .env.example .env

4. Generate an application key:
    ```bash
    php artisan key:generate
    Set up your database and other environment variables in the .env file.

5. Run migrations:
    ```bash
    php artisan migrate

6. Start the development server:
    ```bash
    php artisan serve
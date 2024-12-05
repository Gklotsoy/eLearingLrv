# Laravel eLearning Platform

This is an eLearning platform built with Laravel and Vite.js.

## Contents

- [Installation](#installation)
- [Configuration](#configuration)
- [Building Frontend Assets and Running the Application](#building-frontend-assets-and-running-the-application)

## Installation

1. **Clone the repository**:
   
   git clone https://github.com/Gklotsoy/eLearingPlatform-Laravel11
   cd eLearingPlatform-Laravel11
    
    Run the following commands:
    1. composer install (php dependencies)
    2. npm install (node dependencies)

## Configuration

1. **Create a copy of the .env file**:

    cp .env.example .env

2. **Update the .env file with your environment settings**:
    ```

    APP_NAME=Laravel
    APP_ENV=local
    APP_KEY=base64:your_generated_key_here
    APP_DEBUG=true
    APP_URL=http://localhost
    
    LOG_CHANNEL=stack
    
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_username
    DB_PASSWORD=your_database_password
    
    SESSION_DRIVER=database
    SESSION_LIFETIME=120

    MAX_UPLOAD_SIZE=51200
    ```
   
4. **Generate an application key**:

    php artisan key:generate

5. **Run database migrations**:
    php artisan migrate

6. **Link storage:
   php artisan storage:link

## Building Frontend Assets and Running the Application

1. In a teminal run:
    
    php artisan serve

2. In a second terminal tun:

    npm run dev 

3. Visit the application in your browser:

    http://localhost:8000

# Crowdfunding App
The Crowdfunding Application is a platform that allows individuals in need to request donations from the community. Anyone interested in donating—whether they are registered or unregistered—can contribute to these donation requests. The application is built using the Laravel framework, with a clear separation of concerns via Service classes, Controllers, and Models. The app supports features such as user registration, authentication, donation creation, and donation transactions. It is containerized using Docker for easy deployment and development.

## Features
### User Authentication & Registration:
 - **Authentication:** Managed via Laravel's built-in authentication system (Sanctum).
 - **Protected Features:** Only authenticated users can create and manage their donation requests.
### Donation Requests:
 - **Create Requests:** Authenticated users can create donation requests with a title, description, and target amount.
 - **Completion:** Once the target amount is reached, the donation request is marked as completed.
 - **List Requests:** Retrieve a paginated list of donation requests with customizable query parameters.
 - **View Request:** Retrieve a single donation request by its ID.
### Donation Transactions:
 - **Open to All Donors:** Anyone can donate, whether they have an account or not. Donors can choose to provide a name and email or donate anonymously.
 - **Transaction Records:** Each donation transaction records the amount donated and associates it with a specific donation request.
### Error Handling & Validation:
 - **Input Validation:** All inputs are validated using Laravel’s request validation, ensuring that the data entered is correct and follows the necessary rules.
 - **Error Handling:** Errors are handled within the service layer using try-catch blocks to manage exceptions gracefully, especially during database interactions.

## Setup Instructions
### Without Docker
#### Requirements
 * PHP 8.2 or higher
 * Composer
 * MySQL

#### Steps
 * Clone the repository and navigate to the project directory.
```
git clone git@github.com:roc41d/crowdfunding-app.git
cd crowdfunding-app
```
 * Install the dependencies using Composer.
```
  composer install
```
* Configure Environment Variables
```
cp .env.example .env
```
* Generate a new application key.
```
php artisan key:generate
```
* Run Migrations
```
php artisan migrate
```
* Start the development server.
```
php artisan serve
```
Access the api at `http://localhost:8000/api/`

### Without Docker
#### Requirements
 * Docker
 * Docker Compose

## API Documentation

### Authentication:
 - `POST /api/register`: Register a new user
```json
{
    "name": "John Doe", 
    "email": "johndoe@email.com", 
    "password": "12345678", 
    "password_confirmation": "12345678"
}
```
 - `POST /api/login`: Login a user
````json
{
    "email": "johndoe@email.com",
    "password": "12345678"
}
````
 - `POST /api/logout`: Logout a user
```
headers
  Authorization: Bearer {token}
```

## Donation Requests:
All requests require a valid token in the Authorization header.
```
headers
  Authorization: Bearer {token}
```
 - `POST /api/donations`: Create a new donation request (authenticated users only).
```json
{
    "title": "Donation name", 
    "description": "Donation description", 
    "target_amount": 100000
}
```
 - `GET /api/donations`: Retrieve a paginated list of donation requests (with customizable query parameters for page and per_page).
 - `GET /donations/{id}`: Retrieve a single donation request.

## Donation Transactions:
 - `POST /api/donations/{id}/donate`: Make a donation to a specific request, either as a registered user or as a guest (with an option to donate anonymously or provide a donor name and donor email).
```json
{
    "amount": 5000,
    "donor_name": "Mike Doe",
    "donor_email": "mikedoe@email.com"
}
```

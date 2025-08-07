<!-- Use this file to provide workspace-specific custom instructions to Copilot. For more details, visit https://code.visualstudio.com/docs/copilot/copilot-customization#_use-a-githubcopilotinstructionsmd-file -->

# CodeIgniter 3 CRUD with AJAX Project Instructions

This is a CodeIgniter 3 project demonstrating real-time CRUD operations using AJAX, jQuery, and DataTables.

## Project Structure

- **Framework**: CodeIgniter 3.1.13
- **Frontend**: jQuery, Bootstrap 5, DataTables
- **Database**: MySQL
- **Features**: Real-time updates, AJAX operations, Form validation

## Key Components

- **Model**: `User_model.php` - Handles database operations
- **Controller**: `Users.php` - Manages AJAX endpoints and business logic
- **View**: `users/index.php` - Single-page application interface
- **Database**: MySQL table `users` with auto-refresh functionality

## Development Guidelines

- Follow CodeIgniter 3 MVC pattern
- Use prepared statements for database security
- Implement proper form validation
- Return JSON responses for AJAX calls
- Use event delegation for dynamic elements
- Implement auto-refresh with smart pause system

## AJAX Endpoints

- `users/get_users_ajax` - Fetch all users
- `users/create_user_ajax` - Create new user
- `users/update_user_ajax` - Update existing user
- `users/delete_user_ajax` - Delete user

## Real-time Features

- Auto-refresh every 1 second
- Smart pause when user is active
- Real-time sync with database changes
- No page reload required for CRUD operations

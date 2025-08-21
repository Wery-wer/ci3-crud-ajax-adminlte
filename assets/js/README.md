# JavaScript & CSS Organization

## File Structure

```
assets/
├── css/
│   ├── dashboard.css           # Dashboard calendar styles
│   ├── profile.css             # Profile page styles
│   ├── user-management.css     # User management styles
│   └── user-registration.css   # User registration styles
└── js/
    ├── dashboard.js            # Dashboard functionality
    ├── profile.js              # Profile functionality
    ├── user-management.js      # User management functionality
    ├── user-registration.js    # User registration functionality
    └── README.md               # This documentation
```

## Description

All JavaScript and CSS code has been separated from view files into dedicated external files for better organization and maintainability.

## JavaScript Files Overview

### 1. `dashboard.js`

- **Purpose**: Handles dashboard functionality
- **Features**:
  - Real-time clock updates
  - Interactive calendar widget
  - System status checking
  - Calendar date selection and navigation
- **Dependencies**: jQuery, SweetAlert2
- **Used in**: `application/views/dashboard/index.php`

### 2. `profile.js`

- **Purpose**: Handles user profile functionality
- **Features**:
  - Profile form validation
  - AJAX profile updates
  - Password strength checking
  - Activity logging
  - Real-time activity timeline updates
- **Dependencies**: jQuery, SweetAlert2
- **Used in**: `application/views/profile/index.php`

### 3. `user-management.js`

- **Purpose**: Handles user management functionality
- **Features**:
  - DataTables initialization and management
  - User CRUD operations (Create, Read, Update, Delete)
  - Auto-refresh functionality with smart user activity detection
  - Modal handling and form submission
  - Real-time data loading and pagination
- **Dependencies**: jQuery, DataTables, SweetAlert2
- **Used in**: `application/views/users/index.php`

### 4. `user-registration.js`

- **Purpose**: Handles user registration and detailed management
- **Features**:
  - Complete DataTables integration
  - Dynamic job history management
  - Modal handling and form validation
  - Date picker integration
  - CRUD operations for users and job history
- **Dependencies**: jQuery, DataTables, Bootstrap Datepicker, SweetAlert2
- **Used in**: `application/views/user_registration/index.php`

## CSS Files Overview

### 1. `dashboard.css`

- **Purpose**: Styles for dashboard page
- **Features**:
  - Calendar widget styling
  - Responsive calendar design
  - Date selection and navigation styles
  - Mobile-responsive adjustments

### 2. `profile.css`

- **Purpose**: Styles for profile page
- **Features**:
  - Profile image and user info styling
  - Timeline and activity feed styles
  - Modal form enhancements
  - Badge and status indicators
  - Form validation feedback styles

### 3. `user-management.css`

- **Purpose**: Styles for user management page
- **Features**:
  - DataTables responsive styling
  - Alert container and notification styles
  - Button group and action styling
  - Loading overlay and refresh indicators

### 4. `user-registration.css`

- **Purpose**: Styles for user registration page
- **Features**:
  - DataTables and modal styling
  - Job history form styling
  - Form validation and feedback styles
  - Date picker customizations
  - Tab and badge enhancements
  - Animation and transition effects

## Benefits

1. **Separation of Concerns**: HTML/PHP views are now clean and focused on presentation
2. **Maintainability**: JavaScript and CSS code is centralized and easier to maintain
3. **Reusability**: Functions and styles can be reused across different views
4. **Performance**: Files can be cached by browsers
5. **Development**: Easier debugging and code organization
6. **Modularity**: Each module handles specific functionality
7. **Consistency**: Unified styling approach across all modules

## Implementation Pattern

Each view file now follows this clean pattern:

```php
<!-- Include Module Styles -->
<link rel="stylesheet" href="<?php echo base_url('assets/css/module.css'); ?>">

<!-- Include JavaScript Base URL -->
<script>
var BASE_URL = "<?php echo base_url(); ?>";
</script>

<!-- Include Module JavaScript -->
<script src="<?php echo base_url('assets/js/module.js'); ?>"></script>
```

## View Files Updated

1. **Dashboard** (`application/views/dashboard/index.php`):

   - ✅ Removed ~200 lines of JavaScript and CSS
   - ✅ Includes `dashboard.css` and `dashboard.js`

2. **Profile** (`application/views/profile/index.php`):

   - ✅ Removed ~40 lines of JavaScript
   - ✅ Includes `profile.css` and `profile.js`

3. **User Management** (`application/views/users/index.php`):

   - ✅ Removed ~300 lines of JavaScript and CSS
   - ✅ Includes `user-management.css` and `user-management.js`

4. **User Registration** (`application/views/user_registration/index.php`):
   - ✅ Previously removed ~600 lines of JavaScript
   - ✅ Removed ~30 lines of CSS
   - ✅ Includes `user-registration.css` and `user-registration.js`

## Requirements

Make sure the following libraries are loaded before the custom JavaScript files:

- jQuery
- Bootstrap 4
- DataTables (for user-management.js and user-registration.js)
- Bootstrap Datepicker (for user-registration.js)
- SweetAlert2

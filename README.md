# Clarianes Booking System - Comprehensive Functionality Documentation

## Table of Contents
1. [System Overview](#system-overview)
2. [User Management](#user-management)
3. [Authentication & Authorization](#authentication--authorization)
4. [Reservation Management](#reservation-management)
5. [Available Time Management](#available-time-management)
6. [Admin Panel](#admin-panel)
7. [Communication Features](#communication-features)
8. [Search & Filtering](#search--filtering)
9. [Technical Architecture](#technical-architecture)
10. [Database Schema](#database-schema)
11. [API Integration](#api-integration)
12. [Security Features](#security-features)

## System Overview

The Clarianes Booking System is a comprehensive web-based appointment scheduling platform built with Laravel 11. The system facilitates appointment booking between patients and healthcare providers, featuring a robust admin panel for managing schedules, reservations, and user accounts.

### Key Features
- **Multi-role User System**: Patients and Administrators
- **Real-time Appointment Booking**: Dynamic scheduling with availability management
- **SMS Notifications**: Automated communication via Twilio/PhilSMS integration
- **Admin Dashboard**: Comprehensive management interface
- **Responsive Design**: Modern UI built with Tailwind CSS
- **Search & Filtering**: Advanced appointment management tools

## User Management

### User Roles
- **Patient**: Can book appointments, view their reservations, and manage profile
- **Admin**: Full system access including user management, appointment oversight, and schedule management

### User Features
- **Registration**: Email-based registration with OTP verification
- **Profile Management**: Update personal information, phone numbers, and contact details
- **Phone Verification**: OTP-based phone number verification for SMS notifications
- **Account Security**: Password management and session handling

### User Data Fields
- Name, Email, Phone Number
- Guardian Name (for patient bookings)
- Role assignment (patient/admin)
- Email and phone verification status
- Account creation and update timestamps

## Authentication & Authorization

### Authentication System
- **Laravel Breeze**: Built-in authentication scaffolding
- **Session Management**: Secure session handling
- **Route Protection**: Middleware-based access control
- **OTP Verification**: Two-factor authentication for phone verification

### Authorization Levels
- **Public Routes**: Login, registration, contact, about pages
- **Authenticated Routes**: Dashboard, booking, profile management
- **Admin Routes**: Admin panel, user management, system configuration

### Security Features
- Password hashing and encryption
- CSRF protection
- Input validation and sanitization
- Role-based access control

## Reservation Management

### Appointment Booking Process
1. **User Authentication**: Login required for booking
2. **Phone Verification**: OTP verification mandatory for booking
3. **Date Selection**: Choose from available dates
4. **Time Slot Selection**: Pick from available time slots
5. **Patient Information**: Enter patient and guardian details
6. **Confirmation**: Review and confirm booking
7. **Notification**: SMS confirmation sent to user

### Reservation Status Management
- **Pending**: Newly created appointments awaiting admin approval
- **Accepted**: Confirmed appointments
- **Completed**: Finished appointments

### Reservation Features
- **Schedule Management**: Update appointment dates and times
- **Status Updates**: Change appointment status (pending/accepted/completed)
- **Cancellation**: Delete appointments with proper cleanup
- **Rescheduling**: Modify existing appointment details
- **Bulk Operations**: Admin can manage multiple appointments

### Reservation Data Fields
- Schedule Date
- Available Time Slot (start/end time)
- Patient Name
- Guardian Name
- Phone Number
- Optional Message
- Status (pending/accepted/completed)
- User association

## Available Time Management

### Time Slot Configuration
- **Flexible Scheduling**: Configurable start and end times
- **Daily Availability**: Set different schedules for different days
- **Exception Handling**: Mark specific dates as unavailable
- **Time Slot Management**: Create, edit, and delete time slots

### Availability Features
- **Date-based Availability**: Mark entire dates as unavailable
- **Time Slot Exceptions**: Make specific time slots unavailable for specific dates
- **Sunday Auto-blocking**: Automatic Sunday availability blocking
- **Dynamic Availability**: Real-time availability checking

### Admin Time Management
- **Add Time Slots**: Create new available time periods
- **Edit Time Slots**: Modify existing time slot schedules
- **Delete Time Slots**: Remove time slots from system
- **Availability Toggle**: Make time slots available/unavailable for specific dates

## Admin Panel

### Dashboard Overview
- **System Statistics**: Overview of appointments, users, and system status
- **Quick Actions**: Fast access to common admin tasks
- **Recent Activity**: Latest system activities and updates

### User Management
- **User List**: View all registered users
- **User Details**: Access comprehensive user information
- **Role Management**: Assign and modify user roles
- **Account Status**: Monitor user account status

### Appointment Management
- **All Appointments**: View complete appointment list
- **Pending Appointments**: Manage unconfirmed bookings
- **Completed Appointments**: Track finished appointments
- **Appointment Calendar**: Visual calendar interface
- **Walk-in Appointments**: Handle same-day bookings

### System Configuration
- **Available Times**: Manage time slot configurations
- **Unavailable Dates**: Set system-wide unavailable dates
- **Time Slot Exceptions**: Configure specific date/time exceptions

## Communication Features

### SMS Integration
- **PhilSMS API**: Integration with Philippine SMS service
- **Automated Notifications**: Booking confirmations and updates
- **Custom Messages**: Personalized SMS content
- **Delivery Tracking**: SMS delivery status monitoring

### Email System
- **Contact Form**: Website contact form with email notifications
- **System Notifications**: Automated email alerts
- **Template System**: Customizable email templates

### Notification Types
- **Booking Confirmations**: Appointment confirmation messages
- **Status Updates**: Appointment status change notifications
- **Reminders**: Appointment reminder messages
- **System Alerts**: Administrative notifications

## Search & Filtering

### Advanced Search
- **Appointment Search**: Search appointments by various criteria
- **User Search**: Find users by name, email, or phone
- **Date Range Filtering**: Filter appointments by date ranges
- **Status Filtering**: Filter by appointment status

### Search Features
- **Real-time Search**: Instant search results
- **Multiple Criteria**: Combine multiple search parameters
- **Export Capabilities**: Export search results
- **Pagination**: Handle large result sets

## Technical Architecture

### Framework & Technologies
- **Laravel 11**: PHP web application framework
- **MySQL/PostgreSQL**: Database management
- **Tailwind CSS**: Frontend styling framework
- **Alpine.js**: JavaScript framework for interactivity
- **Vite**: Frontend build tool

### Key Dependencies
- **Spatie Laravel Permission**: Role and permission management
- **Twilio SDK**: SMS service integration
- **Carbon**: Date and time manipulation
- **Guzzle HTTP**: API client for external services

### File Structure
```
app/
├── Http/Controllers/     # Application controllers
├── Models/              # Eloquent models
├── Services/            # Business logic services
├── Mail/                # Email templates and classes
└── Providers/           # Service providers

resources/
├── views/               # Blade templates
│   ├── admin/          # Admin panel views
│   ├── auth/           # Authentication views
│   ├── pages/          # Public pages
│   └── components/     # Reusable components
└── css/                # Stylesheets

routes/
├── web.php             # Web routes
├── auth.php            # Authentication routes
└── admin-auth.php      # Admin authentication routes
```

## Database Schema

### Core Tables

#### Users Table
- `id` (Primary Key)
- `name`, `email`, `password`
- `phone`, `phone_verified_at`
- `role_id` (Foreign Key to roles)
- `email_verified_at`
- `created_at`, `updated_at`

#### Roles Table
- `id` (Primary Key)
- `name` (patient/admin)
- `created_at`, `updated_at`

#### Reservations Table
- `id` (Primary Key)
- `schedule_date`
- `available_time_id` (Foreign Key)
- `patient_name`, `guardian_name`
- `phone_number`, `message`
- `start_time`, `end_time`
- `status` (pending/accepted/completed)
- `user_id` (Foreign Key)
- `created_at`, `updated_at`

#### Available Times Table
- `id` (Primary Key)
- `start_time`, `end_time`
- `created_at`, `updated_at`

#### Unavailable Time Slots Table
- `id` (Primary Key)
- `date`
- `available_time_id` (Foreign Key)
- `created_at`, `updated_at`

#### Unavailable Dates Table
- `id` (Primary Key)
- `date`
- `created_at`, `updated_at`

### Relationships
- Users belong to Roles
- Users have many Reservations
- Reservations belong to Available Times
- Available Times have many Unavailable Time Slots
- Available Times have many Reservations

## API Integration

### External Services
- **PhilSMS API**: SMS delivery service
- **Twilio SDK**: Alternative SMS service
- **HTTP Client**: RESTful API communication

### API Features
- **Authentication**: Bearer token authentication
- **Error Handling**: Comprehensive error management
- **Logging**: Detailed API interaction logs
- **Rate Limiting**: API usage monitoring

## Security Features

### Data Protection
- **Input Validation**: Comprehensive form validation
- **SQL Injection Prevention**: Eloquent ORM protection
- **XSS Protection**: Blade template escaping
- **CSRF Protection**: Cross-site request forgery prevention

### Access Control
- **Middleware Protection**: Route-level security
- **Role-based Access**: User role verification
- **Session Security**: Secure session management
- **Password Security**: Bcrypt hashing

### System Security
- **Environment Configuration**: Secure configuration management
- **Error Handling**: Secure error reporting
- **Logging**: Comprehensive security logging
- **Backup Protection**: Data backup and recovery

## Installation & Setup

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js and NPM
- MySQL/PostgreSQL database
- Web server (Apache/Nginx)

### Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure database settings
# Configure SMS API credentials
# Configure mail settings
```

### Installation Steps
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install

# Run database migrations
php artisan migrate

# Seed database (if applicable)
php artisan db:seed

# Build frontend assets
npm run build

# Start development server
php artisan serve
```

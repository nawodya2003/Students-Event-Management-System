\# Student Event Management System

A dynamic web application for managing university events, built with PHP, MySQL, HTML, CSS, and JavaScript.

\## Features



\### For Students:

\- User registration and authentication

\- Browse upcoming events

\- Register for events

\- View event details



\### For Administrators:

\- Admin dashboard with statistics

\- Create, edit, and delete events

\- View registered participants

\- Manage event capacity



\## Technologies Used

\- \*\*Front-end\*\*: HTML5, CSS3, JavaScript, Bootstrap 5

\- \*\*Back-end\*\*: PHP 7.4+

\- \*\*Database\*\*: MySQL 5.7+

\- \*\*Server\*\*: Apache (XAMPP)



\## Installation Guide

\### Prerequisites:

\- XAMPP (or similar: WAMP, MAMP, LAMP)

\- Web browser (Chrome, Firefox, etc.)

\- Text editor (VS Code recommended)



\### Setup Steps:

1\. \*\*Install XAMPP\*\*

&nbsp;  - Download from: https://www.apachefriends.org

&nbsp;  - Install and start Apache \& MySQL services


2\. \*\*Download Project\*\*

\- # Place project in XAMPP htdocs folder

\- C:/xampp/htdocs/student-events/

```



3\. \*\*Create Database\*\*

\-- Open phpMyAdmin: http://localhost/phpmyadmin

\-- Create new database: `student\_event\_management`

\-- Import `db\_structure.sql` file



4\. \*\*Configure Database Connection\*\*

\-- Open `includes/config.php`

\-- Update database credentials if needed:



5\. \*\*Access Application\*\*

\-- Open browser and navigate to: http://localhost/student-events/index.php



\## Default Login Credentials



\*\*Admin Account:\*\*

\- Email: admin@university.edu

\- Password: admin123



\*\*Test Student Account:\*\*

\- Register a new account through the registration page



\## Project Structure

student-events/

├── admin/              # Admin panel pages

├── includes/           # Configuration and reusable components

├── css/               # Stylesheets

├── js/                # JavaScript files

├── images/            # Image assets

├── db\_structure.sql   # Database schema

└── README.md          # This file




\## Database Schema



\### Tables:

1\. \*\*users\*\* - Store user information (students and admins)

2\. \*\*events\*\* - Store event details

3\. \*\*registrations\*\* - Store event registrations (junction table)



\### Relationships:

\- users (1) → (M) events (created\_by)

\- users (M) → (M) events (through registrations)



\## Security Features



\- Password hashing using PHP's password\_hash()

\- Prepared statements (PDO) to prevent SQL injection

\- Input sanitization

\- Session-based authentication

\- Role-based access control (student/admin)



\## Key Functionalities



1\. \*\*User Authentication\*\*

\-- Secure registration with password hashing

\-- Login/logout system

\-- Session management



2\. \*\*Event Management\*\*

\-- CRUD operations (Create, Read, Update, Delete)

\-- Event capacity management

\-- Date and time tracking



3\. \*\*Registration System\*\*

\-- Duplicate registration prevention

\-- Capacity checking

\-- Registration tracking



4\. \*\*Admin Dashboard\*\*

\--- Statistics overview

\--- Event management

\--- Participant viewing



\## Future Enhancements (Optional)



\- Email notifications

\- Event search and filtering

\- AJAX for dynamic content loading

\- Analytics dashboard

\- QR code for event check-in

\- Export participant lists to CSV



\## Troubleshooting



\### Common Issues:



\*\*Database Connection Error:\*\*

\- Check if MySQL is running in XAMPP

\- Verify database credentials in config.php

\- Ensure database exists



\*\*Page Not Loading:\*\*

\- Check if Apache is running

\- Verify correct URL: http://localhost/student-events

\- Check file permissions



\*\*Login Not Working:\*\*

\- Clear browser cookies/cache

\- Check if sessions are enabled in PHP

\- Verify user exists in database



\## Support



For issues or questions:

\- Check PHP error log: C:/xampp/apache/logs/error.log

\- Enable error display: Add `error\_reporting(E\_ALL);` to config.php



\## License



This project is developed for educational purposes.



\## Author



\# J.A.N.Rashmina

\# 23IT0522

\# Student Event Management System


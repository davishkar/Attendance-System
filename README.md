# Harimandir Attendance System 

A simple PHP and MySQL attendance system for managing branch-wise daily attendance, viewing reports, and exporting records as CSV.

## Features

- Branch selection and login
- Session-protected attendance page
- Daily attendance marking
- Present/absent tracking per student
- Bandhu, Bhagini, total, and Prasad fields
- Daily report view
- CSV export
- Shared config, auth, header, and footer files

## Project Structure

```text
Attendance-System/
├── config/
│   ├── app.php
│   ├── auth.php
│   └── database.php
├── includes/
│   ├── header.php
│   └── footer.php
├── attendance.php
├── save_attendance.php
├── reports.php
├── export_attendance.php
├── login.php
├── logout.php
├── upasthiti.php
├── index.php
├── style.css
├── script.js
└── database_schema.sql
```

## Requirements

- PHP 8.0 or newer
- MySQL or MariaDB
- Web server such as Apache, Nginx, or XAMPP/WAMP/Laragon

## Database Setup

1. Create a database named `branch1`.
2. Import [database_schema.sql](database_schema.sql) into that database.
3. Add student records to the `students` table.

Example:

```sql
INSERT INTO students (name) VALUES
('Student 1'),
('Student 2'),
('Student 3');
```

The `attendance` table has a unique key on `(student_id, date)`, so saving attendance for the same student and date updates the existing record instead of creating duplicates.

## Branch And Login Setup

Branch settings are stored in [config/app.php](config/app.php).

Default branch:

```php
1 => [
    'name' => 'Branch 1',
    'database' => 'branch1',
    'username' => 'v',
    'password' => 'o',
],
```

To add another branch, add another entry:

```php
2 => [
    'name' => 'Branch 2',
    'database' => 'branch2',
    'username' => 'branch2user',
    'password' => 'branch2pass',
],
```

For production, replace plain passwords with `password_hash()` values and use the `password_hash` key.

## How To Use

1. Open `index.php`.
2. Go to branch selection.
3. Select a branch and log in.
4. Mark attendance in `attendance.php`.
5. View reports in `reports.php`.
6. Export CSV from the report page.

## Important Files

- [attendance.php](attendance.php): Main attendance marking page.
- [save_attendance.php](save_attendance.php): Handles attendance save requests.
- [reports.php](reports.php): Shows attendance records for a selected date.
- [export_attendance.php](export_attendance.php): Downloads attendance as CSV.
- [config/auth.php](config/auth.php): Session and login helper functions.
- [config/database.php](config/database.php): Branch database connection helper.

## Notes

- The app currently uses one database per branch.
- Old pages `test.php`, `new.php`, and `view_attendance.php` redirect to the new consolidated pages.
- Ensure PHP is available on your server. The local machine used during cleanup did not have `php` available on PATH, so PHP syntax checks could not be run there.

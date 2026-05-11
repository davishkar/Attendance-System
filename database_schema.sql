CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NULL,
    active TINYINT(1) NOT NULL DEFAULT 1
);

CREATE TABLE IF NOT EXISTS attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    date DATE NOT NULL,
    status ENUM('present', 'absent') NOT NULL,
    bandhu INT NOT NULL DEFAULT 0,
    bhagini INT NOT NULL DEFAULT 0,
    total INT NOT NULL DEFAULT 0,
    prasad VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_student_date (student_id, date),
    CONSTRAINT fk_attendance_student
        FOREIGN KEY (student_id) REFERENCES students(id)
        ON DELETE CASCADE
);


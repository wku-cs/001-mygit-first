CREATE DATABASE IF NOT EXISTS student_counseling;
USE student_counseling;

CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(10) NOT NULL UNIQUE,
    name VARCHAR(50) NOT NULL,
    department VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS counseling_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    category ENUM('학사관리', '학교생활', '진로관리', '기타') NOT NULL,
    content TEXT NOT NULL,
    counselor_notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id)
); 
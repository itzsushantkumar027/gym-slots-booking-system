-- Create database
CREATE DATABASE IF NOT EXISTS gym_booking_system;
USE gym_booking_system;

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create trainers table
CREATE TABLE IF NOT EXISTS trainers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    age INT,
    gender ENUM('Male', 'Female', 'Other'),
    image VARCHAR(500),
    price DECIMAL(10,2),
    specialization TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create time_slots table
CREATE TABLE IF NOT EXISTS time_slots (
    id INT AUTO_INCREMENT PRIMARY KEY,
    trainer_id INT,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    is_booked BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (trainer_id) REFERENCES trainers(id) ON DELETE CASCADE
);

-- Create bookings table
CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    trainer_id INT NOT NULL,
    user_email VARCHAR(255) NOT NULL,
    booking_date DATE NOT NULL,
    booking_slot VARCHAR(100) NOT NULL,
    status ENUM('confirmed', 'pending', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (trainer_id) REFERENCES trainers(id) ON DELETE CASCADE
);

-- Insert sample trainers
INSERT INTO trainers (name, age, gender, image, price, specialization) VALUES
('Sarah Johnson', 28, 'Female', 'trainer-1.jpg', 50.00, 'Cardio, Yoga, Pilates'),
('Mike Wilson', 32, 'Male', 'trainer-2.jpg', 60.00, 'Strength Training, Bodybuilding'),
('Emma Davis', 26, 'Female', 'trainer-3.jpg', 45.00, 'Yoga, Meditation, Flexibility'),
('David Brown', 35, 'Male', 'trainer-4.jpg', 70.00, 'CrossFit, HIIT, Functional Training'),
('Lisa Chen', 29, 'Female', 'trainer-5.jpg', 55.00, 'Dance, Zumba, Aerobics');

-- Insert sample time slots for each trainer
INSERT INTO time_slots (trainer_id, start_time, end_time) VALUES
(1, '06:00:00', '08:00:00'),
(1, '08:00:00', '10:00:00'),
(1, '16:00:00', '18:00:00'),
(1, '18:00:00', '20:00:00'),
(2, '06:00:00', '08:00:00'),
(2, '08:00:00', '10:00:00'),
(2, '16:00:00', '18:00:00'),
(2, '18:00:00', '20:00:00'),
(3, '06:00:00', '08:00:00'),
(3, '08:00:00', '10:00:00'),
(3, '16:00:00', '18:00:00'),
(3, '18:00:00', '20:00:00'),
(4, '06:00:00', '08:00:00'),
(4, '08:00:00', '10:00:00'),
(4, '16:00:00', '18:00:00'),
(4, '18:00:00', '20:00:00'),
(5, '06:00:00', '08:00:00'),
(5, '08:00:00', '10:00:00'),
(5, '16:00:00', '18:00:00'),
(5, '18:00:00', '20:00:00'); 
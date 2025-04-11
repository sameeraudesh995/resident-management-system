-- Database creation
CREATE DATABASE IF NOT EXISTS resident_database;
USE resident_database;

-- Table creation
CREATE TABLE IF NOT EXISTS residents (
                                         id INT AUTO_INCREMENT PRIMARY KEY,
                                         full_name VARCHAR(100) NOT NULL,
    dob DATE NOT NULL,
    nic VARCHAR(12) UNIQUE NOT NULL,
    address TEXT NOT NULL,
    phone VARCHAR(15) NOT NULL,
    email VARCHAR(100) NOT NULL,
    occupation VARCHAR(50) NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    registered_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

-- Sample data insertion
INSERT INTO residents (full_name, dob, nic, address, phone, email, occupation, gender) VALUES
                                                                                           ('John Smith', '1985-05-15', '851234567V', '123 Main Street, Colombo', '0771234567', 'john.smith@email.com', 'Engineer', 'Male'),
                                                                                           ('Mary Johnson', '1990-08-22', '902345678V', '45 Oak Avenue, Kandy', '0712345678', 'mary.j@email.com', 'Teacher', 'Female'),
                                                                                           ('David Wilson', '1978-11-30', '783456789V', '78 Pine Road, Galle', '0723456789', 'david.w@email.com', 'Doctor', 'Male'),
                                                                                           ('Sarah Brown', '1982-03-10', '824567890V', '56 Maple Lane, Negombo', '0764567890', 'sarah.b@email.com', 'Accountant', 'Female'),
                                                                                           ('Robert Lee', '1995-07-18', '956789012V', '89 Cedar Street, Jaffna', '0756789012', 'robert.l@email.com', 'Student', 'Male'),
                                                                                           ('Emma Davis', '1988-09-25', '886789123V', '23 Birch Avenue, Matara', '0787890123', 'emma.d@email.com', 'Nurse', 'Female'),
                                                                                           ('Michael Taylor', '1975-12-05', '759012345V', '34 Elm Road, Anuradhapura', '0778901234', 'michael.t@email.com', 'Business Owner', 'Male'),
                                                                                           ('Olivia Martin', '1992-04-12', '923456789V', '67 Willow Lane, Ratnapura', '0713456789', 'olivia.m@email.com', 'Designer', 'Female'),
                                                                                           ('James Anderson', '1980-06-20', '806789123V', '12 Palm Street, Kurunegala', '0726789012', 'james.a@email.com', 'Farmer', 'Male'),
                                                                                           ('Sophia White', '1998-01-15', '981234567V', '90 Rose Avenue, Badulla', '0761234567', 'sophia.w@email.com', 'Student', 'Female');
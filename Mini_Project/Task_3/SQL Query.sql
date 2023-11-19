CREATE DATABASE restful;
USE restful;


CREATE TABLE horizonstudents (
  Index_No VARCHAR(10) PRIMARY KEY,
  First_Name VARCHAR(20),
  Last_Name VARCHAR(20),
  City VARCHAR(20),
  District VARCHAR(20),
  Province VARCHAR(30),
  Email_Address VARCHAR(30),
  Mobile_Number INT(15)
);


INSERT INTO horizonstudents (Index_No, First_Name, Last_Name, City, District, Province, Email_Address, Mobile_Number) VALUES
('S0001', 'Kumar', 'Sangakara', 'Hagkala', 'Nuwara Eliya','Central Province', 'kumar@gmail.com', '0775458655'),
('S0002', 'Tharindu', 'Gunathilaka', 'Moratuwa', 'Colombo', 'Western Province','tharindu@gmail.com', '0762541877'),
('S0003', 'Fernando', 'Rajapaksha', 'Dehiwala', 'Colombo', 'Western Province', 'fernando@gmail.com', '0715489633'),
('S0004', 'John', 'peter', 'Kalmunai', 'Ampara', 'Eastern Province','john@gmail.com', '0725961254'),
('S0005', 'Kasuni', 'jeyarathna', 'Balangoda', 'ratnapura', 'Uva Province', 'kasuni@gmail.com', '0713236598')
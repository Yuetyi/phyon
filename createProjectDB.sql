-- phpMyAdmin SQL Dump

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- DROP existing database
DROP DATABASE IF EXISTS `ProjectDB`;

--
-- Database: `ProjectDB`
--
CREATE DATABASE IF NOT EXISTS ProjectDB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE projectDB;

DROP TABLE IF EXISTS Dealer;

--
-- Table structure for table `Dealer`
--
CREATE TABLE Dealer (
    dealerID VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL,
    dealerName VARCHAR(100) NOT NULL,
    contactName VARCHAR(100) NOT NULL,
    contactNumber INT(30) NOT NULL,
    faxNumber INT(30),
    deliveryAddress VARCHAR(255) NOT NULL,
    PRIMARY KEY (dealerID)
);

--
-- Dumping data for table `Dealer`
--
INSERT INTO Dealer (dealerID, password, dealerName, contactName, contactNumber, faxNumber, deliveryAddress) VALUES 
('alex@auto-racing.com', 'itp4235m', 'Auto Racing', 'Alex Wong', 21232123, 22223333, 'G/F, ABC Building, King Yip Street, KwunTong, Kowloon, Hong Kong'),
('tina@good-service.com', 'itp4235m', 'Good Service', 'Tina Chan', 31233123, 33334444, '303, Mei Hing Center, Yuen Long, NT, Hong Kong'),
('bowie＠car-care.com', 'itp4235m', 'Car Care', 'Bowie', 61236123, 31112222, '401, Sing Kei Building, Kowloon, Hong Kong');

DROP TABLE IF EXISTS SalesManager;

--
-- Table structure for table `SalesManager`
--
CREATE TABLE SalesManager (
    salesManagerID VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL,
    managerName VARCHAR(100) NOT NULL,
    contactName VARCHAR(100) NOT NULL,
    contactNumber INT(30) NOT NULL,
    PRIMARY KEY (salesManagerID)
);

--
-- Dumping data for table `SalesManager`
--
INSERT INTO SalesManager (salesManagerID, password, managerName, contactName, contactNumber) VALUES 
('peter@slms.com', 'itp4235m', 'Chan Tai Man, Peter', 'Peter', 91239123),
('mary@slms.com', 'itp4235m', 'Wong Lai Man, Mary', 'Mary', 51235123),
('kit@slms.com', 'itp4235m', 'Li Chun Kit, Kit', 'Kit', 31233123);

DROP TABLE IF EXISTS Item;

--
-- Table structure for table `Item`
--
CREATE TABLE Item (
    sparePartNum INT(10) NOT NULL,
    sparePartCategory INT(1) NOT NULL,
    sparePartName VARCHAR(255) NOT NULL,
    sparePartImage VARCHAR(100) NOT NULL,
    sparePartDescription VARCHAR(255),
    weight DOUBLE NOT NULL,
    stockItemQty INT(10) NOT NULL,
    price DOUBLE NOT NULL,
    PRIMARY KEY (sparePartNum)
);

--
-- Dumping data for table `Item`
--
INSERT INTO Item (sparePartNum, sparePartCategory, sparePartName, sparePartImage, sparePartDescription, weight, stockItemQty, price) VALUES 
(1, 1, 'Vehicle Firewall (Lower Front Section)', '100001.jpg', 'This robust barrier is constructed from high-grade, heat-resistant materials that prevent engine heat, noise, and potential hazards from reaching the interior of the vehicle. ', 70, 3, 5000),
(2, 1, 'Front Left Door (Unpainted) (Outside)', '100002.jpg', 'Front left door replacement for various vehicle models.Crafted from high-quality, durable materials, this door is designed to provide the structural integrity and fit of an OEM part.', 30, 0, 3500),
(3, 2, 'AC Compressor Bump', '200001.jpg', 'Our Complete Cooling System Kit is your one-stop solution for overhauling your vehicles cooling system. This comprehensive kit includes everything from the radiator to the thermostat, ensuring your engine stays cool under any driving conditions. ', 30, 3, 6000),
(4, 2, 'Engine Rebuild Kit', '200002.jpg', 'This kit is meticulously assembled to support a complete overhaul of your vehicles power plant, ensuring that it runs as smoothly and efficiently as the day you first turned the key. ', 100, 0, 10000),
(5, 3, 'Headlight Bulb Replacement', '300001.jpg', 'Illuminate the road ahead with superior brightness by upgrading to our Premium Headlight Bulbs. Engineered for maximum visibility and clarity.', 1, 3, 500),
(6, 3, 'Ultra-Bright Vertical Truck Rear Lamp', '300002.jpg', 'Elevate the safety and style of your truck with our Ultra-Bright Vertical Truck Rear Lamp Assembly. Designed to fit a variety of commercial trucks, trailers, and heavy-duty vehicles.', 10, 0, 1000),
(7, 4, 'Tire Pressure Monitoring System (TPMS)', '400001.jpg', 'Designed to provide real-time tire pressure information, these sensors help you maintain proper tire inflation.', 50, 3, 1000),
(8, 4, '12V Single USB Car Charger', '400002.jpg', 'Keep your devices powered up while on the move with the CompactDrive 12V Single USB Car Charger. ', 10, 0, 100),
(9, 1, 'Front Left Door (Inside)', '100003.jpg', 'The inner door panel is a critical component that covers the interior part of the door and houses various functional elements like the handle, controls for windows and locks.', 10, 10, 3000),
(10, 1, 'Engine Hood Cover Replacement', '100004.jpg', 'Replace your worn or damaged engine hood cover with our Premium Engine Hood Cover Replacement. ', 30, 10, 4000),
(11, 1, 'Trunk Door Panel', '100005.jpg', 'Our custom trunk door panel replacement is designed to fit the specific contours and style of your vehicles trunk door.', 30, 10, 4000);

DROP TABLE IF EXISTS Orders;

--
-- Table structure for table `Orders`
--
/*
Change of data type from TIMESTAMP to DATETIME because :
TIMESTAMP : supported range is '1970-01-01 00:00:01' UTC to '2038-01-19 03:14:07' UTC.
DATETIME : supported range is '1000-01-01 00:00:00' to '9999-12-31 23:59:59'.
Problem : If you store a TIMESTAMP value, and then change the time zone and retrieve the value, the retrieved value is different from the value you stored.
*/
CREATE TABLE Orders (
    orderID INT(10) NOT NULL,
    dealerID VARCHAR(50) NOT NULL,
    salesManagerID VARCHAR(50) NOT NULL,
    orderDateTime DATETIME NOT NULL,
    deliveryAddress VARCHAR(255) NOT NULL,
    deliveryDate DATE NOT NULL,
    orderStatus VARCHAR(50) NOT NULL,
    shipCost INT(5) NOT NULL,
    PRIMARY KEY (orderID)
);

--
-- Indexes for table `Orders`
--
-- Foreign key naming convention : fk_<table name>_<column name>_<foreign table name>
ALTER TABLE Orders 
    ADD CONSTRAINT fk_Orders_dealerID_Dealer FOREIGN KEY (dealerID) REFERENCES Dealer (dealerID),
    ADD CONSTRAINT fk_Orders_salesManagerID_Dealer FOREIGN KEY (salesManagerID) REFERENCES SalesManager (salesManagerID);

--
-- Dumping data for table `Orders`
--
INSERT INTO Orders (orderID, dealerID, salesManagerID, orderDateTime, deliveryAddress, deliveryDate, orderStatus, shipCost) VALUES 
(1, 'alex@auto-racing.com', 'peter@slms.com', '2024-03-31 17:50:00', 'G/F, ABC Building, King Yip Street, KwunTong, Kowloon, Hong Kong', '2024-04-05', 'Shipped', 3750),
(2, 'alex@auto-racing.com', 'mary@slms.com', '2024-04-01 12:01:00', 'G/F, ABC Building, King Yip Street, KwunTong, Kowloon, Hong Kong', '2024-04-10', 'Processing', 480),
(3, 'tina@good-service.com', 'kit@slms.com', '2024-04-22 09:37:00', '303, Mei Hing Center, Yuen Long, NT, Hong Kong', '2024-04-29', 'Cancelled', 780);

DROP TABLE IF EXISTS OrdersItem;

--
-- Table structure for table `OrdersItem`
--
CREATE TABLE OrdersItem (
    orderID INT(10) NOT NULL,
    sparePartNum INT(10) NOT NULL,
    orderQty INT(10) NOT NULL,
    sparePartOrderPrice DOUBLE NOT NULL,
    PRIMARY KEY (orderID , sparePartNum)
);

--
-- Indexes for table `OrdersItem`
--
-- Foreign key naming convention : fk_<table name>_<column name>_<foreign table name>
ALTER TABLE OrdersItem 
    ADD CONSTRAINT fk_OrdersItem_sparePartNum_Item FOREIGN KEY (sparePartNum) REFERENCES Item (sparePartNum),
    ADD CONSTRAINT fk_OrdersItem_orderID_Item FOREIGN KEY (orderID) REFERENCES Orders (orderID);

INSERT INTO OrdersItem (orderID, sparePartNum, orderQty, sparePartOrderPrice) VALUES 
(1, 1, 1, 3999),
(2, 2, 2, 3500),
(2, 3, 2, 6000),
(3, 4, 3, 10000),
(3, 5, 3, 500),
(3, 6, 3, 1000);

COMMIT;
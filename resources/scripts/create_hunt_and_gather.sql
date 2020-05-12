-- create the Hunt and Gather Database for AppsDev

DROP DATABASE IF EXISTS HuntAndGather;
CREATE DATABASE HuntAndGather;
USE HuntAndGather;  

CREATE TABLE `endUser` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `endUser_role_id` int NOT NULL,
  `email` varChar(100) NOT NULL,
  `pw` varChar(100) NOT NULL,
  `city` varChar(25) NOT NULL,
  `state` varChar(2) NOT NULL,
  `zip` varChar(5) NOT NULL,
  `registration_date` datetime NOT NULL DEFAULT (now())
);

CREATE TABLE `restaurant` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT, 
  `name` varChar(100) NOT NULL,
  `city` varChar(50) NOT NULL,
  `state` varChar(2) NOT NULL,
  `zip` varChar(5) NOT NULL,
  `contact_person_first` varChar(100),
  `contact_person_last` varChar(100),
  `phone` int(10),
  `is_registered` bit NOT NULL,
  `registration_date` datetime
);

CREATE TABLE `review` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `endUser_id` int(11) NOT NULL,
  `restaurant_id` int(11),
  `meal_id` int(11),
  `comment` varchar(300),
  `rating` int(11),
  `date_added` datetime NOT NULL DEFAULT (now())
);

CREATE TABLE `endUserType` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `description` varChar(100)
);

CREATE TABLE `meal` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `name` varChar(100) NOT NULL,
  `restaurant_id` int(11),
  `is_official` bit NOT NULL,
  `date_added` datetime NOT NULL DEFAULT (now())
);

CREATE TABLE `mealRestaurant` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `meal_id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL
);

CREATE TABLE `allergenMeal` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `allergen_id` int(11) NOT NULL,
  `meal_id` int(11) NOT NULL
);

CREATE TABLE `allergenNotInMeal` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `allergen_id` int(11) NOT NULL,
  `meal_id` int(11) NOT NULL
);



CREATE TABLE `endUserAllergen` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `endUser_id` int(11) NOT NULL,
  `allergen_id` int(11) NOT NULL
);

CREATE TABLE `allergen` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `name` varChar(100) NOT NULL
);

ALTER TABLE `endUserAllergen` ADD FOREIGN KEY (`endUser_id`) REFERENCES `endUser` (`id`);

ALTER TABLE `mealRestaurant` ADD FOREIGN KEY (`restaurant_id`) REFERENCES `restaurant` (`id`);

ALTER TABLE `meal` ADD FOREIGN KEY (`restaurant_id`) REFERENCES `restaurant` (`id`);

ALTER TABLE `mealRestaurant` ADD FOREIGN KEY (`meal_id`) REFERENCES `meal` (`id`);

ALTER TABLE `allergenMeal` ADD FOREIGN KEY (`allergen_id`) REFERENCES `allergen` (`id`);

ALTER TABLE `allergenMeal` ADD FOREIGN KEY (`meal_id`) REFERENCES `meal` (`id`);

ALTER TABLE `allergenNotInMeal` ADD FOREIGN KEY (`allergen_id`) REFERENCES `allergen` (`id`);

ALTER TABLE `allergenNotInMeal` ADD FOREIGN KEY (`meal_id`) REFERENCES `meal` (`id`);

ALTER TABLE `endUserAllergen` ADD FOREIGN KEY (`allergen_id`) REFERENCES `allergen` (`id`);

ALTER TABLE `review` ADD FOREIGN KEY (`endUser_id`) REFERENCES `endUser` (`id`);

ALTER TABLE `review` ADD FOREIGN KEY (`endUser_id`) REFERENCES `restaurant` (`id`);

ALTER TABLE `review` ADD FOREIGN KEY (`endUser_id`) REFERENCES `meal` (`id`);

ALTER TABLE `endUser` ADD FOREIGN KEY (`endUser_role_id`) REFERENCES `endUserType` (`id`);

-- insert data into the database

INSERT INTO endUserType VALUES
(1, 'Member'),
(2, 'Administrator');

insert into endUser VALUES
(1,2, 'admin@st.com', 'pass', 'Detroit', 'MI', '48127', NOW()),
(2,1, 'aa@st.com', 'pass', 'Duluth', 'MN', '55805', NOW()),
(3,1, 'bb@st.com', 'pass', 'Milwaukee', 'WI', '53201', NOW()),
(4,1, 'cc@st.com', 'pass', 'Fort Walton Beach', 'FL', '32547', NOW()),
(5,1, 'dd@st.com', 'pass', 'St. Paul', 'MN', '55101', NOW());

insert into restaurant VALUES
(1,'Dunkin Donuts', 'Duluth', 'MN', '55810', null, null, null, 0, NOW()),
(2,'Pizza Luce', 'Duluth', 'MN', '55802', null, null, null, 0, NOW()),
(3,"McDonald's", 'Superior', 'WI', '54880', '', '', null, 0, NOW()),
(4,'Test Restaurant', 'TestCity', 'WI', '11111', "Nancy", "Kerrigan", "1112223344", 0, NOW());

insert into meal VALUES
-- (1,'Dunkin Burrito Bowl', 1, 1, NOW()),
(1,'Dunkin has Egg, Soy, Milk; No beef', 1, 1, NOW()),
-- (2,'Test Meal', 1, 1, NOW()),
(2,'Luce has Chicken; No Egg', 2, 1, NOW()),
-- (3,'WholegrainSausage McMuffin with Egg', 3, 1, NOW()),
(3,'Mcdonalds has Egg, Soy, Milk, Wheat, Pork', 3, 1, NOW()),
-- (4,'Meal with all Allergens', 4, 1, NOW()),
(4,'Meal with all Allergens', 4, 1, NOW()),
-- (5,'Meal with no Allergens', 4, 1, NOW()),
(5,'Meal with no Allergens', 4, 1, NOW()),
-- (6,'Unofficial Meal', 1, 0, NOW());
(6,'Dunkin Unofficial Meal No Allergens', 1, 0, NOW());

insert into review VALUES
(1, 1, 1, 1, 'this place does not have anything gluten free', 2, NOW()),
(2, 1, 2, 2, 'lots of vegan and gf options!', 5, NOW()),
(3, 1, 4, 4, 'lots of allergens', 5, NOW()),
(4, 2, 4, 5, 'everything allergen free', 1, NOW());

insert into allergen VALUES
(1, 'Dairy'),
(2, 'Egg'),
(3, 'Peanut'),
(4, 'Tree nut'),
(5, 'Shellfish'),
(6, 'Beef'),
(7, 'Lactose'),
(8, 'Soy'),
(9, 'Corn'),
(10, 'Wheat'),
(11, 'Gluten'),
(12, 'Fish'),
(13, 'Gelatin'),
(14, 'Sesame'),
(15, 'Caraway'),
(16, 'Coriander'),
(17, 'Mustard'),
(18, 'Garlic'),
(19, 'Sunflower'),
(20, 'Poppy'),
(21, 'Pork'),
(22, 'Chicken'),
(23, 'MSG'),
(24, 'Sulphite'),
(25, 'Oat'),
(26, 'Yeast'),
(27, 'Rice'),
(28, 'Balsam of Peru'),
(29, 'Milk'),
(30, 'test');

insert into allergenMeal VALUES
(1, 2, 3),
(2, 29, 3),
(3, 8, 3),
(4, 10, 3),
(5, 2, 1),
(6, 29, 1),
(7, 21, 3),
(8, 1, 4),
(9, 2, 4),
(10, 3, 4),
(11, 4, 4),
(12, 5, 4),
(13, 6, 4),
(14, 7, 4),
(15, 8, 4),
(16, 9, 4),
(17, 10, 4),
(18, 11, 4),
(19, 12, 4),
(20, 13, 4),
(21, 14, 4),
(22, 15, 4),
(23, 16, 4),
(24, 17, 4),
(25, 18, 4),
(26, 19, 4),
(27, 20, 4),
(28, 21, 4),
(29, 22, 4),
(30, 23, 4), 
(31, 24, 4), 
(32, 25, 4), 
(33, 26, 4), 
(34, 27, 4), 
(35, 28, 4), 
(36, 29, 4), 
(37, 8, 1),
(38, 22, 2);

insert into allergenNotInMeal VALUES
(1, 6, 1),
(2, 2, 2);

insert into endUserAllergen VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 7);

insert into mealRestaurant VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4),
(5, 5, 4),
(6, 6, 1);



-- create the endUsers and grant privileges to those endUsers
-- GRANT SELECT, INSERT, DELETE, UPDATE
-- ON HuntAndGather.*
-- TO mgs_User@localhost
-- IDENTIFIED BY 'pa55word';

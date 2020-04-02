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
  `zip` varChar(5),
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
  `registration_date` timestamp
);

CREATE TABLE `endUserType` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `description` varChar(100)
);

CREATE TABLE `meal` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `name` varChar(100) NOT NULL,
  `restaurant_id` int(11),
  `is_official` bit NOT NULL
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
(1,2, 'admin@st.com', 'pass', 'Detroit', 'MI', 48127, NOW()),
(2,1, 'aa@st.com', 'pass', 'Duluth', 'MN', 55805, NOW()),
(3,1, 'bb@st.com', 'pass', 'Milwaukee', 'WI', 53201, NOW()),
(4,1, 'cc@st.com', 'pass', 'Fort Walton Beach', 'FL', 32547, NOW()),
(5,1, 'dd@st.com', 'pass', 'St. Paul', 'MN', 55101, NOW());

insert into restaurant VALUES
(1,'Dunkin Donuts', 'Duluth', 'MN', 55810, null, null, null, '0', NOW()),
(2,'Pizza Luce', 'Duluth', 'MN', 55802, null, null, null, '0', NOW()),
(3,"McDonald's", 'Superior', 'WI', 54880, '', '', null, '0', NOW()),
(4,'Test Restaurant', 'TestCity', 'WI', null, "Nancy", "Kerrigan", "1112223344", '0', NOW());

insert into meal VALUES
(1,'Dunkin Burrito Bowl', 1, 1),
(2,'Test Meal', 1, 1),
(3,'WholegrainSausage McMuffin with Egg', 3, 1),
(4,'Meal with all allergens', 4, 1),
(5,'Meal with no allergens', 4, 1),
(6,'Unofficial meal', 1, 0);

insert into review VALUES
(1, 1, 1, 1, 'this place does not have anything gluten free', 2, NOW()),
(2, 1, 2, 2, 'lots of vegan and gf options!', 5, NOW()),
(3, 1, 4, 4, 'lots of allergens', 5, NOW()),
(4, 2, 4, 5, 'everything allergen free', 1, NOW());

insert into allergen VALUES
(1, 'dairy'),
(2, 'egg'),
(3, 'peanut'),
(4, 'tree nut'),
(5, 'shellfish'),
(6, 'beef'),
(7, 'lactose'),
(8, 'soy'),
(9, 'corn'),
(10, 'wheat'),
(11, 'gluten'),
(12, 'fish'),
(13, 'gelatin'),
(14, 'sesame'),
(15, 'caraway'),
(16, 'coriander'),
(17, 'mustard'),
(18, 'garlic'),
(19, 'sunflower'),
(20, 'poppy'),
(21, 'pork'),
(22, 'chicken'),
(23, 'msg'),
(24, 'sulphite'),
(25, 'oat'),
(26, 'yeast'),
(27, 'rice'),
(28, 'balsamOfPeru'),
(29, 'milk');





-- create the endUsers and grant privileges to those endUsers
-- GRANT SELECT, INSERT, DELETE, UPDATE
-- ON HuntAndGather.*
-- TO mgs_User@localhost
-- IDENTIFIED BY 'pa55word';



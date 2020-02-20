-- create the Hunt and Gather Database for AppsDev

DROP DATABASE IF EXISTS HuntAndGather;
CREATE DATABASE HuntAndGather;
USE HuntAndGather;  -- MySQL command

CREATE TABLE `endUser` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `endUser_role_id` int NOT NULL,
  `email` varChar(100) NOT NULL,
  `password` varChar(100) NOT NULL,
  `country` varChar(25) NOT NULL,
  `city` varChar(25) NOT NULL,
  `state` varChar(2),
  `registration_date` datetime NOT NULL DEFAULT (now())
);



CREATE TABLE `restaurant` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT, 
  `name` varChar(100) NOT NULL,
   `city` varChar(50) NOT NULL,
  `state` varChar(2) NOT NULL,
  `contact_person_first` varChar(100),
  `contact_person_last` varChar(100),
  `phone` int(10),
  `isRegistered` tinyint NOT NULL,
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

CREATE TABLE `foodProduct` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `name` varChar(100) NOT NULL,
  `upc` int(11)
);

CREATE TABLE `endUserType` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `description` varChar(100)
);

CREATE TABLE `meal` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `name` varChar(100) NOT NULL,
  `restaurant_id` int(11),
  `isOfficial` bit NOT NULL
);

CREATE TABLE `mealRestaurant` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `meal_id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL
);

CREATE TABLE `foodProductMeal` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `foodProduct_id` int(11) NOT NULL,
  `meal_id` int(11) NOT NULL
);

CREATE TABLE `allergenMeal` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `allergen_id` int(11) NOT NULL,
  `meal_id` int(11) NOT NULL
);

CREATE TABLE `foodProductAllergen` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `allergen_id` int(11) NOT NULL,
  `foodProduct_id` int(11) NOT NULL
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

ALTER TABLE `foodProductAllergen` ADD FOREIGN KEY (`foodProduct_id`) REFERENCES `foodProduct` (`id`);

ALTER TABLE `foodProductAllergen` ADD FOREIGN KEY (`allergen_id`) REFERENCES `allergen` (`id`);

ALTER TABLE `foodProductMeal` ADD FOREIGN KEY (`foodProduct_id`) REFERENCES `foodProduct` (`id`);

ALTER TABLE `foodProductMeal` ADD FOREIGN KEY (`meal_id`) REFERENCES `meal` (`id`);

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
(1,2, 'admin@st.com', 'pass', 'United States', 'Detroit', 'MI', NOW()),
(2,1, 'aa@st.com', 'pass', 'United States', 'Duluth', 'MN', NOW()),
(3,1, 'bb@st.com', 'pass', 'United States', 'Milwaukee', 'WI', NOW()),
(4,1, 'cc@st.com', 'pass', 'United States', 'Fort Walton Beach', 'FL', NOW()),
(5,1, 'dd@st.com', 'pass', 'United States', 'St. Paul', 'MN', NOW());

insert into restaurant VALUES
(1,'Dunkin Donuts', 'Duluth', 'MN', null, null, null, '0', NOW()),
(2,'Pizza Luce', 'Duluth', 'MN', null, null, null, '0', NOW()),
(3,"McDonald's", 'Superior', 'WI', '', '', null, '0', NOW()),
(4,'Test Restaurant', 'TestCity', 'WI', "Nancy", "Kerrigan", "1112223344", '0', NOW());

insert into meal VALUES
(1,'Dunkin Burrito Bowl', 1, 1),
(2,'Test Meal', 1, 1),
(3,'WholegrainSausage McMuffin with Egg', 3, 1),
(4,'Meal with all allergens', 4, 1),
(5,'Meal with no allergens', 4, 1),
(6,'Unofficial meal', 1, 0);


insert into foodProduct VALUES
(1,'Haribo Gummy Bears', null),
(2,'flour', null),
(3,'Silk Soymilk', null);

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
(37, 8, 1);


insert into endUserAllergen VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 7);

insert into foodProductMeal VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 3);

insert into mealRestaurant VALUES
(1, 1, 1),
(2, 2, 4),
(3, 3, 3);

insert into foodProductAllergen VALUES
(1, 11, 2),
(2, 1, 2),
(3, 2, 3);





-- create the endUsers and grant privileges to those endUsers
-- GRANT SELECT, INSERT, DELETE, UPDATE
-- ON HuntAndGather.*
-- TO mgs_User@localhost
-- IDENTIFIED BY 'pa55word';



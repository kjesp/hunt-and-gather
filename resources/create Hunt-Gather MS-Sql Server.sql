-- create the Hunt and Gather Database for AppsDev
--USE master
--GO

--IF DB_ID('HuntAndGather') IS NOT NULL
--    DROP DATABASE HuntAndGather
--GO

DROP DATABASE IF EXISTS HuntAndGather;

/****** Object:  Database Examples    ******/
CREATE DATABASE HuntAndGather;


USE HuntAndGather;


----DROP DATABASE IF EXISTS HuntAndGather;

--CREATE DATABASE HuntAndGather;
--USE HuntAndGather;  

CREATE TABLE endUser (
  id int PRIMARY KEY NOT NULL IDENTITY(1,1),
  endUser_role_id int NOT NULL,
  email varChar(100) NOT NULL,
  pw varChar(100) NOT NULL,
  city varChar(25) NOT NULL,
  [state] varChar(2) NOT NULL,
  zip varChar(5) NOT NULL,
  registration_date datetime NOT NULL DEFAULT (GETDATE())
)
GO

CREATE TABLE restaurant (
  id int PRIMARY KEY NOT NULL IDENTITY(1,1), 
  name varChar(100) NOT NULL,
  city varChar(50) NOT NULL,
  state varChar(2) NOT NULL,
  zip varChar(5) NOT NULL,
  contact_person_first varChar(100),
  contact_person_last varChar(100),
  phone int,
  is_registered bit NOT NULL,
  registration_date datetime
)
GO

CREATE TABLE review (
  id int PRIMARY KEY NOT NULL IDENTITY(1,1),
  endUser_id int NOT NULL,
  restaurant_id int,
  meal_id int,
  comment varchar(300),
  rating int,
  date_added datetime NOT NULL DEFAULT (GETDATE())
);

CREATE TABLE endUserType (
  id int PRIMARY KEY NOT NULL IDENTITY(1,1),
  [description] varChar(100)
)
GO

CREATE TABLE meal (
  id int PRIMARY KEY NOT NULL IDENTITY(1,1),
  name varChar(100) NOT NULL,
  restaurant_id int,
  is_official bit NOT NULL,
  date_added datetime NOT NULL DEFAULT (GETDATE())
);

CREATE TABLE mealRestaurant (
  id int PRIMARY KEY NOT NULL IDENTITY(1,1),
  meal_id int NOT NULL,
  restaurant_id int NOT NULL
)
GO

CREATE TABLE allergenMeal (
  id int PRIMARY KEY NOT NULL IDENTITY(1,1),
  allergen_id int NOT NULL,
  meal_id int NOT NULL
)
GO

CREATE TABLE endUserAllergen (
  id int PRIMARY KEY NOT NULL IDENTITY(1,1),
  endUser_id int NOT NULL,
  allergen_id int NOT NULL
)
GO


CREATE TABLE allergen (
  id int PRIMARY KEY NOT NULL IDENTITY(1,1),
  name varChar(100) NOT NULL
)
GO

ALTER TABLE endUserAllergen ADD FOREIGN KEY (endUser_id) REFERENCES endUser (id)

ALTER TABLE mealRestaurant ADD FOREIGN KEY (restaurant_id) REFERENCES restaurant (id);

ALTER TABLE meal ADD FOREIGN KEY (restaurant_id) REFERENCES restaurant (id);

ALTER TABLE mealRestaurant ADD FOREIGN KEY (meal_id) REFERENCES meal (id);

ALTER TABLE allergenMeal ADD FOREIGN KEY (allergen_id) REFERENCES allergen (id);

ALTER TABLE allergenMeal ADD FOREIGN KEY (meal_id) REFERENCES meal (id);

ALTER TABLE endUserAllergen ADD FOREIGN KEY (allergen_id) REFERENCES allergen (id);

ALTER TABLE review ADD FOREIGN KEY (endUser_id) REFERENCES endUser (id);

ALTER TABLE review ADD FOREIGN KEY (endUser_id) REFERENCES restaurant (id);

ALTER TABLE review ADD FOREIGN KEY (endUser_id) REFERENCES meal (id);

ALTER TABLE endUser ADD FOREIGN KEY (endUser_role_id) REFERENCES endUserType (id);

-- insert data into the database
SET IDENTITY_INSERT endUserType OFF
INSERT INTO endUserType ([description]) VALUES
('Member'),
('Administrator');
--SET IDENTITY_INSERT endUserType ON

--SET IDENTITY_INSERT endUser ON
INSERT INTO endUser (endUser_role_id, email, pw, city, [state], zip, registration_date) VALUES
(2, 'admin@st.com', 'pass', 'Detroit', 'MI', '48127', GETDATE()),
(1, 'aa@st.com', 'pass', 'Duluth', 'MN', '55805', GETDATE()),
(1, 'bb@st.com', 'pass', 'Milwaukee', 'WI', 53201, GETDATE()),
(1, 'cc@st.com', 'pass', 'Fort Walton Beach', 'FL', '32547', GETDATE()),
(1, 'dd@st.com', 'pass', 'St. Paul', 'MN', '55101', GETDATE());

--SET IDENTITY_INSERT restaurant ON
INSERT restaurant ([name], city, [state], zip,contact_person_first, contact_person_last,
phone, is_registered, registration_date) VALUES
('Dunkin Donuts', 'Duluth', 'MN', '55810', null, null, null, 0, GETDATE()),
('Pizza Luce', 'Duluth', 'MN', '55802', null, null, null, 0, GETDATE()),
('McDonalds', 'Superior', 'WI', '54880', null, null, null, 0, GETDATE()),
('Test Restaurant', 'TestCity', 'WI', '11111', 'Nancy', 'Kerrigan', '1112223344', 0, GETDATE());

--SET IDENTITY_INSERT meal ON
INSERT meal ([name], restaurant_id, is_official, date_added ) VALUES
 --(1,Dunkin Burrito Bowl, 1, 1, GETDATE()),
('Dunkin has Egg, Soy, Milk', 1, 1, GETDATE()),
-- (2,Test Meal, 1, 1, GETDATE()),
( 'Luce has Chicken', 2, 1, GETDATE()),
-- (3,WholegrainSausage McMuffin 'WI'th Egg, 3, 1, GETDATE()),
('Mcdonalds has Egg, Soy, Milk, Wheat, Pork', 3, 1, GETDATE()),
-- (4,Meal 'WI'th all Allergens, 4, 1, GETDATE()),
('Meal with all Allergens', 4, 1, GETDATE()),
-- (5,Meal 'WI'th no Allergens, 4, 1, GETDATE()),
('Meal with no Allergens', 4, 1, GETDATE()),
-- (6,Unofficial Meal', 1, 0, GETDATE());
('Dunkin Unofficial Meal No Allergens', 1, 0, GETDATE());

--SET IDENTITY_INSERT review ON
INSERT review (endUser_id, restaurant_id, meal_id, comment, rating, date_added) VALUES
(1, 1, 1, 'this place does not have anything gluten free', 2, GETDATE()),
(1, 2, 2, 'lots of vegan and gf options!', 5, GETDATE()),
(1, 4, 4, 'lots of allergens', 5, GETDATE()),
(2, 4, 5, 'everything allergen free', 1, GETDATE());

--SET IDENTITY_INSERT allergen ON
INSERT allergen([name]) VALUES
('Dairy'),
('Egg'),
('Peanut'),
('Tree nut'),
('Shellfish'),
('Beef'),
('Lactose'),
('Soy'),
('Corn'),
('Wheat'),
('Gluten'),
('Fish'),
('Gelatin'),
('Sesame'),
('Caraway'),
('Coriander'),
('Mustard'),
('Garlic'),
('Sunflower'),
('Poppy'),
('Pork'),
('Chicken'),
('MSG'),
('Sulphite'),
('Oat'),
('Yeast'),
('Rice'),
('Balsam of Peru'),
('Milk'),
('test');
--SET IDENTITY_INSERT allergenMeal ON
INSERT allergenMeal (allergen_id, meal_id) VALUES
(2, 3),
(29, 3),
(8, 3),
(10, 3),
(2, 1),
(29, 1),
(21, 3),
(1, 4),
(2, 4),
(3, 4),
(4, 4),
(5, 4),
(6, 4),
(7, 4),
(8, 4),
(9, 4),
(10, 4),
(11, 4),
(12, 4),
(13, 4),
(14, 4),
(15, 4),
(16, 4),
(17, 4),
(18, 4),
(19, 4),
(20, 4),
(21, 4),
(22, 4),
(23, 4), 
(24, 4), 
(25, 4), 
(26, 4), 
(27, 4), 
(28, 4), 
(29, 4), 
(8, 1),
(22, 2);

--SET IDENTITY_INSERT endUserAllergen ON
INSERT endUserAllergen(endUser_id, allergen_id ) VALUES
(1, 1),
(1, 2),
(2, 7);

--SET IDENTITY_INSERT mealRestaurant ON
INSERT mealRestaurant(meal_id, restaurant_id ) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 4),
(6, 1);



-- create the endUsers and grant privileges to those endUsers
-- GRANT SELECT, INSERT, DELETE, UPDATE
-- ON HuntAndGather.*
-- TO mgs_User@localhost
-- IDENTIFIED BY pa55word;

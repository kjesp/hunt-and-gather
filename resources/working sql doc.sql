USE HuntAndGather;
-- this is a test change I am making
select * from endUser
select * from allergen
select * from meal
select * from allergenMeal
select * from restaurant
select * from endUserAllergen
select * from mealRestaurant
select * from review;

-- inserts are in my create file

-- updates - admin only?
UPDATE [table] (admin only?)
SET [column name = "", column name = ""]
where [condition]

-- deletes (admin only)
DELETE FROM [table]
where [condition]

----------------------------------------------------------------------------------

-- if allergen_id is 2, return meal_id
(select A.allergen_id, A.meal_id
from allergenMeal A
where allergen_id=2)

-- uses above query, returns meal ids of all meals with egg
select M.id
from meal M
where M.id = any
(select A.meal_id
from allergenMeal A
where allergen_id=2)

-- now i need to get meal_ids that do NOT match the previous result set

-- FINAL: This query returns all meals that do not have egg.

----------------------------------------------------------------------------------

















How to create a temp table: 

			Create TEMPORARY TABLE local_rest
			select restaurant.id,
            restaurant.name,
            restaurant.city
            from restaurant
            where restaurant.city = 'Duluth'
            
			select * from local_rest            

 -------------------------------------------------------------------------------------------------------------

This returns meals that have egg

			create TEMPORARY TABLE has_egg
			select allergenMeal.id as allergenMealID,
			allergenMeal.allergen_id,
			allergen.name as allergenName,
			allergenMeal.meal_id,
			meal.name as mealName
			from allergenMeal
			join allergen on allergen.id=allergenMeal.allergen_id 
			join meal on meal.id = allergenMeal.meal_id
			where allergen.id <> 2
            
 select * from has_egg
 select * from meal
 
  
  			select name         
            from meal      
            join 
            (
            select allergenName, mealName
            from has_egg
            
            ) as hasEgg 
            on meal.id=hasEgg.meal_id
            
            
            
            where meal.name <> has_egg.mealName
            
							select T.tweet_id, T.favorite_count, T.retweet_count, T2.C 
							FROM tweets T 
							JOIN 
							(   SELECT in_reply_to_id, COUNT(in_reply_to_id) as C 
								FROM mentions 
								WHERE in_reply_to_id>0 
								GROUP BY in_reply_to_id
							) T2 on T.tweet_id = T2.in_reply_to_id;
            
             then get all meals in duluth where meal id is not meal id from has_egg
            join mealRestaurant on mealRestaurant.meal_id=has_egg.meal_id
            
            -------------------------------------------------------------------------------------------------------------

QUERY IN PROGRESS: This one should return all meals that dont have pork or eggs. (no location specified until I add more data)            
            
            select * from allergenMeal
join allergen on allergen.id=allergenMeal.allergen_id
join meal on meal.id=allergenMeal.meal_id
where allergen.id <> 1
and allergen.id <> 2
and allergen.id <> 5
and allergen.id <> 6
and allergen.id <> 12
and allergen.id <> 13
and allergen.id <> 30
and allergen.id <> 21
and allergen.id <> 22
            (1, 'dairy'),
(2, 'egg'),
(5, 'shellfish'),
(6, 'beef'),
(12, 'fish'),
(13, 'gelatin'),
(30, 'milk'),
(21, 'pork'),
(22, 'chicken'),


create TEMPORARY TABLE has_egg
			select allergenMeal.id as allergenMealID,
			allergenMeal.allergen_id,
			allergen.name as allergenName,
			allergenMeal.meal_id,
			meal.name as mealName,
			restaurant.name as restaurantName,
			restaurant.city
			from allergenMeal
			join allergen on allergen.id=allergenMeal.allergen_id 
			join meal on meal.id = allergenMeal.meal_id
			join mealRestaurant on mealRestaurant.meal_id = allergenMeal.meal_id
			join restaurant on restaurant.id = mealRestaurant.restaurant_id
			where allergen.id = 2
			and restaurant.city = 'Duluth';


select M.id, M.name, M.restaurant_id, M.is_official, M.date_added
                    from meal M
                    join review 
                    on review.meal_id = M.id
                    where M.id not in
                            (select M.id
                            from meal M
                            where M.id = any
                                    (select A.meal_id
                                    from allergenMeal A
                                    where allergen_id = :allergenIDsList
                            order by review.rating;
                            
                            
                            
                            select * from restaurant;
                            
                            
                            
      use huntandgather;                      
select M.id, M.name, M.restaurant_id, M.is_official, M.date_added
                    from meal M
                    left join review on review.meal_id = M.id
                    join restaurant R on R.id = M.restaurant_id                    
                    where M.restaurant_id = any
                            (select R.id
                            from restaurant R
                            where city = "Duluth"
                            or zip = "11111")                     
                            and M.id = any
                                    (select M.id
                                     from meal M
                                     where M.id not in
                                            (select M.id
                                             from meal M
                                             where M.id = any
                                                    (select A.meal_id
                                                      from allergenMeal A
                                                        where allergen_id = 2 or 22)))
                                                        order by review.rating;
                                                        
                                                        
                                                        
                                                        
                                                        
            select M.id, M.name, M.restaurant_id, M.is_official, M.date_added
                    from meal M
                    left join review on review.meal_id = M.id
                    join restaurant R on R.id = M.restaurant_id                    
                    where M.restaurant_id = any
                            (select R.id
                            from restaurant R
                            where (R.city = "Duluth"
                            or R.zip = "Duluth"))            
                            and M.id = any
                                    (select M.id
                                     from meal M
                                     where M.id not in
                                            (select M.id
                                             from meal M
                                             where M.id = any
                                                    (select A.meal_id
                                                      from allergenMeal A
                                                        where allergen_id in (2,22))))
                                                        order by review.rating;                                       
                                                        
                                                        2, 10, 11, 15, 
                                                        
                                                        -- 22 (chicken): meals 2 and 4 (luce has chicken and test meal w/all allergens
                                                        -- 2 (egg): meals 3, 1, 4 (mcdonalds has egg soy milk wheat pork, dunkn has egg, soy 
															-- milk, test meal with all allergens
                                                            --  so the 2 or 22 search should return 1, 2, 3, 4
                                                            --  6 meals total: only 5 and 6 have no egg or chicken
                                                        
                                                        
									(select R..id
                                     from restaurant R
                                     where R.id = any
                                            (select R.id
                                             from restaurant R
                                             where R.id = any
                                                    (select RM.restaurant_id
                                                      from restaurantMeal RM
                                                        where RM.restuarant_id = 1)))
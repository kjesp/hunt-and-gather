use huntandgather;

select M.id, M.name, M.restaurant_id, M.is_official, M.date_added 
    from meal M 
    join restaurant R on R.id = M.restaurant_id 
    where M.restaurant_id = any 
            (select R.id from restaurant R where ((city = "duluth" or zip = "duluth")and zip <> "")) 
    and M.id = any 
            (select M.id from meal M where M.id not in                    
                    (select A.meal_id from allergenMeal A where allergen_id = 22 or 2));           
           

-- This is what it looks like in netbeans - the first part (the restaurant bit seems to always work, 
-- but the allergenIDsList isn't accurate when the string includes more than one allergen)
select M.id, M.name, M.restaurant_id, M.is_official, M.date_added 
    from meal M 
    join restaurant R on R.id = M.restaurant_id 
    where M.restaurant_id = any 
            (select R.id from restaurant R where ((city = :location or zip = :location)and zip <> "")) 
    and M.id = any 
            (select M.id from meal M where M.id not in                    
                    (select A.meal_id from allergenMeal A where allergen_id =: allergenIDsList));
           
           

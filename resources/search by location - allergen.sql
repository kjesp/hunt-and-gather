-- Search by location / allergen

use huntandgather;

select M.id
from meal M
where M.restaurant_id = any
	(select R.id
		from restaurant R
		where city = "TestCity")
and M.id = any
	(select M.id
	from meal M
	where M.id not in
		(select M.id
		from meal M
		where M.id = any
			(select A.meal_id
			from allergenMeal A
			where allergen_id=2)));

        
-- Returns all meals in specified city WITHOUT specified allergen ("Duluth" and "egg" in this case)
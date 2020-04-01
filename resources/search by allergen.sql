-- SEARCH BY ALLERGEN

use huntandgather;

-- This returns meals with no egg, ordered by rating

select M.id, M.name, review.rating
from meal M
join review 
on review.meal_id = M.id
where M.id not in
	(select M.id
	from meal M
	where M.id = any
		(select A.meal_id
		from allergenMeal A
		where allergen_id=2))
        order by review.rating;

----------------------------------------------------------------------------------
-- This returns meals with no allergens at all

select M.id
from meal M
where M.id not in
	(select M.id
	from meal M
	where M.id = any
		(select A.meal_id
		from allergenMeal A
		where allergen_id=2 or 3 or 4 or 5 or 6 or 7 or 8 or 9 or 10
        or 11 or 12 or 13 or 14 or 15 or 16 or 17 or 18 or 19 or 20
        or 21 or 22 or 23 or 24 or 25 or 26 or 27 or 28 or 29))

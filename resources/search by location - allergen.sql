-- Search by location / allergen

use huntandgather;

select M.id, M.name, R.name, R.zip, R.city
from meal M
join restaurant R on R.id = M.restaurant_id
where M.restaurant_id = any
	(select R.id
		from restaurant R
		where city = "Duluth"
        or zip = "Duluth")
and M.id = any
	(select M.id
	from meal M
	where M.id not in
		(select M.id
		from meal M
		where M.id = any
			(select A.meal_id
			from allergenMeal A
			where allergen_id=22 or 2)));

        
-- Returns all meals in specified city WITHOUT specified allergen ("TestCity" and "egg" in this case)

select M.id, M.name, M.restaurant_id, M.is_official, M.date_added
                    from meal M
                    join review REV on REV.meal_id = M.id
                    join restaurant R on R.id = M.restaurant_id                    
                    where M.restaurant_id = any
                            (select R.id
                            from restaurant R
                            where city = 'duluth'
                            or zip = 'duluth')
                            and M.id = any
                                    (select M.id
                                     from meal M
                                     where M.id not in
                                            (select M.id
                                             from meal M
                                             where M.id = any
                                                    (select A.meal_id
                                                      from allergenMeal A
                                                        where allergen_id = 22 or 2)))
                                         

//        echo $query;
//        echo $allergenIDsList;
//        echo $location;
//        die;               order by FEV.rating;
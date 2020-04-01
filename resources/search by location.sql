-- Search by location

use huntandgather;

select * from restaurant;
select * from meal;

select M.name, M.restaurant_id, R.name, R.city
	from meal M
    join restaurant R on R.id = M.restaurant_id
	where M.restaurant_id = any
		(select R.id
		from restaurant R
		where city = "TestCity");
        
-- Returns all meals in specified city ("TestCity" in this case)
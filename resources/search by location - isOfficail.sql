-- Search by location/ isOfficial

use huntandgather;

-- meal official
select M.id
from meal M
where M.restaurant_id = any
	(select R.id
		from restaurant R
		where city = "Duluth")
and M.id = any
	(select M.id
	from meal M
	where M.isOfficial = 1);
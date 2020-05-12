<?php
class MealDB{    
        
    public static function add_meal($mealParam){
        $db= new Database();
        $db = Database::getDB();
        $meal = $mealParam;
        
        $query = 'INSERT INTO meal
            (name, restaurant_id, is_official)
                  VALUES
                        (:name,
                        :restaurant_id, 
                        :is_official)';
        
        $statement = $db->prepare($query);
        $statement->bindValue(':name', $meal->getName());
        $statement->bindValue(':restaurant_id', $meal->getRestaurant_id());
        $statement->bindValue(':is_official', $meal->getIs_official());
        $statement->execute();
        $meal->setId($db->lastInsertId());
        $statement->closeCursor();
        
    }  
        
       public static function getMealList(){
        $db= new Database();
        $db = Database::getDB();
        
        $query = 'SELECT * FROM meal';
        $statement = $db->prepare($query);
        $statement->execute();
        $records = $statement->fetchAll();
        $statement->closeCursor();
        
        $mealObjectArray = array();
        
        foreach ($records as $record) {
            $mealObject = new Meal(
                $record['id'],
                $record['name'],
                $record['restaurant_id'],
                $record['is_official'],
                $record['date_added']);
            
            $mealObjectArray[] = $mealObject;
        }
        return $mealObjectArray;
    }
    
    public static function getMealListForRestaurant($id){
        $db= new Database();
        $db = Database::getDB();
        
        $query = 'SELECT * FROM meal WHERE restaurant_id = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $records = $statement->fetchAll();
        $statement->closeCursor();
        
        $mealObjectArray = array();
        
        foreach ($records as $record) {
            $mealObject = new Meal(
                $record['id'],
                $record['name'],
                $record['restaurant_id'],
                $record['is_official'],
                $record['date_added']);
            
            $mealObjectArray[] = $mealObject;
        }
        return $mealObjectArray;
    }
    
    public static function getMealById($id){
        $db= new Database();
        $db = Database::getDB();

    $query = 'SELECT * FROM meal '
                    . 'WHERE id = :id';
  
            $statement = $db->prepare($query);
            $statement->bindValue(':id', $id);
            $statement->execute();
            $row = $statement->fetch();
            $statement->closeCursor();
            
             if($row['id'] > 0){
             $meal = new Meal(
                $row['id'],
                $row['name'],
                $row['restaurant_id'],
                $row['is_official'],
                $row['date_added']);
        }
        else{
            $meal = new Meal(-1,"","","",null);
        }
       
        return $meal;        
    }
    
    public static function getSearchResultsByAllergens($allergenIDsList){
        $db= new Database();
        $db = Database::getDB();
                        
        $query =    'select M.id, M.name, M.restaurant_id, M.is_official, M.date_added
                    from meal M
                    join review 
                    on review.meal_id = M.id
                    where M.id not in
                            (select M.id
                            from meal M
                            where M.id = any
                                    (select A.meal_id
                                    from allergenMeal A
                                    where allergen_id = :allergenIDsList))
                            order by review.rating;';
        
        $statement = $db->prepare($query);
        $statement->bindValue(':allergenIDsList', $allergenIDsList);
        $statement->execute();
        $records = $statement->fetchAll();
        $statement->closeCursor();
        
        $mealObjectArray = array();
        
        foreach ($records as $record) {
            $mealObject = new Meal(
                $record['id'],
                $record['name'],
                $record['restaurant_id'],
                $record['is_official'],
                $record['date_added']);
            
            $mealObjectArray[] = $mealObject;
        }
        return $mealObjectArray;    
    }
    
    public static function getSearchResultsByAllergensAndLocation($allergenIDsList, $location){
        $db= new Database();
        $db = Database::getDB();
       
//                echo $query;
//                echo $allergenIDsList;
//                echo $location;
//        die;
//$query = 
// 'select M.id, M.name, M.restaurant_id, M.is_official, M.date_added
//        from meal M
//        join restaurant R on M.restaurant_id  = r.id
//        left join allergenmeal AM on M.id = AM.meal_id
//        left join allergen A on am.allergen_id = A.id   
//        left join review REV on REV.meal_id = M.id
//        where (R.city = "'.$location.'"
//                            or R.zip = "'.$location.'")
//        and m.id not in
//            (select meal_id from allergenmeal where allergen_id in ('.$allergenIDsList.'));';

//i went back to this query because it didn't return repeats, then I startead on the front end, and
        //when I retested, it was returning repeats. So who knows.
$query = 
        'select M.id, M.name, M.restaurant_id, M.is_official, M.date_added
                    from meal M
                    left join review on review.meal_id = M.id
                    join restaurant R on R.id = M.restaurant_id                    
                    where M.restaurant_id = any
                            (select R.id
                            from restaurant R
                            where (R.city = "'.$location.'"
                            or R.zip = "'.$location.'"))            
                            and M.id = any
                                    (select M.id
                                     from meal M
                                     where M.id not in
                                            (select M.id
                                             from meal M
                                             where M.id = any
                                                    (select A.meal_id
                                                      from allergenMeal A
                                                        where allergen_id in ('.$allergenIDsList.'))))
                    order by review.rating;';

        
        $statement = $db->prepare($query);
        $statement->execute();
        $records = $statement->fetchAll();
        $statement->closeCursor();
        
        $mealObjectArray = array();
        
        foreach ($records as $record) {
            $mealObject = new Meal(
                $record['id'],
                $record['name'],
                $record['restaurant_id'],
                $record['is_official'],
                $record['date_added']);
            
            $mealObjectArray[] = $mealObject;
        }
      return $mealObjectArray;    
        
    }
    
    public static function getSearchResultsByLocationOnly($location){
        $db= new Database();
        $db = Database::getDB();        
        
                        
        $query =    'select M.id, M.name, M.restaurant_id, M.is_official, M.date_added
                    from meal M
                    join restaurant R on R.id = M.restaurant_id
                    where M.restaurant_id = any
                            (select R.id
                            from restaurant R
                            where city = :location
                            or zip = :location);';
        
        $statement = $db->prepare($query);
        $statement->bindValue(':location', $location);
        $statement->execute();
        $records = $statement->fetchAll();
        $statement->closeCursor();
        
        $mealObjectArray = array();
        
        foreach ($records as $record) {
            $mealObject = new Meal(
                $record['id'],
                $record['name'],
                $record['restaurant_id'],
                $record['is_official'],
                $record['date_added']);
            
            $mealObjectArray[] = $mealObject;
        }
        return $mealObjectArray;    
    }
}



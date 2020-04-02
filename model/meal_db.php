<?php
class MealDB{    
        
    public static function add_meal($mealParam){
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
    
}
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
        
       public static function getMealList(){
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
}
    
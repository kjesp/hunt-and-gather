<?php
class JoinTableDb{    
        
   public static function insertMealRestaurantJoinTable($mealID, $restID){
        $db = Database::getDB();
        $meal_id = $mealID;
        $rest_id = $restID;
        
        $query = 'INSERT INTO mealRestaurant
            (meal_id, restaurant_id)
                  VALUES
                        (:meal_id,
                        :restaurant_id)';
        
        $statement = $db->prepare($query);
        $statement->bindValue(':meal_id', $meal_id);
        $statement->bindValue(':restaurant_id', $rest_id);
        $statement->execute();       
        $statement->closeCursor();
    }
    
    public static function insertAllergenMealJoinTable($allergenID, $mealID){
        $db = Database::getDB();
        $allergen_id = $allergenID;
        $meal_id = $mealID;
        
        $query = 'INSERT INTO allergenMeal
            (allergen_id, meal_id)
                  VALUES
                        (:allergen_id,
                        :meal_id)';
        
        $statement = $db->prepare($query);
        $statement->bindValue(':allergen_id', $allergen_id);
        $statement->bindValue(':meal_id', $meal_id);
        $statement->execute();
        $statement->closeCursor();
    }


public static function insertAllergenMealExclude($allergenID, $mealID){
        $db = Database::getDB();
        $allergen_id = $allergenID;
        $meal_id = $mealID;
        
        $query = 'INSERT INTO allergenNotInMeal
            (allergen_id, meal_id)
                  VALUES
                        (:allergen_id,
                        :meal_id)';
        
        $statement = $db->prepare($query);
        $statement->bindValue(':allergen_id', $allergen_id);
        $statement->bindValue(':meal_id', $meal_id);
        $statement->execute();
        $statement->closeCursor();
    }
}
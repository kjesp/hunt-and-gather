<?php
class ReviewDB{    
    
    
    public static function add_Review($reviewParam){
        $db = Database::getDB();
        $review = $reviewParam;
        
        $query = 'INSERT INTO review
            (end_user_id, restaurant_id, meal_id)
                  VALUES
                        (:end_user_id,
                        :restaurant_id, 
                        :meal_id)';
        
        $statement = $db->prepare($query);
        $statement->bindValue(':end_user_id', $review->getEnd_user_id());
        $statement->bindValue(':restaurant_id', $review->getRestaurant_id());
        $statement->bindValue(':meal_id', $review->getMeal_id());
        $statement->execute();
        $statement->closeCursor();
    }
}
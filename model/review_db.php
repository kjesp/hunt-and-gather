<?php
class ReviewDB{    
    
    
    public static function add_Review($reviewParam){
        $db = Database::getDB();
        $review = $reviewParam;
        
        $query = 'INSERT INTO review
            (endUser_id, restaurant_id, meal_id, comment, rating)
                  VALUES
                        (:end_user_id,
                        :restaurant_id, 
                        :meal_id,
                        :comment,
                        :rating)';
        
        $statement = $db->prepare($query);
        $statement->bindValue(':end_user_id', $review->getEnd_user_id());
        $statement->bindValue(':restaurant_id', $review->getRestaurant_id());
        $statement->bindValue(':meal_id', $review->getMeal_id());
        $statement->bindValue(':comment', $review->getComment());
        $statement->bindValue(':rating', $review->getRating());
        $statement->execute();
        $statement->closeCursor();
    }
    
      public static function getMealRatings($mealId){
        $db = Database::getDB();
        
        $query =    'select rating from review
                    where meal_id = :mealId';
        
        $statement = $db->prepare($query);
        $statement->bindValue(':mealId', $mealId);
        $statement->execute();
        $records = $statement->fetchAll();
        $statement->closeCursor();
        
        $ratingsArray = array();
        
        foreach ($records as $record) {
            $ratingsArray[] = $record['rating'];
        }
        return $ratingsArray;
    }

    public static function getMealReviews($mealId){
        $db = Database::getDB();
        
        $query =    'select comment from review
                    where meal_id = :mealId';
        
        $statement = $db->prepare($query);
        $statement->bindValue(':mealId', $mealId);
        $statement->execute();
        $records = $statement->fetchAll();
        $statement->closeCursor();
        
        $reviewsArray = array();
        
        foreach ($records as $record) {
            $reviewsArray[] = $record['comment'];
        }
        return $reviewsArray;
        
    }

}
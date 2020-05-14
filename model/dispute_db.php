<?php
class DisputeDb{    
        
   public static function insertDispute($dispute){
        $db = Database::getDB();
                
        $query = 'INSERT INTO dispute
            (allergen_id, meal_id, explanation, email)
                  VALUES
                        (:allergen_id,
                        :meal_id,
                        :explanation,
                        :email)';
        
        $statement = $db->prepare($query);
        $statement->bindValue(':allergen_id', $dispute->getAllergen_id());
        $statement->bindValue(':meal_id', $dispute->getMeal_id());
        $statement->bindValue(':explanation', $dispute->getExplanation());
        $statement->bindValue(':email', $dispute->getEmail());
        $statement->execute();       
        $statement->closeCursor();
    }  
}
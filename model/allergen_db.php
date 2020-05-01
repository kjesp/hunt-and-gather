<?php
class AllergenDB{    
    
    
    public static function add_allergen($allergenParam){
        $db = Database::getDB();
        $allergen = $allergenParam;
        
        $query = 'INSERT INTO allergen (name)
                  VALUES (:name)';
        
        $statement = $db->prepare($query);
        $statement->bindValue(':name', $allergen->getName());
        $statement->execute();
        $statement->closeCursor();
    }
    
    public static function getAllergenIdFromName($allergenName){
        $db= new Database();
        $db= Database::getDB(); 
           
       $query = 'SELECT id from allergen
               WHERE name = :name';

        $statement = $db->prepare($query);
        $statement->bindValue(':name', $allergenName);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();
        
    return $row['id'];
          
    }
    
    public static function getAllergenById($id){
        $db = Database::getDB();

    $query = 'SELECT * FROM allergen '
                    . 'WHERE id = :id';
  
            $statement = $db->prepare($query);
            $statement->bindValue(':id', $id);
            $statement->execute();
            $row = $statement->fetch();
            $statement->closeCursor();
            
            
             if($row['id'] > 0){
             $allergen = new Allergen(
                $row['id'],
                $row['name']);
             }else{
             $allergen = new Allergen(0, "");    
             }
            
       
        return $allergen;
        
    }
    
    public static function getAllergenList(){
        $db= new Database();
        $db= Database::getDB(); 
           
       $query = 'SELECT * from allergen
               ORDER BY name ASC';
                
            $statement = $db->prepare($query);
            $statement->execute();
            $allergens = array();
            foreach ($statement as $row) {
                    // Add the allergen record.
                    $allergen= new Allergen(
                            $row['id'],  
                            $row['name']);
                                        
                     $allergens[]= $allergen;
                }
       
            return $allergens;
          
    }
    
    public static function getAllergenIDsForMeal($mealId){
         $db = Database::getDB();
        
        $query = 'SELECT * FROM allergenMeal WHERE meal_id = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $mealId);
        $statement->execute();
        $records = $statement->fetchAll();
        $statement->closeCursor();
        
        $allergenIDArray = array();
        
        foreach ($records as $record) {
            $allergenIDArray[] = (int)$record['id'];
        }
        return $allergenIDArray;
    }
    
    public static function getAllergenNamesForMeal($mealId){
         $db = Database::getDB();
        
        $query = '  select a.name from allergen a
                    join allergenmeal am on am.allergen_id = a.id
                    where am.meal_id = :mealId';
        $statement = $db->prepare($query);
        $statement->bindValue(':mealId', $mealId);
        $statement->execute();
        $records = $statement->fetchAll();
        $statement->closeCursor();
        
        $allergenNameArray = array();
        
        foreach ($records as $record) {
            $allergenNameArray[] = $record['name'];
        }
        return $allergenNameArray;
    }
    
   
}


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
}


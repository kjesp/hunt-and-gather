<?php
class RestaurantDB{    
    
    
    public static function add_restaurant($restaurantParam){
        $db = Database::getDB();
        $restaurant = $restaurantParam;
        
        $query = 'INSERT INTO restaurant
            (name, city, state, zip, contact_person_first, contact_person_last, phone, is_registered)
                  VALUES
                        (:name,
                        :city,
                        :state,
                        :zip,
                        :contact_person_first,
                        :contact_person_last,
                        :phone,
                        :is_registered)';
        
        $statement = $db->prepare($query);
        $statement->bindValue(':name', $restaurant->getName());
        $statement->bindValue(':city', $restaurant->getCity());
        $statement->bindValue(':state', $restaurant->getState());
        $statement->bindValue(':zip', $restaurant->getZip());
        $statement->bindValue(':contact_person_first', $restaurant->getContact_first_name());
        $statement->bindValue(':contact_person_last', $restaurant->getContact_last_name());
        $statement->bindValue(':phone', $restaurant->getPhone());
        $statement->bindValue(':is_registered', $restaurant->getIs_registered());
       
        $statement->execute();
        $restaurant->setId($db->lastInsertId());
        $statement->closeCursor();
    }
    
    public static function getRestaurantById($id){
        $db= new Database();
        $db = Database::getDB();

    $query = 'SELECT * FROM restaurant '
                    . 'WHERE id = :id';
  
            $statement = $db->prepare($query);
            $statement->bindValue(':id', $id);
            $statement->execute();
            $row = $statement->fetch();
            $statement->closeCursor();
            
             if($row['id'] > 0){
             $restaurant = new Restaurant(
                $row['id'],
                $row['name'],
                $row['city'],
                $row['state'],
                $row['zip'],
                $row['contact_person_first'],
                $row['contact_person_last'],
                $row['is_registered'],
                $row['registration_date']);
        }
        else{
            $restaurant = new Restaurant(-1,"","","","","",0, null);
        }
       
        return $restaurant;
        
    }
    
    public static function getRestaurantList(){
        $db= new Database();
        $db= Database::getDB(); 
           
       $query = 'SELECT * from restaurant
               ORDER BY name ASC';
                
            $statement = $db->prepare($query);
            $statement->execute();
            $restaurants = array();
            foreach ($statement as $row) {
                    // Add the restaurant record.
                    $restaurant= new Restaurant(
                            $row['id'],  
                            $row['name'],
                            $row['city'],
                            $row['state'],
                            $row['zip'],
                            $row['contact_person_first'],
                            $row['contact_person_last'],
                            $row['phone'],
                            $row['is_registered']                                                        
                            );
                                        
                     $restaurants[]= $restaurant;
                }
       
            return $restaurants;        
    }
    
    public static function getNameUsingId($id){
        $db= new Database();
        $db= Database::getDB(); 
           
       $query = 'SELECT name from restaurant
               WHERE id = :id';

        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();
        
    return $row['name'];
          
    }
    
    public static function searchForDuplicate($name, $city, $state){
        $db= new Database();
        $db= Database::getDB(); 
           
       $query = 'SELECT name, city, state, id from restaurant
               WHERE name = :name
               and city = :city
               and state = :state';

        $statement = $db->prepare($query);
        $statement->bindValue(':name', $name);
        $statement->bindValue(':city', $city);
        $statement->bindValue(':state', $state);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();
        
        
    return $row['id'];
    }
    
//    public static function update_restarurant($restaurantParam){
//        
//        $db = Database::getDB();
//         $restaurant = $restaurantParam;
//      $query = 'UPDATE restaurant
//                    SET name = :name,
//                        city = :city,                        
//                        state = :state,
//                        contact_first_name = :contact_first_name,
//                        contact_last_name = :contact_last_name,
//                        phone = :phone
//                        is_registered = :is_registered
//                        registration_date = :registration_date
//                    WHERE id = :id';
//      
//        $statement = $db->prepare($query);
//       $statement->bindValue(':name', $restaurant->getName());
//        $statement->bindValue(':city', $restaurant->getCity());
//        $statement->bindValue(':state', $restaurant->getState());
//        $statement->bindValue(':contact_first_name', $restaurant->getContact_first_name());
//        $statement->bindValue(':contact_last_name', $restaurant->getContact_last_name());
//        $statement->bindValue(':phone', $restaurant->getName());
//        $statement->bindValue(':is_registered', $restaurant->getIs_registered());
//        $statement->bindValue(':registration_date', $restaurant->getRegistration_date());
//        $statement->bindValue(':id', $restaurant->getId());
//        $statement->execute();
//        $statement->closeCursor();
//
//    }
    
     
}
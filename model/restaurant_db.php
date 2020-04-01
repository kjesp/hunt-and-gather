<?php
class RestaurantDB{    
    
    
    public static function add_restaurant($restaurantParam){
        $db = Database::getDB();
        $restaurant = $restaurantParam;
        
        $query = 'INSERT INTO restaurant
            (name, city, state, zip, contact_person_first, contact_person_last, phone, is_registered, registration_date)
                  VALUES
                        (:name,
                        :city,
                        :state,
                        :zip,
                        :contact_first_name,
                        :contact_last_name,
                        :phone,
                        :is_registered,
                        :registration_date)';
        
        $statement = $db->prepare($query);
        $statement->bindValue(':name', $restaurant->getName());
        $statement->bindValue(':city', $restaurant->getCity());
        $statement->bindValue(':state', $restaurant->getState());
        $statement->bindValue(':zip', $restaurant->getZip());
        $statement->bindValue(':contact_first_name', $restaurant->getContact_first_name());
        $statement->bindValue(':contact_last_name', $restaurant->getContact_last_name());
        $statement->bindValue(':phone', $restaurant->getName());
        $statement->bindValue(':is_registered', $restaurant->getIs_registered());
        $statement->bindValue(':registration_date', $restaurant->getRegistration_date());
        $statement->execute();
        $statement->closeCursor();
    }
    
    public static function update_restarurant($restaurantParam){
        
        $db = Database::getDB();
         $restaurant = $restaurantParam;
      $query = 'UPDATE restaurant
                    SET name = :name,
                        city = :city,                        
                        state = :state,
                        contact_first_name = :contact_first_name,
                        contact_last_name = :contact_last_name,
                        phone = :phone
                        is_registered = :is_registered
                        registration_date = :registration_date
                    WHERE id = :id';
      
        $statement = $db->prepare($query);
       $statement->bindValue(':name', $restaurant->getName());
        $statement->bindValue(':city', $restaurant->getCity());
        $statement->bindValue(':state', $restaurant->getState());
        $statement->bindValue(':contact_first_name', $restaurant->getContact_first_name());
        $statement->bindValue(':contact_last_name', $restaurant->getContact_last_name());
        $statement->bindValue(':phone', $restaurant->getName());
        $statement->bindValue(':is_registered', $restaurant->getIs_registered());
        $statement->bindValue(':registration_date', $restaurant->getRegistration_date());
        $statement->bindValue(':id', $restaurant->getId());
        $statement->execute();
        $statement->closeCursor();

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
                            $row['isRegistered'],
                            $row['registration_date']
                            
                            );
                                        
                     $restaurants[]= $restaurant;
                }
       
            return $restaurants;
          
    }
}
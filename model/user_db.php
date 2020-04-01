<?php
class UserDB{    
//    public static function get_user_by_email_and_password($email, $pw){
//        $db = Database::getDB();
//
//    $query = 'SELECT * FROM endUser '
//                    . 'WHERE email = :email AND pw = :pw';
//  
//            $statement = $db->prepare($query);
//            $statement->bindValue(':email', $email);
//            $statement->bindValue(':pw', $pw);
//            $statement->execute();
//            $row = $statement->fetch();
//            $statement->closeCursor();
//            
//             if($row['id'] > 0){
//             $user = new User(
//                $row['id'],
//                $row['end_user_role_id'],
//                $row['email'],
//                $row['password'],
//                $row['city'],
//                $row['state'],
//                $row['registration_date']);
//        }
//        else{
//            $user = new User(-1,"","","","","","");
//        }
//       
//        return $user;
//            
//    }
    
    public static function is_duplicate_email($email){
        $isDuplicate = false;
        
        $db = Database::getDB();

    $query = 'SELECT * FROM endUser '
                    . 'WHERE email = :email';

            $statement = $db->prepare($query);
            $statement->bindValue(':email', $email);
            $statement->execute();
            $row = $statement->fetch();
            $statement->closeCursor();
            
             if($row['id'] > 0){
             $isDuplicate = true;
             }
        
        return $isDuplicate;
    }

//    public static function update_user($userParam){
//        
//        $db = Database::getDB();
//         $user = $userParam;
//      $query = 'UPDATE endUser
//                    SET email = :email,
//                        pw = :pw,             
//                        city = :city,
//                        state = :state,
//                        registration_date = :registration_date
//                    WHERE id = :id';
//      
//        $statement = $db->prepare($query);
//        $statement->bindValue(':email', $user->getFirst());
//        $statement->bindValue(':pw', $user->getPw());
//        $statement->bindValue(':city', $user->getCity());
//        $statement->bindValue(':state', $user->getState());
//        $statement->bindValue(':registration_date', $user->getRegistration_date());
//        $statement->bindValue(':id', $user->getId());
//        $statement->execute();
//        $statement->closeCursor();
//
//    }
    
    public static function add_user($userParam){
        $db = Database::getDB();
        $user = $userParam;
        
        $query = 'INSERT INTO endUser
                     (endUser_role_id, email, pw, city, state, zip)
                  VALUES
                        (:endUser_role_id,
                        :email,
                        :pw,     
                        :city,
                        :state,
                        :zip)';
        
        $statement = $db->prepare($query);
        $statement->bindValue(':endUser_role_id', $user->getUser_role_id());
        $statement->bindValue(':email', $user->getEmail());       
        $statement->bindValue(':pw', $user->getPw());
        $statement->bindValue(':city', $user->getCity());
        $statement->bindValue(':state', $user->getState());
        $statement->bindValue(':zip', $user->getZip());

        $statement->execute();
        $statement->closeCursor();
    }
}
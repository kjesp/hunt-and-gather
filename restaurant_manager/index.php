<?php
require('../model/database.php');
require('../model/user.php');
require('../model/user_db.php');
        
//if(session_id() == ''){
//    $lifetime = 60 * 60 * 24 * 14;    //two weeks
//    session_set_cookie_params($lifetime, '/');
//    session_start();    
//}
//
//if (!isset($_SESSION['loggedIn'])){
//    $_SESSION['loggedIn'] = false; 
//    $_SESSION['fullName'] = ""; 
//    $_SESSION['id'] = 0;   
//} 
//
//$cookie_userName = "user";
//$cookie_username_value = "please enter a value";
//setcookie($cookie_userName, $cookie_username_value, time() + (86400 * 30), "/");
//
//$cookie_pw = "pw";
//$cookie_pw_value = ".";
//setcookie($cookie_pw, $cookie_pw_value, time() + (86400 * 30), "/");

$controllerChoice = filter_input(INPUT_POST, 'controllerRequest');
if($controllerChoice == NULL){
    $controllerChoice = filter_input(INPUT_GET, 'controllerRequest');
        if ($controllerChoice == NULL) {
            $controllerChoice = "";           
        } 
}

switch($controllerChoice) {
       
    case "submit_add_restaurant":
        $id=0;        
        $mealName = filter_input(INPUT_POST, 'meal_name');  
        $restuarantId = NULL;
        $isOfficial = false;
        
        $meal = new Meal($id, $mealName, $restuarantId, $isOfficial);
        
        MealDB::add_meal($meal);
        //the add_meal method inserts the last inserted id into the user object
     
        $_SESSION['meal_id'] = $meal->getId();
        
        $_SESSION['meal'] = $meal;
       
        //still have to add to mealAllergen and mealReataurant Tables...i think
        
        require_once('restaurant_add_success.php');
        break;
    
    default:        
        require_once '../view/header.php';
        echo '<h2> controllerChoice: $controllerChoice</h2>';
        echo'<h3> File: user_manager/index.php</h3>';
        require_once '../view/footer.php';
}
    

?>
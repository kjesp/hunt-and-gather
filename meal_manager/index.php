<?php
require('../model/database.php');
require('../model/meal.php');
require('../model/meal_db.php');
        
if(session_id() == ''){
    $lifetime = 60 * 60 * 24 * 14;    //two weeks
    session_set_cookie_params($lifetime, '/');
    session_start();    
}
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

//the meal add form has two submit buttons, so the following code uses the 
//names of those buttons to manually set the controllerChoice value in that instance
if(isset($_POST["full_meal_submission"])){
    $controllerChoice = "full_meal_submission";
}
else if(isset($_POST["redirect_meal_to_restaurant_add_form"])){
    $controllerChoice = "redirect_meal_to_restaurant_add_form";
}

switch($controllerChoice) {
       
    case "search":
        require_once('meal_results.php');
        break;
    
    case "addSearchCategory":
        require_once("../allergen_manager/allergen_add_form.php");
        break;
    
    case "submit_add_meal":
        require_once("meal_add_success.php");
        break;
    
    case "submit_review":
        //add review to database based on meal id in parameter
        require_once("../index.php");
        break;
    
    case "full_meal_submission":
        //insert meal and restaurant
        break;
    
    
    case "redirect_meal_to_restaurant_add_form";
        $id=0;        
        $mealName = filter_input(INPUT_POST, 'meal_name');
        $restaurantName = filter_input(INPUT_POST, 'name');
        $city = filter_input(INPUT_POST, 'city');
        $state = filter_input(INPUT_POST, 'state');
        $zip = filter_input(INPUT_POST, 'zip');
        $contactFirst = null;
        $contactLast = null;
        $phone = null;
        $isRegistered = false;
        
        $restaurant = new Restaurant($id, $restaurantName, $city, $state,
                $zip, $contactFirst, $contactLast, $phone, $isRegistered);
        
        MealDB::add_meal($meal);
        //the add_meal method inserts the last inserted id into the user object
     
        $_SESSION['meal_id'] = $meal->getId();
        
        $_SESSION['meal'] = $meal;
       
        //still have to add to mealAllergen and mealReataurant Tables...i think
        require_once("../restaurant_manager/restaurant_add_form.php");
        break;
    
    default:
        require_once '../view/header.php';
        echo '<h2> controllerChoice: $controllerChoice</h2>';
        echo'<h3> File: user_manager/index.php</h3>';
        require_once '../view/footer.php';
        
}
?>
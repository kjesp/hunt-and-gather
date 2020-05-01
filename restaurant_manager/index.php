<?php
require('../model/database.php');
require('../model/user.php');
require('../model/restaurant.php');
require('../model/user_db.php');
require('../model/meal_db.php'); 
require('../model/allergen_db.php');
require('../model/join_table_db.php');
require('../model/meal.php'); 
require('../model/restaurant_db.php');
        
if(session_id() == ''){
    $lifetime = 60 * 60 * 24 * 14;    //two weeks
    session_set_cookie_params($lifetime, '/');
    session_start();    
}

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
       
    case "submit_add_meal_and_restaurant":
        /*user has previously entered meal info, which is stored in session
        this method retrieves that info and makes inserts to meal, restaurant, 
        allergenMeal and mealRestaurant tables*/
        $meal = new Meal(0, $_SESSION['meal']->getName(), null, false, null);         
        
        //get restaurant info
        $id=0;        
        $name = filter_input(INPUT_POST, 'name'); 
        $city = filter_input(INPUT_POST, 'city'); 
        $state = filter_input(INPUT_POST, 'state'); 
        $zip = filter_input(INPUT_POST, 'zip');
        $contactFirst = null;
        $contactLast = null;
        $phone = null;
        $isRegistered = false;
        
 /***  validate here before adding to db. Meal info will have already been validated*****************************************************************************************************************************/
    //capitalize the words in the name if they aren't already
        $lowerCaseRestName = strtolower($name);
        $firstLettersCapitalRestName = ucwords($lowerCaseRestName); 
        
         //capitalize the words in the city if they aren't already
        $lowerCaseCity = strtolower($city);
        $firstLettersCapitalCity = ucwords($lowerCaseCity); 
        
        //capitalize the words in the state, city if they aren't already
        $upperCaseState = strtoupper($state);         

    //look for duplicate: if $name AND $city AND $state match db entry, return restaurant
        $duplicateRestaurantID = RestaurantDB::searchForDuplicate($firstLettersCapitalRestName, $firstLettersCapitalCity, $upperCaseState );
        
        
    //if duplicate, reload restaurant page with link and message
        
        
           
        
          
        
/***duplicate above code for contact first and last name            ***/
        
        
        $restaurant = new Restaurant($id, $firstLettersCapitalRestName, $firstLettersCapitalCity, $upperCaseState, $zip, $contactFirst, 
                $contactLast, $phone, $isRegistered);
        
        
        RestaurantDB::add_restaurant($restaurant); 
        /*the add_restaurant method inserts the last inserted id into the user object
        add it to the meal object before inserting meal*/
        $meal->setRestaurant_id($restaurant->getId());
        MealDB::add_meal($meal);
                           
        //add to mealReataurant Table
        JoinTableDb::insertMealRestaurantJoinTable($meal->getId(), $restaurant->getId());
        
        /*get allergen info from session (this will be an array based on the
        number of allergen checkboxes selected*/
        $allergensSelected = $_SESSION['names_of_allergens_not_in_meal'];
        
        /*loop through array of strings and for each one, get the allergen id from the db
        based on the name, then use the id to add allergen to allergenMeal table*/
        foreach($allergensSelected as $name){
            $allergenId = AllergenDB::getAllergenIdFromName($name);
            JoinTableDb::insertAllergenMealJoinTable($allergenId, $meal->getId());
        }
        
        $_SESSION['restaurant'] = $restaurant;
        
        require_once('restaurant_add_success.php');
        break;
        
        
        
    case "get_meals_for_restaurant_by_id":
        $restaurantId = filter_input(INPUT_POST, 'restaurant_id');
        
        $restaurant = RestaurantDB::getRestaurantById($restaurantId);            
        $meals = MealDB::getMealListForRestaurant($restaurant->getId());
        $_SESSION['restaurant'] = $restaurant;  
        $_SESSION['meals'] = $meals;  
        
        require_once("restaurant_detail.php");
        break;
    
    default:        
        require_once '../view/header.php';
        echo '<h2> controllerChoice: $controllerChoice</h2>';
        echo'<h3> File: user_manager/index.php</h3>';
        require_once '../view/footer.php';
}
    

?>
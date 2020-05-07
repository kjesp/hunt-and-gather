<?php
require('../model/database.php');
require('../model/meal.php');
require('../model/meal_db.php');
require('../model/allergen.php');
require('../model/allergen_db.php');
require('../model/review_db.php');
require('../model/restaurant_db.php');
require('../model/restaurant.php');

        
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
    
    case "searchNewLocation":
        $message = "";  
        $searchLocation = filter_input(INPUT_POST, 'search');          
        $allergenIDArray =  $_SESSION['allergenIDArray'];
        
        //The following, until the break, is repeated code. In the future, abstract this
        //loop through name id array and add to string for select query
             $stringListOfAllergensWithComma = "";
             foreach($allergenIDArray as $allergenID){
                $stringListOfAllergensWithComma = $stringListOfAllergensWithComma.",".$allergenID;
            }
            
           //trim query so it dosn't have a comma at the beginning 
           $trimmedIdListOfAllergens = substr($stringListOfAllergensWithComma, 1);
            
           //use trimmed string to query database and return an array of appropriate meals to display
            $meals = MealDB::getSearchResultsByAllergensAndLocation($trimmedIdListOfAllergens, $searchLocation);
            
            //foreach meal in the resulting array, get the restuarant id, use the id to retrieve the restaruant f/
            //db, and add the restaurant to restaurants array.
            $restaurants = array();
            foreach($meals as $meal){
              if(!in_array(RestaurantDB::getRestaurantById($meal->getRestaurant_id()), $restaurants)){
                     //if the restaurant isn't already in the array, add it
                     array_push($restaurants, RestaurantDB::getRestaurantById($meal->getRestaurant_id())); 
                 }  
            }            
            $_SESSION['message'] = $message;           
            $_SESSION['meals'] = $meals;
            $_SESSION['restaurants'] = $restaurants;
            
        require_once('meal_results.php');
        
        break;
       
    case "search":    
        $message = "";  
        $searchLocation = filter_input(INPUT_POST, 'search');             
                        
        //if any allergens were selected, put them in an array (string array of names)
         if(isset($_POST['allergenChecklist'])) {
            $allergenNameArray = $_POST['allergenChecklist']; 
            
            
            //get an array of allergenID's to pass to the search method
            $allergenIDArray = array();            
            foreach($allergenNameArray as $allergenName){
                array_push($allergenIDArray, AllergenDB::getAllergenIdFromName($allergenName));
            }
            
            //loop through name id array and add to string for select query
             $stringListOfAllergensWithComma = "";
             foreach($allergenIDArray as $allergenID){
                $stringListOfAllergensWithComma = $stringListOfAllergensWithComma.",".$allergenID;
            }
            
           //trim query so it dosn't have a comma at the beginning 
           $trimmedIdListOfAllergens = substr($stringListOfAllergensWithComma, 1);
            
           //use trimmed string to query database and return an array of appropriate meals to display
            $meals = MealDB::getSearchResultsByAllergensAndLocation($trimmedIdListOfAllergens, $searchLocation);
            
            //foreach meal in the resulting array, get the restuarant id, use the id to retrieve the restaruant f/
            //db, and add the restaurant to restaurants array.
            $restaurants = array();
            foreach($meals as $meal){
              if(!in_array(RestaurantDB::getRestaurantById($meal->getRestaurant_id()), $restaurants)){
                     //if the restaurant isn't already in the array, add it
                     array_push($restaurants, RestaurantDB::getRestaurantById($meal->getRestaurant_id())); 
                 }  
            }            
            $_SESSION['allergensChosen'] = $allergenNameArray;
         }         
         else{//if no allergens were chosen, display an appropriate message explaining that, then return a full list of meals and restaurants for 
             //that location
             $message = "No allergens selected. Here is a full list of meals and restaurants for your location:";
             
             $meals = MealDB::getSearchResultsByLocationOnly($searchLocation);
             
             $restaurants = array();
             foreach($meals as $meal){
                        if(!in_array(RestaurantDB::getRestaurantById($meal->getRestaurant_id()), $restaurants)){
                            //if the restaurant isn't already in the array, add it
                            array_push($restaurants, RestaurantDB::getRestaurantById($meal->getRestaurant_id())); 
                        }              
                }  //end foreach
             $_SESSION['allergensChosen'] = null;
            }                                     
            
            $_SESSION['message'] = $message;           
            $_SESSION['meals'] = $meals;
            $_SESSION['restaurants'] = $restaurants;
            $_SESSION['listOfAllergensWithCommas'] = $stringListOfAllergensWithComma;
            $_SESSION['allergenIDArray'] = $allergenIDArray;
            
        require_once('meal_results.php');
        break;
    
    case "get_meal_details":
        $mealId = filter_input(INPUT_POST, 'meal_id');
        $meal = MealDB::getMealById($mealId);
        
        //array of allergen names in meal
        $allergenNamesArray = AllergenDB::getAllergenNamesForMeal($mealId);
        
        //get array of all ratings of meal
        $ratingsArray = ReviewDB::getMealRatings($mealId);
        
        $avgRating = null;
        //get average of ratings
        if(count($ratingsArray) > 0){
            $avgRating = array_sum($ratingsArray) / count($ratingsArray);
        }        
        
        //get reviews for meal, ordered by newest to oldest
        $reviewsArray = ReviewDB::getMealReviews($mealId);
        
        $_SESSION['reviewsForMeal'] = $reviewsArray;
        $_SESSION['averageRating'] = $avgRating;
        $_SESSION['meal'] = $meal;
        $_SESSION['allergensInMeal'] = $allergenNamesArray;
        
        require_once("meal_detail.php");
        break;
    
    case "addSearchCategory":
        require_once("../allergen_manager/allergen_add_form.php");
        break;
    
    case "submit_add_meal":
        require_once("meal_add_success.php");
        break;
    
    case "submit_review":
        //add review to database based on meal ID in parameter
        require_once("../index.php");
        break;
    
    case "full_meal_submission":
        //insert meal and restaurant
        //still have to add to mealAllergen and mealReataurant Tables...i think
        break;
    
    
    case "redirect_meal_to_restaurant_add_form";
        /*in this case, the user added meal info, but couldn't find the
         * restaurant in the drop-down. This method saves all the necessary meal data to the session,
        then redirects to the restaurant add form. All the DB inserts will
        take place in restaurant_manager/indexp.php     */
        
        //get the checked allergens and add to an array for mealAllergen table
        $selectedAllergens = array();
            if(!empty($_POST['check_list'])){
            // Loop to store and display values of individual checked checkbox.
                foreach($_POST['check_list'] as $selected){
//                    $allergen = new Allergen(
//                            0,$selected);
                    
                    $selectedAllergens[]= $selected;
                }
            }            
                
        //info for review table
        $rating = filter_input(INPUT_POST, 'rating');
        $review = filter_input(INPUT_POST, 'review');

        //info for meal table
        $id=0;        
        $mealName = filter_input(INPUT_POST, 'meal_name');
        $restaurantId = null;
        $isOfficial = false;
        
        //capitalize the words in the name if they aren't already
        $lowerCaseMealName = strtolower($mealName); //first lower case
        $firstLettersCapitalMealName = ucwords($lowerCaseMealName);  //then capitalize the first letters    
        
        //create meal object for saving to session
        $meal = new Meal($id, $firstLettersCapitalMealName, $restaurantId, $isOfficial, null);        
        //MealDB::add_meal($meal); //the add_meal method inserts the last inserted id into the user object
        
        
        //$_SESSION['meal_id'] = $meal->getId();        
        $_SESSION['meal'] = $meal;
        $_SESSION['names_of_allergens_not_in_meal'] = $selectedAllergens;
        $_SESSION['rating'] = $rating;
        $_SESSION['review'] = $review;
       
        require_once("../restaurant_manager/restaurant_add_form.php");
        break;
    
    default:
        require_once '../view/header.php';
        echo '<h2> controllerChoice: $controllerChoice</h2>';
        echo'<h3> File: user_manager/index.php</h3>';
        require_once '../view/footer.php';
        
}
?>
<?php
require('../model/database.php');
require('../model/meal.php');
require('../model/meal_db.php');
require('../model/allergen.php');
require('../model/allergen_db.php');
require('../model/review_db.php');
require('../model/restaurant_db.php');
require('../model/restaurant.php');
require('../model/review.php');
require('../model/join_table_db.php');
require('../model/dispute.php');
require('../model/dispute_db.php');

        
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

/*the some forms have multiple submit buttons, so the following code uses the 
names of those buttons to manually set the controllerChoice value in those instances */
if(isset($_POST["add_meal_only"])){
    $controllerChoice = "add_meal_only";
}
else if(isset($_POST["redirect_meal_to_restaurant_add_form"])){
    $controllerChoice = "redirect_meal_to_restaurant_add_form";
}
else if(isset($_POST["dispute_not_in_meal"])){
    $controllerChoice = "dispute_not_in_meal";
}
else if(isset($_POST["dispute_in_meal"])){
    $controllerChoice = "dispute_in_meal";
}

switch($controllerChoice) {
    
    case "submit_dispute":
        if(isset($_POST['check_list'])) {
            $allergenNameArray = $_POST['check_list'];
        }
        $meal = $_SESSION['meal'];
        $email = filter_input(INPUT_POST, 'email');
        $explanation = filter_input(INPUT_POST, 'explanation');
        
        foreach($allergenNameArray as $allergenName){
            $allergen = AllergenDB::getAllergenById(AllergenDB::getAllergenIdFromName($allergenName));
            $dispute = new Dispute(0, $allergen->getId(), $meal->getId(), $explanation, $email, null);
            DisputeDb::insertDispute($dispute);
        }
        
        require_once('./dispute_submitted_success.php');
        break;
    
    case "dispute_in_meal":               
        $_SESSION['dispute'] = "inMeal";
        require_once('./dispute_form.php');
        break;
    
    case "dispute_not_in_meal":
        $_SESSION['dispute'] = "notInMeal";
        require_once('./dispute_form.php');
        break;
    
    case "add_meal_only":
        //get allergens selected (these are NOT in the meal)
        $selectedAllergensNotInMeal = array();
            if(!empty($_POST['check_list'])){
            // Loop to store and display values of individual checked checkbox.
                foreach($_POST['check_list'] as $selected){                    
                    $selectedAllergensNotInMeal[]= $selected;
                }
            }                
            
        //get restaurant
        $restaurantId = filter_input(INPUT_POST, 'restaurant');
        $restaurant = RestaurantDB::getRestaurantById($restaurantId);       
        
        //info for meal table
        $mealName = filter_input(INPUT_POST, 'meal_name');
        $isOfficial = false;
        
        //capitalize the words in the name if they aren't already
        $lowerCaseMealName = strtolower($mealName); //first lower case
        $firstLettersCapitalMealName = ucwords($lowerCaseMealName);  //then capitalize the first letters    
        
        //create meal object and add to meal table
        $meal = new Meal(0, $firstLettersCapitalMealName, $restaurantId, $isOfficial, null);   
        MealDB::add_meal($meal);
        
        //info for review table
        $endUserId=1;
        $mealId = $meal->getId();
        $rating = filter_input(INPUT_POST, 'rating');
        $comment = filter_input(INPUT_POST, 'review');
        
        //create a review object and add to review table
        $review = new Review(0, $endUserId, $restaurantId, $mealId, $comment, $rating, null);
        ReviewDB::add_Review($review);
        
        //join table inserts:        
        JoinTableDb::insertMealRestaurantJoinTable($mealId, $restaurantId);        
        insertAllergenMealExclude($selectedAllergensNotInMeal, $mealId);                       
               
        $_SESSION['meal'] = $meal;
        $_SESSION['restaurant'] = $restaurant;
        $_SESSION['names_of_allergens_not_in_meal'] = $selectedAllergensNotInMeal;
        $_SESSION['rating'] = $rating;
        $_SESSION['review'] = $review;
        
        
        require_once("meal_add_success.php");
        break;
    
    case "addSearchCategory":
        require_once("../allergen_manager/allergen_add_form.php");
        break;
    
    case "edit_meal":
        $meal = $_SESSION["meal"];
        
        //if any allergens were selected, put them in an array (string array of names)
         if(isset($_POST['inMealChecklist'])) {
            $allergenNamesInMealArray = $_POST['inMealChecklist'];             
            
            //add each allergen to array if not already there
            $allergenIDsInMealArray = array();            
            foreach($allergenNamesInMealArray as $allergenName){
                $allergen = AllergenDB::getAllergenById(AllergenDB::getAllergenIdFromName($allergenName));
                JoinTableDb::insertAllergenMealJoinTable($allergen->getId(), $meal->getId());                         
            }            
         }
         
         if(isset($_POST['notInMealChecklist'])) {
            $allergenNamesNotInMealArray = $_POST['notInMealChecklist'];             
            
            //add each allergen to array if not already there
            $allergenIDsNotInMealArray = array();            
            foreach($allergenNamesNotInMealArray as $allergenName){
                $allergen = AllergenDB::getAllergenById(AllergenDB::getAllergenIdFromName($allergenName));
                JoinTableDb::insertAllergenMealExclude($allergen->getId(), $meal->getId());                
            }
         }
         
        require_once("meal_detail.php");       
        break;
    
    case "get_meal_details":
        $mealId = filter_input(INPUT_POST, 'meal_id');
        $meal = MealDB::getMealById($mealId);
        $_SESSION['meal'] = $meal;
        
        require_once("meal_detail.php");
        break;
    
    case "rate_meal":
        $rating = filter_input(INPUT_POST, 'rating');
        $comment = filter_input(INPUT_POST, 'review');
        $meal = $_SESSION['meal'];
        $id=0;
        $endUserId=1;
        $mealId = $meal->getId();
        $restaurantId = $meal->getRestaurant_id();
        
        //add to review table
        $review = new Review($id, $endUserId, $restaurantId, $mealId, $comment, $rating, null);
        ReviewDB::add_Review($review);
        
        //get array of all ratings of meal
        $ratingsArray = ReviewDB::getMealRatings($mealId);
        
        $avgRating = getAverageRating($ratingsArray);

        //get updated list of reviews
        $reviewsArray = ReviewDB::getMealReviews($mealId);
        
        $_SESSION['reviewsForMeal'] = $reviewsArray;
        $_SESSION['averageRating'] = $avgRating;
    
        require_once("meal_detail.php");
        break;
    
    case "redirect_to_edit_meal":
        $mealId = filter_input(INPUT_POST, 'meal_id');
        $_SESSION['meal'] = MealDB::getMealById($mealId);        
        require_once("meal_edit_form.php");
        break;
    
     case "redirect_meal_to_restaurant_add_form";
        /*in this case, the user added meal info, but couldn't find the
         * restaurant in the drop-down. This method saves all the necessary meal data to the session,
        then redirects to the restaurant add form. All the DB inserts will
        take place in restaurant_manager/index.php     */
        
        //get the checked allergens and add to an array for mealAllergen table
        $selectedAllergensNotInMeal = array();
            if(!empty($_POST['check_list'])){
            // Loop to store and display values of individual checked checkbox.
                foreach($_POST['check_list'] as $selected){                    
                    $selectedAllergensNotInMeal[]= $selected;
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
               
        $_SESSION['meal'] = $meal;
        $_SESSION['names_of_allergens_not_in_meal'] = $selectedAllergensNotInMeal;
        $_SESSION['rating'] = $rating;
        $_SESSION['review'] = $review;
       
        require_once("../restaurant_manager/restaurant_add_form.php");
        break;
    
    case "searchNewLocation":         
        $searchLocation = filter_input(INPUT_POST, 'search');          
        $allergenIDArray =  $_SESSION['allergenIDArray'];        
                
        getAndSetInSessionMealsAndRestuaraunts($allergenIDArray, $searchLocation);
                        
        require_once('meal_results.php');        
        break;
       
    case "search":    
        $allergenIDArray = array();  
        $searchLocation = filter_input(INPUT_POST, 'search');  
        $findOrAvoidSelected = false;
        
        //get any find boxes checked
        if(isset($_POST['findChecklist'])) {
                    $findArray = $_POST['findChecklist'];
                    
                    //add allergens to avoid to array (find gluten == avoid gluten, wheat, oat)
                    $allergenIDArray = getAllergensFromFindSelected($findArray);
                    
                    $findOrAvoidSelected = true;
                    
                    $_SESSION['findChosen'] = $findArray;
            
        }                            
                        
        //if any allergens were selected, put them in an array (string array of names)
         if(isset($_POST['allergenChecklist'])) {
            $allergenNameArray = $_POST['allergenChecklist'];             
            
            //add each allergen to array if not already there
            //$allergenIDArray = array();            
            foreach($allergenNameArray as $allergenName){
                if(!in_array(AllergenDB::getAllergenIdFromName($allergenName), $allergenIDArray)){
                    array_push($allergenIDArray, AllergenDB::getAllergenIdFromName($allergenName));
                }                
            }
//            getAndSetInSessionMealsAndRestuaraunts($allergenIDArray, $searchLocation);    
            $_SESSION['allergensChosen'] = $allergenNameArray;
            
            $findOrAvoidSelected = true;
         }         
         
         
         
         if($findOrAvoidSelected == false){//if no allergens were chosen, display an appropriate message explaining that, then return a full list of meals and restaurants for 
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
             $_SESSION['meals'] = $meals;
             $_SESSION['restaurants'] = $restaurants;
            }
            else{
                getAndSetInSessionMealsAndRestuaraunts($allergenIDArray, $searchLocation); 
            }
            
            $_SESSION['allergenIDArray'] = $allergenIDArray;
            
        require_once('meal_results.php');
        break;
    
    default:
        require_once '../view/header.php';
        echo '<h2> controllerChoice:'.$controllerChoice.'</h2>';
        echo'<h3> File: user_manager/index.php</h3>';
        require_once '../view/footer.php';
        
}

function getTrimmedIdListAllergens($stringListOfAllergensWithComma){
   
    //trim query so it dosn't have a comma at the beginning 
    $trimmedIdListOfAllergens = substr($stringListOfAllergensWithComma, 1);  
    
    return $trimmedIdListOfAllergens;
}

function getStringListOfAllergensWithCommasForDisplay($allergenIDArray){
    //loop through name id array and add to string for select query
    $stringListOfAllergensWithComma = "";
             foreach($allergenIDArray as $allergenID){
                $stringListOfAllergensWithComma = $stringListOfAllergensWithComma.",".$allergenID;
            }
    
    return $stringListOfAllergensWithComma;
}

function getAndSetInSessionMealsAndRestuaraunts($allergenIDArray, $searchLocation){
    $message = ""; 
    
    if($allergenIDArray != null){
        
    
    
    
    $stringListOfAllergensWithComma = getStringListOfAllergensWithCommasForDisplay($allergenIDArray);
        //trim the string for use in SQL query
        $trimmedIdListOfAllergens = getTrimmedIdListAllergens($stringListOfAllergensWithComma);

       //use trimmed string to query database and return an array of appropriate meals to display
        $mealsWithRepeats = MealDB::getSearchResultsByAllergensAndLocation($trimmedIdListOfAllergens, $searchLocation);
        
        //get the unique meals from the array so there are no repeat listings to display
        $meals = array();
        foreach($mealsWithRepeats as $meal){
        if(!in_array($meal, $meals)){
                     //if the restaurant isn't already in the array, add it
                     array_push($meals, $meal); 
                 }  
        }  
        
        
        
        $restaurants = array();
            foreach($meals as $meal){
              if(!in_array(RestaurantDB::getRestaurantById($meal->getRestaurant_id()), $restaurants)){
                     //if the restaurant isn't already in the array, add it
                     array_push($restaurants, RestaurantDB::getRestaurantById($meal->getRestaurant_id())); 
                 }  
            }  
    }
else{
    $message = "No allergens selected. Here is a full list of meals and restaurants for your location:";
             
             $meals = MealDB::getSearchResultsByLocationOnly($searchLocation);
             
             $restaurants = array();
             foreach($meals as $meal){
                        if(!in_array(RestaurantDB::getRestaurantById($meal->getRestaurant_id()), $restaurants)){
                            //if the restaurant isn't already in the array, add it
                            array_push($restaurants, RestaurantDB::getRestaurantById($meal->getRestaurant_id())); 
                        }              
                }  //end foreach
    
}

            $_SESSION['message'] = $message;           
            $_SESSION['meals'] = $meals;
            $_SESSION['restaurants'] = $restaurants;
}

function getAllergensFromFindSelected($findArray){
    $allergenIDArray = array();
    
    foreach($findArray as $find){
        if($find == "Gluten Free"){
            array_push($allergenIDArray, AllergenDB::getAllergenIdFromName("Gluten"));
            array_push($allergenIDArray, AllergenDB::getAllergenIdFromName("Wheat"));
            array_push($allergenIDArray, AllergenDB::getAllergenIdFromName("Oat"));
        }
        if($find == "Vegetarian"){
            array_push($allergenIDArray, AllergenDB::getAllergenIdFromName("Beef"));
            array_push($allergenIDArray, AllergenDB::getAllergenIdFromName("Chicken"));
            array_push($allergenIDArray, AllergenDB::getAllergenIdFromName("Fish"));
            array_push($allergenIDArray, AllergenDB::getAllergenIdFromName("Pork"));
            array_push($allergenIDArray, AllergenDB::getAllergenIdFromName("Shellfish"));
        }
        if($find == "Vegan"){
            if(!in_array(AllergenDB::getAllergenIdFromName("Beef"), $allergenIDArray)){
                    array_push($allergenIDArray, AllergenDB::getAllergenIdFromName("Beef"));
            }            
            if(!in_array(AllergenDB::getAllergenIdFromName("Chicken"), $allergenIDArray)){
                    array_push($allergenIDArray, AllergenDB::getAllergenIdFromName("Chicken"));
            }
            if(!in_array(AllergenDB::getAllergenIdFromName("Fish"), $allergenIDArray)){
                    array_push($allergenIDArray, AllergenDB::getAllergenIdFromName("Fish"));
            }
            if(!in_array(AllergenDB::getAllergenIdFromName("Pork"), $allergenIDArray)){
                    array_push($allergenIDArray, AllergenDB::getAllergenIdFromName("Pork"));
            }
            if(!in_array(AllergenDB::getAllergenIdFromName("Shellfish"), $allergenIDArray)){
                    array_push($allergenIDArray, AllergenDB::getAllergenIdFromName("Shellfish"));
            }
            
            array_push($allergenIDArray, AllergenDB::getAllergenIdFromName("Egg"));
            array_push($allergenIDArray, AllergenDB::getAllergenIdFromName("Dairy"));
            array_push($allergenIDArray, AllergenDB::getAllergenIdFromName("Lactose"));
            array_push($allergenIDArray, AllergenDB::getAllergenIdFromName("Milk"));
        }        
    }//end foreach
    
    return $allergenIDArray;
}

function getAverageRating($ratingsArray){
    $avgRating = null;
    if(count($ratingsArray) > 0){
            $avgRating = round((float)array_sum($ratingsArray) / count($ratingsArray), 1);
        }  
        
        return $avgRating;
}

function insertAllergenMealExclude($selectedAllergensNotInMeal, $mealId){
        
        foreach($selectedAllergensNotInMeal as $allergenName){
            JoinTableDb::insertAllergenMealExclude(AllergenDB::getAllergenIdFromName($allergenName), $mealId);
        }
}

?>
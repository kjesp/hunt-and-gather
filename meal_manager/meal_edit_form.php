  <?php 

if(session_id() == ''){
    $lifetime = 60 * 60 * 24 * 14;    //two weeks
    session_set_cookie_params($lifetime, '/');
    session_start();    
}


  
require_once('../model/database.php');    
require_once('../model/restaurant_db.php');
require_once('../model/restaurant.php');
require_once('../model/allergen_db.php');
require_once('../model/allergen.php');

$meal = $_SESSION['meal']; 
    //get names of allergens in meal and allergens not in meal for display
        $mealId = $meal->getId(); 
        
        $allAllergensList = AllergenDB::getAllergenList();
        
        $allergenNamesInMeal = AllergenDB::getAllergenNamesForMeal($mealId);
        $allergenNamesNotInMeal = AllergenDB::getAllergenNamesExcludedFromMeal($mealId);
        
        $allergenIDsInMeal = AllergenDB::getAllergenIDsForMeal($mealId);
        //get a list of all allergens to display, but don't include the ones that were have already been included in the meal
        $fullAllergenListMinusAllergensInMeal = array();        
        foreach($allAllergensList as $allergen){ 
            if(!in_array($allergen->getId(), $allergenIDsInMeal)){
            array_push($fullAllergenListMinusAllergensInMeal, $allergen);                                
            }
        }
        //get a list of all allergens to display, but don't include the ones that were have already been excluded from the meal
        $allergendIDsNotInMeal = AllergenDB::getAllergenIDsExcludedFromMeal($mealId);  
        $fullAllergenListMinusAllergensExcludedFromMeal = array();        
        foreach($allAllergensList as $allergen){ 
            if(!in_array($allergen->getId(), $allergendIDsNotInMeal)){
            array_push($fullAllergenListMinusAllergensExcludedFromMeal, $allergen);                                
            }
        }
        
        
                
        //get array of all ratings of meal
        $ratingsArray = ReviewDB::getMealRatings($mealId);
        $averageRating = getAverageRating($ratingsArray);
                
        //get reviews for meal, ordered by newest to oldest
        $reviews = ReviewDB::getMealReviews($mealId);

require_once '../view/header.php';?>     


<h1>Edit Meal</h1>

<form id="edit_meal" action="meal_manager/index.php" method="post">
        
<div class="form-row">
        <label>Meal Name:</label>        
        <input disabled type="text" value="<?php echo $meal->getName(); ?>"><br>        
</div>        
    
       
    <fieldset class="group">         
            <legend>This meal does NOT contain:  
                        <?php  $stringListOfAllergens = "";
                            if($allergenNamesNotInMeal == null || $allergenNamesNotInMeal == ""): ?>
                        <?php else: ?>     
                            <?php foreach($allergenNamesNotInMeal as $a) : ?>
                             <?php $stringListOfAllergens = $stringListOfAllergens.$a.", "; ?>         
                        <?php endforeach; ?> 
                        <?php echo substr_replace($stringListOfAllergens ,"",-2) ?>
                    <?php endif; ?> 
            </legend> 
            <h3>Just choose what matters to you - others can adjust this meal too.</h3>
            <ul class="checkbox list-unstyled">                        
                 <?php foreach ($fullAllergenListMinusAllergensExcludedFromMeal as $al) : ?>                
                <li><input type="checkbox" name="check_list[]" value="<?php echo $al->getName(); ?>" value="" />
                    <label for=""><?php echo $al->getName(); ?></label></li>                             
                <?php endforeach; ?>
            </ul>
    </fieldset>      
    
    <fieldset class="group">         
            <legend>This meal DOES contain:  
                        <?php  $stringListOfAllergens = "";
                            if($allergenNamesInMeal == null || $allergenNamesInMeal == ""): ?>
                        <?php else: ?>     
                            <?php foreach($allergenNamesInMeal as $a) : ?>
                             <?php $stringListOfAllergens = $stringListOfAllergens.$a.", "; ?>         
                        <?php endforeach; ?> 
                        <?php echo substr_replace($stringListOfAllergens ,"",-2) ?>
                    <?php endif; ?> 
            </legend>  
            <h3>Just choose what matters to you - others can adjust this meal too.</h3>
            <ul class="checkbox list-unstyled">                        
                 <?php foreach ($fullAllergenListMinusAllergensInMeal as $al) : ?>                
                <li><input type="checkbox" name="check_list[]" value="<?php echo $al->getName(); ?>" value="" />
                    <label for=""><?php echo $al->getName(); ?></label></li>                             
                <?php endforeach; ?>
            </ul>
    </fieldset> 
    
    
          
              
        <input class="btn btn-green" type="submit" name="edit_meal" value="Submit Changes" id="submit_meal_button"><br>  
        </form>  
    
    <?php require_once '../view/footer.php';?> 

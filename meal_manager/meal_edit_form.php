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
        $allergendIDsNotInMeal = AllergenDB::getAllergenIDsExcludedFromMeal($mealId);        

    //get a list of all allergens to display, but don't include the ones that were have already been included in or excluded from meal
        $displayList = array();        
        
        foreach($allAllergensList as $allergen){ 
            $inMeal = isAllergenInMeal($allergen, $allergenIDsInMeal);
            $excludedFromMeal = isAllergenExcludedFromMeal($allergen, $allergendIDsNotInMeal);
            $inDisplayListAlready = isInDisplayListAlready($allergen, $displayList);
            //if allergen is not included or excluded, and not in list already, add it
            if($inMeal || $excludedFromMeal){
                //nothing happens. I don't like this empty if, but i keep having errors when I try to reverse it
            }
            else if(!$inDisplayListAlready){
                array_push($displayList, $allergen);
            }            
        }                   
        
        function isInDisplayListAlready($allergen, $displayList){
            $isInDisplayList = false;
            
            if(in_array($allergen, $displayList)){
                $isInDisplayList = true;
            }
            return $isInDisplayList;
        }        
        
        function isAllergenInMeal($allergen, $allergenIDsInMeal){
            $inMeal = false;
            
            if(in_array($allergen->getId(), $allergenIDsInMeal)){
                $inMeal = true;
            }
            return $inMeal;            
        }
        
        function isAllergenExcludedFromMeal($allergen, $allergendIDsNotInMeal){
            $excludedFromMeal = false;
             if(in_array($allergen->getId(), $allergendIDsNotInMeal)){
                 $excludedFromMeal = true;
             }
            return $excludedFromMeal;            
        }        

require_once '../view/header.php';?>     


<h1>Edit Meal</h1>

<form id="edit_meal" action="meal_manager/index.php" method="post">
        
<div class="form-row">
        <label>Meal Name:</label>        
        <input disabled type="text" value="<?php echo $meal->getName(); ?>"><br>        
</div>        
    
       
    <fieldset class="group">         
        <h1>This meal already <strong>does NOT</strong> contain:  
                        <?php  $stringListOfAllergens = "";
                            if($allergenNamesNotInMeal == null || $allergenNamesNotInMeal == "" || $allergenNamesNotInMeal == 0): ?>
                        <?php else: ?>     
                            <?php foreach($allergenNamesNotInMeal as $a) : ?>
                             <?php $stringListOfAllergens = $stringListOfAllergens.$a.", "; ?>         
                        <?php endforeach; ?> 
                        <?php echo substr_replace($stringListOfAllergens ,"",-2) ?>
                    <?php endif; ?> 
            </h1>               
        
        <h3>Do you disagree?</h3>
        <input class="btn btn-danger" type="submit" name="dispute_not_in_meal" value="Dispute a Meal" id="submit_meal_button"><br> 
        <h3>What else is <strong>not</strong> in this meal? (Just choose what matters to you - others can adjust this meal too.)</h3>
            <ul class="checkbox list-unstyled">                        
                 <?php foreach ($displayList as $al) : ?>                
                <li><input type="checkbox" name="notInMealChecklist[]" value="<?php echo $al->getName(); ?>" value="" />
                    <label for=""><?php echo $al->getName(); ?></label></li>                             
                <?php endforeach; ?>
            </ul>
           
    </fieldset>      
    
    <fieldset class="group">         
        <h1>This <strong>already</strong> contains:  
                        <?php  $stringListOfAllergens = "";
                            if($allergenNamesInMeal == null || $allergenNamesInMeal == "" || $allergenNamesInMeal == 0): ?>
                        <?php else: ?>     
                            <?php foreach($allergenNamesInMeal as $a) : ?>
                             <?php $stringListOfAllergens = $stringListOfAllergens.$a.", "; ?>         
                        <?php endforeach; ?> 
                        <?php echo substr_replace($stringListOfAllergens ,"",-2) ?>
                    <?php endif; ?> 
            </h1>  
        <h3>Do you disagree?</h3>
        <input class="btn btn-danger" type="submit" name="dispute_in_meal" value="Dispute a Meal" id="submit_meal_button"><br> 
            <h3>What else <strong>is</strong> in this meal? Just choose what matters to you - others can adjust this meal too.</h3>
            <ul class="checkbox list-unstyled">                        
                 <?php foreach ($displayList as $al) : ?>                
                <li><input type="checkbox" name="inMealChecklist[]" value="<?php echo $al->getName(); ?>" value="" />
                    <label for=""><?php echo $al->getName(); ?></label></li>                             
                <?php endforeach; ?>
            </ul>
    </fieldset> 
              
        <input class="btn btn-green" type="submit" name="edit_meal" value="Submit Changes" id="submit_meal_button"><br>  
        <input hidden name="controllerRequest" value="edit_meal">
        </form>  
    
    <?php require_once '../view/footer.php';?> 

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
$mealId = $meal->getId();
$disputeType = $_SESSION['dispute'];
$allergensArray = array();


//get names of allergens in meal or allergens not in meal for display
if($disputeType == "inMeal"){
    $disputeTypeMessage = "being in";
    $allergenIDsArray = AllergenDB::getAllergenIDsForMeal($mealId);
    foreach($allergenIDsArray as $allergenID){        
        array_push($allergensArray, AllergenDB::getAllergenById($allergenID));
    }
    
}
else{
    $disputeTypeMessage = "not in";
    $allergenIDsArray = AllergenDB::getAllergenIDsExcludedFromMeal($mealId); 
    foreach($allergenIDsArray as $allergenID){        
        array_push($allergensArray, AllergenDB::getAllergenById($allergenID));
    }
}


require_once '../view/header.php';?>     


<h1>Dispute a Meal</h1>

<label>Meal Name:</label>        
<input disabled type="text" value="<?php echo $meal->getName(); ?>"><br> 
<form id="submit_dispute" action="meal_manager/index.php" onsubmit="return CheckForm()" method="post">
<h3>These allergens are listed as <strong><?php echo $disputeTypeMessage ?></strong> this meal:</h3>
<fieldset>
    <ul class="checkbox list-unstyled">                        
                 <?php foreach ($allergensArray as $al) : ?>                
                <li><input type="checkbox" name="check_list[]" value="<?php echo $al->getName(); ?>" value="" />
                    <label for=""><?php echo $al->getName(); ?></label></li>                             
                <?php endforeach; ?>
    </ul>
</fieldset>
  <div class="form-group">
    <label for="explanation">Please check the allergen/s you wish to dispute and explain the issue:</label>
    <textarea required class="form-control" id="explanation" name="explanation" rows="3"></textarea>
  </div>
<input class="btn btn-green" type="submit" name="submit_dispute" value="Submit Dispute" id="submit_dispute_button"><br>  
        <input hidden name="controllerRequest" value="submit_dispute">
        
        <h3>If you would like to be contacted about this submission, please enter your email:</h3>
        <input type="email" name="email">

</form>

    
    <?php require_once '../view/footer.php';?> 

  <?php 

if(session_id() == ''){
    $lifetime = 60 * 60 * 24 * 14;    //two weeks
    session_set_cookie_params($lifetime, '/');
    session_start();    
}

require('../model/allergen.php');  
require('../model/database.php');    
require('../model/allergen_db.php');
require('../model/restaurant_db.php');
require('../model/restaurant.php');


$allergensArray = AllergenDB::getAllergenList();
$restaurantsArray = RestaurantDB::getRestaurantList();

require_once '../view/header.php';?>     

<h1>Add a Meal</h1>


<form id="add_meal_only" action="meal_manager/index.php" method="post">
        
<div class="form-row">
        <label>Meal Name:</label>        
        <input required type="text" name="meal_name"><br>        
</div>        
    
    <p>I'd rather this be a select here with 
                 multiline selection (without holding control) possible...JavaScript?</p>
     
    
    <fieldset class="group">         
            <legend>This meal does NOT contain:</legend> 
            <h3>Just choose what matters to you - others can adjust this meal too.</h3>
            <ul class="checkbox">                        
                 <?php foreach ($allergensArray as $al) : ?>                
                <li><input type="checkbox" name="check_list[]" value="<?php echo $al->getName(); ?>" value="" />
                    <label for=""><?php echo $al->getName(); ?></label></li>                             
                <?php endforeach; ?>
    </fieldset>                     
    
 <div class="form-row">
    <label>Restaurant:</label>
    <select name="restaurant">
        <?php foreach ($restaurantsArray as $rest) : ?>  
        <option name="<?php echo $rest->getName(); ?>"><?php echo $rest->getName(); ?></option>
        <?php endforeach; ?>
    </select>
</div>
        <input type="submit" name="redirect_meal_to_restaurant_add_form" value="Don't see the restaurant listed?" id="button"><br>        
                       
        <div class="form-row">
        <label>What would you rate this meal?:</label>
        <select name="rating">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select><br>
        </div>
        
        <div class="form-row">
        <label>Meal Review:</label>
        <input type="text" name="review" ><br>
        </div>
              
        <input type="submit" name="full_meal_submission" value="Add Meal" id="button"><br>  
        </form>  
    
    <?php require_once '../view/footer.php';?> 

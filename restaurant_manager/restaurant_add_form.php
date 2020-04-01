  <?php 
if(session_id() == ''){
    $lifetime = 60 * 60 * 24 * 14;    //two weeks
    session_set_cookie_params($lifetime, '/');
    session_start();    
}
    

require_once '../view/header.php';
require_once '../model/meal.php';

$meal = $_SESSION['meal']; 
?>     

<h1>Add a Restaurant</h1>

<h2>Meal Name: <?php echo $meal->getName()?></h2>

<form action="restaurant_manager/index.php" method="post">
<input type="hidden" name="meal_name" value="<?php echo $meal->getName()?>">

    
         <div class="form-row">
        <label>Restaurant Name:</label>
        <input type="text" name="name" ><br>
        </div>
         <div class="form-row">
        <label>City:</label>
        <input type="text" name="city"><br>
        </div>
         <div class="form-row">
        <label>State:</label>
        <input type="text" name="state" ><br>
        </div>
         <div class="form-row">
        <label>Zip:</label>
        <input type="text" name="zip" ><br>
        </div>
       
              
        <input type="submit" value="Add Restaurant" id="button"><br>  
        
        <input type="hidden" name="controllerRequest" 
                value="submit_add_restaurant">
    </form>

    
    <?php require_once '../view/footer.php';?> 

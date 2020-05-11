  <?php 

if(session_id() == ''){
    $lifetime = 60 * 60 * 24 * 14;    //two weeks
    session_set_cookie_params($lifetime, '/');
    session_start();    
}
require_once '../model/restaurant.php';

$meal = $_SESSION['meal'];
$restaurant = $_SESSION['restaurant'];
$allergensNotInMeal = $_SESSION['names_of_allergens_not_in_meal'];
?>      

<?php require_once '../view/header.php';?>        
<h1><?php echo $meal->getName()?> at <?php echo $restaurant->getName()?> has been added!</h1>

<h2>This meal is free of the following allergens:</h2>
<?php foreach ($allergensNotInMeal as $al) : ?>   
    <label for=""><?php echo $al; ?></label><br>
    <?php endforeach; ?>

    <form action="meal_manager/index.php" method="post">
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
            <input required type="text" name="review" ><br>
            </div>         

            <input type="hidden" name="controllerRequest" value="rate_meal">  
            <input type="submit" value="Submit" id="button"><br>            
</form>
<br>
<a href="./index.php">Back to Home</a>  

    
    <?php require_once '../view/footer.php';?> 

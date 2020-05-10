  <?php 

if(session_id() == ''){
    $lifetime = 60 * 60 * 24 * 14;    //two weeks
    session_set_cookie_params($lifetime, '/');
    session_start();    
}

$meal = $_SESSION['meal']; 
$allergensInMeal = $_SESSION['allergensInMeal'];
$averageRating = $_SESSION['averageRating'];
$reviews = $_SESSION['reviewsForMeal'];
?>
      

<?php require_once '../view/header.php';?>     

<h2>Meal Details: <?php echo $meal->getName()?> from  <?php 
                    //use restaurant id to return restaurant name  
                    require_once '../model/restaurant_db.php';         //display name
                    $restaurantName = RestaurantDB::getNameUsingId($meal->getRestaurant_id());           
                    echo $restaurantName;  ?></h2>

<h2>This meal contains the following allergens:</h2>
    <?php foreach ($allergensInMeal as $al) : ?>   
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
         <input type="submit" name="rate_meal" value="Rate this Meal" id="button"><br>  
        </form> 

    
<h2>Average Rating (1-5):</h2>
<label>
<?php if($averageRating == null): ?>
  <?php echo "This meal has not been rated yet."; ?>
      <?php else: ?>
  <?php echo $averageRating; ?> 
<?php endif; ?>
</label>

<h2>Reviews</h2><br>

<table class="table">
    <?php if($reviews == null): ?>
    <th><?php echo "This meal has not been reviewed yet."; ?></th>
    <?php else: ?>

  <?php foreach ($reviews as $r) : ?>   
<tr><td><?php echo $r; ?></td></tr>
    <?php endforeach; ?>
    
<?php endif; ?>    
</table>
    
    <?php require_once '../view/footer.php';?> 

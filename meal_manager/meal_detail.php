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

    
<h2>Average Rating (1-5):</h2>
<label>
<?php if($averageRating == null): ?>
  <?php echo "This meal has not been rated yet. // add link to rate?"; ?>

<?php else: ?>
  <?php echo $averageRating; ?> 
<?php endif; ?>
</label>

<h2>Reviews</h2><br>

    <?php if($reviews == null): ?>
<label><?php echo "This meal has not been reviewed yet. // add link to review?"; ?></label>
    <?php else: ?>
<ul>
  <?php foreach ($reviews as $r) : ?>   
    <li><?php echo $r; ?></li><br>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>    

    
    <?php require_once '../view/footer.php';?> 

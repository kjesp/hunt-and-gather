  <?php 

if(session_id() == ''){
    $lifetime = 60 * 60 * 24 * 14;    //two weeks
    session_set_cookie_params($lifetime, '/');
    session_start();    
}
require_once '../model/restaurant.php';

$meal = $_SESSION['meal'];
        //get names of allergens in meal and allergens not in meal for display
        $allergenNamesInMeal = AllergenDB::getAllergenNamesForMeal($mealId);
        $allergenNamesNotInMeal = AllergenDB::getAllergenNamesExcludedFromMeal($mealId);
        $allergenIDsInMeal = AllergenDB::getAllergenIDsForMeal($mealId);
        $allergendIDsNotInMeal = AllergenDB::getAllergenIDsExcludedFromMeal($mealId);
                
        //get array of all ratings of meal
        $ratingsArray = ReviewDB::getMealRatings($mealId);
        $averageRating = getAverageRating($ratingsArray);
                
        //get reviews for meal, ordered by newest to oldest
        $reviews = ReviewDB::getMealReviews($mealId);

?>      

<?php require_once '../view/header.php';?>        
<h1><?php echo $meal->getName()?> at <?php echo $restaurant->getName()?> has been added!</h1>

<h2>This meal <strong>contains</strong> these allergens:</h2>
    <?php foreach ($allergenNamesInMeal as $al) : ?>   
    <label for=""><?php echo $al; ?></label><br>
    <?php endforeach; ?>
    <br>
    <h2>and <strong>is free of </strong> these allergens:</h2>
    <?php foreach ($allergenNamesNotInMeal as $al) : ?>   
    <label for=""><?php echo $al; ?></label><br>
    <?php endforeach; ?>
    
<a href="./index.php">Back to Home</a>  

    
    <?php require_once '../view/footer.php';?> 

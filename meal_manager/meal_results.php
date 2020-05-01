  <?php 
   
if(session_id() == ''){
    $lifetime = 60 * 60 * 24 * 14;    //two weeks
    session_set_cookie_params($lifetime, '/');
    session_start();    
}


$meals = $_SESSION['meals'];
$restaurants = $_SESSION['restaurants'];
$message = $_SESSION['message'];
$allergensChosen = $_SESSION['allergensChosen'];

//if($message != ""){
//    $allergensChosen = $_SESSION['allergensChosen'];
//}

 require_once '../view/header.php'; ?> 


<h1>Results for Search ( 
    <!-- if message is not blank, display it. (no allergens were selected)-->
        <?php  $stringListOfAllergensChosen = "";
        if($message != ""): ?>
            <?php echo $message ?>
    <?php else: ?>    
    <!--if the message is blank, then allergens were selected. the following code displays them with
        commas following, except for the final one which has no comma -->   
        <?php foreach($allergensChosen as $a) : ?>
         <?php $stringListOfAllergensChosen = $stringListOfAllergensChosen.$a.", "; ?>         
    <?php endforeach; ?> 
    <?php echo substr_replace($stringListOfAllergensChosen ,"",-2) ?>
<?php endif; ?>   
)</h1>
    
<input type="text" name=zip_or_city_label">
<select name="sort">
    <option>Sort</option>
    <option>Distance</option>
    <option>Rating</option>
</select>

<p>this dropdown doesn't do anything yet. Javascript instead??</p>
<select name="view">
    <option>Meals</option>
    <option>Restaurants</option>
</select>

    <table class="mealTable">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Restaurant</th>
            <th>Verified?</th>
            <th>Date Added</th>
            <th></th>
        </tr>
                
        <?php foreach ($meals as $meal) : ?>
        
            <tr>                            
                <td class="right" ><?php echo $meal->getId(); ?></td>
                <td class="right"><?php echo $meal->getName(); ?></td>
                <td class="right">
                    <?php 
                    //use restaurant id to return restaurant name  
                    require_once '../model/restaurant_db.php';         //display name
                    $restaurantName = RestaurantDB::getNameUsingId($meal->getRestaurant_id());
                            
                    
                    echo $restaurantName; 
                    
                    ?></td>
                
                <td class="right">
                    <?php                    
                    $officialInt = $meal->getIs_official();
                    $isOfficialMessage = "Verified";
                    $isNotOfficialMessage = "Unverified";
                    if($officialInt == 1)
                        echo $isOfficialMessage;                    
                    else
                        echo $isNotOfficialMessage;?></td>
                <td class="right">
                    <?php
                    $original_date = $meal->getDate_added();

                    // Creating timestamp from given date
                    $timestamp = strtotime($original_date);

                    // Creating new date format from that timestamp
                    $new_date = date("m-d-Y", $timestamp);
                    echo $new_date; // Outputs: 31-03-2019
                    ?>
                </td>
                
                
                <td><form action="meal_manager/index.php" method="post">
                        <input type="hidden" name="meal_id"
                               value="<?php echo $meal->getId(); ?>">
                        <input type="hidden" name="controllerRequest" 
                value="get_meal_details">
                        <input type="submit" value="Details">                        
                    </form></td>
                           
            </tr>
            <?php endforeach; ?>
    
    </table>


<br>
<h2>Restaurants</h2>

<table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>City</th>
            <th>State</th>
            <th></th>
        </tr>
                
        <?php 
        //require_once '../model/restaurant_db.php'; 
        //require_once '../model/restaurant.php'; 
        //$restaurants = RestaurantDB::getRestaurantList();
        foreach ($restaurants as $restaurant) : ?>
        
            <tr>                            
                <td class="right" ><?php echo $restaurant->getId(); ?></td>
                <td class="right"><?php echo $restaurant->getName(); ?></td>
                <td class="right"><?php echo $restaurant->getCity(); ?></td>
                <td class="right"><?php echo $restaurant->getState(); ?></td>
                
                <td><form action="restaurant_manager/index.php" method="post">
                        <input type="hidden" name="restaurant_id"
                               value="<?php echo $restaurant->getId(); ?>">
                        <input type="hidden" name="controllerRequest" 
                value="get_meals_for_restaurant_by_id">
                        <input type="submit" value="See Meals">                        
                    </form></td>
                           
            </tr>
            <?php endforeach; ?>
    
    </table>

<h3>Know something we don't? Help other users, and add it!</h3>

<a href="./meal_manager/meal_add_form.php">Add a Meal</a> 
<br>
<hr>

<a href="./meal_manager/meal_detail.php">Sample Meal</a>
<a href="./restaurant_manager/restaurant_detail.php">Sample Restaurant</a>


   


   
    
    <?php require_once '../view/footer.php';?> 

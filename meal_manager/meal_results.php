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
$findChosen = $_SESSION['findChosen'];

 require_once '../view/header.php'; ?> 

<form action="meal_manager/index.php" method="post">
    <label>Search a different location:</label>
    <input placeholder="City or Zip" required type="text" name="search">   
    <input type="submit" value="Search" class="button"><br>            
    <input type="hidden" name="controllerRequest" value="searchNewLocation"> 
</form>


<h1>Results for Search (
     
    <!-- if message is not blank, display it. (no allergens were selected)-->
        <?php  $stringListOfAllergensChosen = "";
        if($allergensChosen == null || $allergensChosen == ""): ?>
    <?php else: ?>    
    <!--if the message is blank, then allergens were selected. the following code displays them with
        commas following, except for the final one which has no comma -->   
    <?php echo "Avoid:" ?>
        <?php foreach($allergensChosen as $a) : ?>
         <?php $stringListOfAllergensChosen = $stringListOfAllergensChosen.$a.", "; ?>         
    <?php endforeach; ?> 
    <?php echo substr_replace($stringListOfAllergensChosen ,"",-2) ?>
<?php endif; ?>   
    
    
    
 
 <?php  $stringListOfFindChosen = "";
        if($findChosen == null || $findChosen == ""): ?>
    <?php else: ?>    
    <!--if the message is blank, then allergens were selected. the following code displays them with
        commas following, except for the final one which has no comma -->  
    <?php echo " | Find:" ?>
        <?php foreach($findChosen as $f) : ?>
         <?php $stringListOfFindChosen = $stringListOfFindChosen.$f.", "; ?>         
    <?php endforeach; ?> 
    <?php echo substr_replace($stringListOfFindChosen ,"",-2) ?>
<?php endif; ?> )</h1>
    
<select id="view_meal_or_rest" name="view">
    <option>Meals</option>
    <option>Restaurants</option>
</select>

<div id="meal_div">
<h2>Meals</h2>

    <table class="table">
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
                    require_once '../model/restaurant_db.php';         
                    //display name
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
                        <input class="btn btn-green" type="submit" value="Details">                        
                    </form></td>
                           
            </tr>
            <?php endforeach; ?>
    
    </table>
</div>


<div id="rest_div">
<h2>Restaurants</h2>

<table class="table">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>City</th>
            <th>State</th>
            <th>Zip</th>
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
                <td class="right"><?php echo $restaurant->getZip(); ?></td>
                
                <td><form action="restaurant_manager/index.php" method="post">
                        <input type="hidden" name="restaurant_id"
                               value="<?php echo $restaurant->getId(); ?>">
                        <input type="hidden" name="controllerRequest" 
                value="get_meals_for_restaurant_by_id">
                        <input class="btn btn-green" type="submit" value="See Meals">                        
                    </form></td>
                           
            </tr>
            <?php endforeach; ?>
    
    </table>
</div>

<h3>Know something we don't? Help other users, and add it!</h3>

<a class="btn btn-green" href="./meal_manager/meal_add_form.php">Add a Meal</a> 
<br>  
    
    <?php require_once '../view/footer.php';?> 

  <?php 

if(session_id() == ''){
    $lifetime = 60 * 60 * 24 * 14;    //two weeks
    session_set_cookie_params($lifetime, '/');
    session_start();    
}
?>
      

<?php require_once '../view/header.php';?>     

<h1>Results</h1>

<label>All results for</label>
<input type="text" name=zip_or_city_label">
<select name="sort">
    <option>Sort</option>
    <option>Distance</option>
    <option>Rating</option>
</select>

<p>Know something we don't? Help other users, and add it!</p>

<a href="./meal_manager/meal_add_form.php">Add a Meal</a> 
<br>
<hr>

<p>I'll have a toggle so people can decide whether to view meals or restaurants. This means JavaScript. My favorite...</p>

<a href="./meal_manager/meal_detail.php">Sample Meal</a>
<a href="./restaurant_manager/restaurant_detail.php">Sample Restaurant</a>


   


   
    
    <?php require_once '../view/footer.php';?> 

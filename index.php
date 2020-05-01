<?php 
    if(session_id() == ''){
    $lifetime = 60 * 60 * 24 * 14;    //two weeks
    session_set_cookie_params($lifetime, '/');
    session_start();    
}
require('model/allergen.php');  
require('model/database.php');    
require('model/allergen_db.php');

    
$allergensArray = AllergenDB::getAllergenList();

require_once 'view/header.php';?>  

<p>commented out here - user name should appear when logged in</p>
<!--  <p><?php echo $userID; ?></p>-->

<h1>Hunt | Gather</h1>

<h2>Home Page</h2>
    <form action="meal_manager/index.php" method="post">
    <label>Search by zip code:</label>
    <input required type="text" name="search">   
    <br>
    <fieldset class="group"> 
        <legend>Find:</legend> 
            <ul class="checkbox"> 
                <li><input type="checkbox" id="gf" value="Gluten Free" /><label for="gf">Gluten Free</label></li>
                <li><input type="checkbox" id="vegetarian" value="Vegetarian" /><label for="vegetarian">Vegetarian</label></li>
                <li><input type="checkbox" id="local" value="Local" /><label for="local">Local</label></li>
                <li><input type="checkbox" id="vegan" value="Vegan" /><label for="vegan">Vegan</label></li>
                <li><input type="checkbox" id="raw" value="Raw" /><label for="raw">Raw</label></li>
            </ul> 
    </fieldset> 
    <br>
    <br>
    <p>address the issues i'm going to run into by listing things like 'dairy' and 'milk' separately...maybe just that dairy includes milk but not vice versa</p>
    <fieldset class="group"> 
            <legend>Avoid:</legend> 
            <ul class="checkbox">        
                
                 <?php foreach ($allergensArray as $al) : ?>                
                    <li><input type="checkbox" name="allergenChecklist[]" value="<?php echo $al->getName(); ?>"  />
                    <label for=""><?php echo $al->getName(); ?></label></li>                             
                <?php endforeach; ?>
    </fieldset> 
  
    
    <br>
    <input type="submit" value="Search" class="button"><br>            
    <input type="hidden" name="controllerRequest" value="search">     
</form>


<form action="meal_manager/index.php" method="post">
    <h3>Don't see the food you're looking for?</h3>
    <input type="submit" value="Add a Search Category" class="button">
    <input type="hidden" name="controllerRequest" value="addSearchCategory">  
</form>

    <?php require_once 'view/footer.php';?> 
   





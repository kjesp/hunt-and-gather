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
$findArray = array(
    'Gluten Free',
    'Vegetarian',
    'Vegan'    
);

require_once 'view/header.php';?>  

<div class="container-fluid">
    
<!--  <p><?php echo $userID; ?></p>-->

<h1>Hunt | Gather</h1>

    <form action="meal_manager/index.php" method="post">
    <label>Search by location:</label>
    <input placeholder="City or Zip" required type="text" name="search">   
    <br><br>
    
    <div class="container-fluid">
          <div class="row">
                <div class="col-6 col-md-4">
                    
                    <fieldset class="group"> 
                         <legend>Find:</legend> 
                         <ul class="checkbox">        

                              <?php foreach ($findArray as $find) : ?>                
                                 <li><input type="checkbox" name="findChecklist[]" value="<?php echo $find; ?>"  />
                                 <label for=""><?php echo $find; ?></label></li>                             
                             <?php endforeach; ?>
                    </fieldset> 
                </div>
              
                <div class="col-6">
                    <fieldset class="group"> 
                            <legend>Avoid:</legend> 
                            <ul class="checkbox">        

                                 <?php foreach ($allergensArray as $al) : ?>                
                                    <li><input type="checkbox" name="allergenChecklist[]" value="<?php echo $al->getName(); ?>"  />
                                    <label for=""><?php echo $al->getName(); ?></label></li>                             
                                <?php endforeach; ?>
                    </fieldset> 
    
                </div>
          </div>
    </div>
              
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
   
</div>




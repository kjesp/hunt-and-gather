  <?php 

if(session_id() == ''){
    $lifetime = 60 * 60 * 24 * 14;    //two weeks
    session_set_cookie_params($lifetime, '/');
    session_start();    
}
?>
      

<?php require_once '../view/header.php';?>     

<h1>Add Category Request</h1>
<form action="allergen_manager/index.php" method="post">
<h3>What food would you like us to add?</h3>

<label>Food/Ingredient Name:</label>
<input type='text'name='allergen_requested'>

<input type="submit" value="Submit" class="button">
<input type="hidden" name="controllerRequest" value="allergen_add_submit">  
</form>
   
   
    
    <?php require_once '../view/footer.php';?> 

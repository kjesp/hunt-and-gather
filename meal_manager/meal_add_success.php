  <?php 

if(session_id() == ''){
    $lifetime = 60 * 60 * 24 * 14;    //two weeks
    session_set_cookie_params($lifetime, '/');
    session_start();    
}
?>      

<?php require_once '../view/header.php';?>        
<h1>[Meal] at [Restaurant] has been added!</h1>
        
<a href="./index.php">Back to Home</a>  

    
    <?php require_once '../view/footer.php';?> 

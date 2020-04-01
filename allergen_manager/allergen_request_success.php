  <?php 

if(session_id() == ''){
    $lifetime = 60 * 60 * 24 * 14;    //two weeks
    session_set_cookie_params($lifetime, '/');
    session_start();    
}
?>      

<?php require_once '../view/header.php';?>        
<h1>We have received your request. Please allow 5-7 business days for us to review this food. Thank you for contributing to the database 
and helping other folks Hunt and Gather!</h1>
          
<a href="./index.php">Back to Home</a>  

    
    <?php require_once '../view/footer.php';?> 

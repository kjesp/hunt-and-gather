  <?php 

if(session_id() == ''){
    $lifetime = 60 * 60 * 24 * 14;    //two weeks
    session_set_cookie_params($lifetime, '/');
    session_start();    
}
require_once '../model/restaurant.php';
require_once '../view/header.php';?>        

<h2>Your dispute has been submitted. Please allow 5-7 days for review.</h2>
    
<a href="./index.php">Back to Home</a>  

    
    <?php require_once '../view/footer.php';?> 

  <?php 

if(session_id() == ''){
    $lifetime = 60 * 60 * 24 * 14;    //two weeks
    session_set_cookie_params($lifetime, '/');
    session_start();    
}
?>
      

<?php require_once '../view/header.php';?>     

<h1>Meal Detail</h1>

<p>Maybe set this page up like the error message tag, so it fills in the 
info it gets from the controller.</p>

    
    <?php require_once '../view/footer.php';?> 

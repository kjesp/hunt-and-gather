<?php 
if(session_id() == ''){
    $lifetime = 60 * 60 * 24 * 14;    //two weeks
    session_set_cookie_params($lifetime, '/');
    session_start();     
}
?>
<?php require_once '../view/header.php';?>
 <main>
     <h1>Check your email to reset your password.</h1>     
      
     <a href="./index.php">Back to Home</a>          
         
    </main>
    <?php require_once '../view/footer.php';?> 
    



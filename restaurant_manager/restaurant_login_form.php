<?php 
if(session_id() == ''){
    $lifetime = 60 * 60 * 24 * 14;    //two weeks
    session_set_cookie_params($lifetime, '/');
    session_start();     
}
?>
<?php require_once '../view/header.php';?>
    <h1>Restaurant login form</h1>
    <?php require_once '../view/footer.php';?> 
    



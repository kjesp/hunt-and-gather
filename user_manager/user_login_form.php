<?php 
if(session_id() == ''){
    $lifetime = 60 * 60 * 24 * 14;    //two weeks
    session_set_cookie_params($lifetime, '/');
    session_start();     
}
?>
<?php require_once '../view/header.php';?>
 <main>
     <h1>User Login Page</h1>
     
     <h3>Please log in:</h3>
     
     <?php echo $errorMessage?>
    
     <form action="index.php" method="post">
        <div class="form-row">
        <label>Email:</label>
        <input type="email" name="email"> 
<!--               value="<?php echo $_COOKIE[$cookie_userName]; ?>"-->
               <br>
        </div>
         
         
        <div class="form-row">
        <label>Password:</label>
        <input type="password" name="password">
        <br>
        </div>
        <input type="hidden" name="controllerRequest" value="login_successful">         
        <input type="submit" value="Login" id="button"><br>  
        
    </form>
     
     <a href="user_manager/?controllerRequest=user_show_fogot_password_form">Forgot Password?</a> 
    </main>
    <?php require_once '../view/footer.php';?> 
    



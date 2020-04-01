<?php 
if(session_id() == ''){
    $lifetime = 60 * 60 * 24 * 14;    //two weeks
    session_set_cookie_params($lifetime, '/');
    session_start();     
}
?>
<?php require_once '../view/header.php';?>
 <main>
     <h1>Set New Password</h1>
     
     <form action="./user_manager/index.php" method="post">
        <div class="form-row">
        <label>Email:</label>
        <input type="email" name="email"> 
<!--               value="<?php echo $_COOKIE[$cookie_userName]; ?>"-->
               <br>
        </div>                
         
         <input type="hidden" name="controllerRequest" value="reset_password_submit">
        
        <input type="submit" value="Reset Password" id="button"><br>  
        
    </form>
     
    </main>
    <?php require_once '../view/footer.php';?> 
    



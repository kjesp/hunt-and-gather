  <?php 

if(session_id() == ''){
    $lifetime = 60 * 60 * 24 * 14;    //two weeks
    session_set_cookie_params($lifetime, '/');
    session_start();    
}
?>      

<?php require_once '../view/header.php';?>        
   
    <?php echo $errorMessage?>
<h3>Please enter the following information to register</h3>
    <form action="user_manager/index.php" method="post">
         
         <div class="form-row">
        <label>Email:</label>
        <input type="email" name="email" ><br>
        </div>
         <div class="form-row">
        <label>Password:</label>
        <input type="password" name="pw" ><br>
        </div>        
        <div class="form-row">
        <label>City:</label>
        <input type="text" name="city" ><br>
        </div>
        <div class="form-row">
        <label>State:</label>
        <input type="text" name="state" ><br>
        </div>
        <div class="form-row">
        <label>Zip:</label>
        <input type="text" name="zip" ><br>
        </div>
              
        <input type="submit" value="Register" id="button"><br>  
        
        <input type="hidden" name="controllerRequest" 
                value="register_user">
    </form>
    
    <?php require_once '../view/footer.php';?> 

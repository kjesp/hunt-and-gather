<?php
require('../model/database.php');
require('../model/user.php');
require('../model/user_db.php');

$controllerChoice = filter_input(INPUT_POST, 'controllerRequest');
if($controllerChoice == NULL){
    $controllerChoice = filter_input(INPUT_GET, 'controllerRequest');
        if ($controllerChoice == NULL) {
            $controllerChoice = "";           
        } 
}
         

switch($controllerChoice) {
     
    case "user_show_login_form":
        $errorMessage = "";    
        require_once('user_login_form.php');
        break;
    
//        case "user_edit_process":
//        //get inputs
//        $id = filter_input(INPUT_POST, 'user_id');  
//        $userRoleId = 1;
//        $first = filter_input(INPUT_POST, 'first');
//        $last = filter_input(INPUT_POST, 'last'); 
//        $pw = filter_input(INPUT_POST, 'pw');  
//        $email = filter_input(INPUT_POST, 'email');   
//        $address = filter_input(INPUT_POST, 'address');
//        $city = filter_input(INPUT_POST, 'city');     
//        $state = filter_input(INPUT_POST, 'state'); 
//        $zip = filter_input(INPUT_POST, 'postalCode');
//        $phone = filter_input(INPUT_POST, 'phone');   
//        $isActive = 1;
//
//        //validate
//        if ($first == null|| 
//            $pw == null ||
//            $first == null || 
//            $last == null || 
//            $pw == null || 
//            $email == null || 
//            $address == null || 
//            $city == null ||
//            $state == null ||
//            $zip == null ||
//            $phone == null       ) {
//        $errorMessage = "Invalid user data. Check all fields and try again.";
//        include('../errors/error.php');
//        } else {
//            //if valid, update in database
//            $wl = new User($id, $userRoleId, $first, $last, $pw, $email, $address, 
//            $city, $state, $zip, $phone, $isActive);
//            UserDB::update_user($wl);
//        }
//            //send to home      
//    //        require_once '../index.php';
//    //        require_once 'user_list.php';
//        break;
        
    case "user_show_register_form":
        $errorMessage = ""; 
        require_once('user_register_form.php');
        break;
    
    case "register_user":
        $errorMessage = "";
        $id = 0;
        $userRoleId = 1;
        
        $email = filter_input(INPUT_POST, 'email');
        $pw = filter_input(INPUT_POST, 'pw');
        $city = filter_input(INPUT_POST, 'city');
        $state = filter_input(INPUT_POST, 'state');
        $zip = filter_input(INPUT_POST, 'zip');
        
        $user = new User($id, $userRoleId, $email, $pw, $city, $state, $zip );
        
        //see if email is already in database - if so reload page
        //with error message. If not, add to database.
        $isDuplicate = UserDB::is_duplicate_email($email);
        
        if($isDuplicate){
            $errorMessage = "That email address is already registered."
                    . "Please choose a different email or reset your password.";
            require_once('user_register_form.php');
        }
        else{       
            UserDB::add_user($user);
            require_once('user_register_success.php');
        }
                
        break;
    
    case "user_process_login":
        require_once '../index.php';
        break;
    
    case "user_show_fogot_password_form":
        require_once 'user_forgot_password_form.php';
        break;
    
    case "reset_password_submit":
        require_once 'user_password_email_sent.php';
        break;
    
    case "login_successful":
        require_once'../index.php';
        break;
    
    default:
        require_once '../view/header.php';
        echo '<h2> controllerChoice: $controllerChoice</h2>';
        echo'<h3> File: user_manager/index.php</h3>';
        require_once '../view/footer.php';   
}


/**********************************************************************************************************************/
//else if($controllerChoice == "log_out"){
//    $errorMessage = "";
//    
//    if (isset($_SESSION['loggedIn'])){
//        $_SESSION = array();
//
//        // Clean up session ID
//        session_destroy();
//        
//        // Delete the cookie for the session
//        $name = session_name();                // Get name of the session cookie
//        $expire = strtotime('-1 year');        // Create expiration date in the past
//        $params = session_get_cookie_params(); // Get session params
//        $path = $params['path'];
//        $domain = $params['domain'];
//        $secure = $params['secure'];
//        $httponly = $params['httponly'];
//        setcookie($name, '', $expire, $path, $domain, $secure, $httponly);
//    } 
//    require_once 'user_login_form.php';
//    
//}

/**************************************************************************************/
//else if($controllerChoice == "user_process_login"){    
//    $errorMessage = "";    
//            
//     //get inputs      
//    $email = filter_input(INPUT_POST, 'email');
//    $pw = filter_input(INPUT_POST, 'password');     
//    
//    //validate
//    if($email == null ||  $pw == null)    {
//        $errorMessage = "Please enter email and password";
//        require_once 'user_login_form.php';
//    }
//    else
//    {       
//        setcookie($cookie_userName, $email, time() + (86400 * 30), "/");
//        setcookie($cookie_pw, $pw, time() + (86400 * 30), "/");
//        
//    }
//        
//    $wl = UserDB::get_user_by_email_and_password($email, $pw);   
//                   
//        $ID = $wl->getId();            
//    
//        if($ID > 0)    {
//           //login successful, go to edit form
//            $email = $wl->getEmail();
//            $pw = $wl->getPw();
//            $first = $wl->getFirst();
//            $last = $wl->getLast();
//            $address = $wl->getAddress();
//            $city = $wl->getCity();
//            $state = $wl->getState();
//            $postalCode = $wl->getZip();
//            $isActive = $wl->getStatus();
//            $user_id = $wl->getId();
//            
//            
//            
//            $_SESSION['loggedIn'] = true; 
//            $_SESSION['fullName'] = $first." ".$last;
//            $_SESSION['id'] = $user_id;
//            $_SESSION['user'] = $wl;
//            
//            
//            $idCookie = 'userId';
//            $value = $email;
//            $expire = strtotime('+1 year');
//            $path = '/';
//            setcookie($idCookie, $value, $expire, $path);
//            
//            require_once 'edit_user_form.php';
//        }
//        else
//        {
//            $errorMessage = "Invalid login or password";
//            require_once 'user_login_form.php';
//        }
//    
//    require_once '../index.php';
//    
//}
/***************************************************************************************/

?>

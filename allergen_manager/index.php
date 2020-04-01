<?php
require('../model/database.php');
require('../model/allergen.php');
require('../model/allergen_db.php');

$controllerChoice = filter_input(INPUT_POST, 'controllerRequest');
if ($controllerChoice == NULL) {
    $controllerChoice = filter_input(INPUT_GET, 'controllerRequest');
    if ($controllerChoice == NULL) {
        $controllerChoice = "";
    }
}  
switch($controllerChoice) {
       
    case "allergen_add_submit":
        
        $id=0;
        
        $allergenRequested = filter_input(INPUT_POST, 'allergen_requested');        
        
        $allergen = new Allergen($id, $allergenRequested);
        
        AllergenDB::add_allergen($allergen);
        
        require_once('allergen_request_success.php');
        break;

    default:
        require_once '../view/header.php';
        echo '<h2> controllerChoice: $controllerChoice</h2>';
        echo'<h3> File: user_manager/index.php</h3>';
        require_once '../view/footer.php';

}

?>
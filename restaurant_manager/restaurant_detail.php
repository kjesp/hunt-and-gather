  <?php 

if(session_id() == ''){
    $lifetime = 60 * 60 * 24 * 14;    //two weeks
    session_set_cookie_params($lifetime, '/');
    session_start();    
}

$restaurant = $_SESSION['restaurant']; 
$meals = $_SESSION['meals']; 
?>
      

<?php require_once '../view/header.php';?>     

<h1>Meals Available at <?php echo $restaurant->getName()?></h1>

    <table class="mealTable">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Verified?</th>
            <th></th>
        </tr>
                
        <?php foreach ($meals as $meal) : ?>
        
            <tr>                            
                <td class="right" ><?php echo $meal->getId(); ?></td>
                <td class="right"><?php echo $meal->getName(); ?></td>                                
                <td class="right"><?php                    
                    $officialInt = $meal->getIs_official();
                    $isOfficialMessage = "Verified";
                    $isNotOfficialMessage = "Unverified";
                    if($officialInt == 1)
                        echo $isOfficialMessage;                    
                    else
                        echo $isNotOfficialMessage;?></td>
                
                
                <td><form action="meal_manager/index.php" method="post">
                        <input type="hidden" name="meal_id"
                               value="<?php echo $meal->getId(); ?>">
                        <input type="hidden" name="controllerRequest" 
                value="get_meal_details">
                        <input type="submit" value="Details">                        
                    </form></td>
                           
            </tr>
            <?php endforeach; ?>
    
    </table>
    
    <?php require_once '../view/footer.php';?> 

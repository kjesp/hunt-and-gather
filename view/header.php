 <!DOCTYPE html>
<html>
<head>
    <title>Hunt | Gather</title>
    <base href="http://localhost/projects/Hunt_Gather/">    
     <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="./include/main.css" type="text/css">
    <script src="./js/js.js"></script>
</head>

<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                 <li><a class="nav-item" href="index.php">
                        <img src="./images/logo.png" alt="Logo"
                              <?php   
                    $_SESSION['allergensChosen'] = "";
                    $_SESSION['findChosen'] = "";
                    $_SESSION['meals'] = "";
                    $_SESSION['restaurants'] = "";
                    $_SESSION['message'] = "";
                    $_SESSION['allergenIDArray'] = "";
                    ?>>
                    </a>
                 </li>
                <li class="nav-item"><a class="nav-link" href="user_manager/?controllerRequest=user_show_login_form">Log In</a></li>
                <li class="nav-item"><a class="nav-link" href="user_manager/?controllerRequest=user_show_register_form">Register</a></li>
                <li class="nav-item"><a class="nav-link" href="user_manager/?controllerRequest=log_out">Log Out</a></li>
                
            </ul>
      </div>
    </nav>
</header>


<body>
    <div class="container-fluid">
        